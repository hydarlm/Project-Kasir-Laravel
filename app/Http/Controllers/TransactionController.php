<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }

    public function create()
    {
        $products = Product::with('category')->get();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);

            // Validasi stok
            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Stok produk tidak mencukupi! Stok tersedia: ' . $product->stock);
            }

            // Buat transaksi
            $transaction = Transaction::create([
                'transaction_id' => 'TRX-' . time(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'date' => $request->date
            ]);

            // Kurangi stok produk
            $product->decrement('stock', $request->quantity);

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil ditambahkan. Stok produk diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with('product.category')->findOrFail($id);
        return response()->json($transaction);
    }

    public function edit($id)
    {
        $transaction = Transaction::with('product.category')->findOrFail($id);
        $products = Product::with('category')->get();
        return view('transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($id);
            $newProduct = Product::findOrFail($request->product_id);
            $oldProduct = Product::find($transaction->product_id);

            // Validasi stok untuk produk baru
            if ($newProduct->id != $transaction->product_id) {
                if ($newProduct->stock < $request->quantity) {
                    return back()->with('error', 'Stok produk baru tidak mencukupi! Stok tersedia: ' . $newProduct->stock);
                }
            } else {
                // Jika produk sama, hitung selisih kebutuhan stok
                $stockNeeded = $request->quantity - $transaction->quantity;
                if ($stockNeeded > $newProduct->stock) {
                    return back()->with('error', 'Stok tidak mencukupi untuk penambahan jumlah! Stok tersedia: ' . $newProduct->stock);
                }
            }

            // Kembalikan stok produk lama (jika produk berubah)
            if ($oldProduct && $newProduct->id != $transaction->product_id) {
                $oldProduct->increment('stock', $transaction->quantity);
            }

            // Update transaksi
            $transaction->update([
                'product_id' => $newProduct->id,
                'quantity' => $request->quantity,
                'price' => $newProduct->price,
                'date' => $request->date
            ]);

            // Kurangi stok produk baru
            if ($newProduct->id != $transaction->product_id) {
                $newProduct->decrement('stock', $request->quantity);
            } else {
                // Jika produk sama, sesuaikan stok berdasarkan selisih quantity
                $newProduct->decrement('stock', ($request->quantity - $transaction->quantity));
            }

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui. Stok produk diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($id);
            $product = Product::find($transaction->product_id);

            // Kembalikan stok produk
            if ($product) {
                $product->increment('stock', $transaction->quantity);
            }

            $transaction->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus. Stok produk dikembalikan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        try {
            DB::beginTransaction();

            $transactions = Transaction::whereIn('id', $request->ids)->get();

            foreach ($transactions as $transaction) {
                $product = Product::find($transaction->product_id);
                if ($product) {
                    $product->increment('stock', $transaction->quantity);
                }
                $transaction->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi yang dipilih berhasil dihapus. Stok produk dikembalikan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTransactions(Request $request)
    {
        $query = Transaction::with(['product.category'])
            ->select(
                'transactions.*',
                'products.name as product_name',
                'categories.name as category_name',
                DB::raw('(transactions.quantity * transactions.price) as total')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id');

        // Filter pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('transactions.transaction_id', 'like', '%'.$request->search.'%')
                  ->orWhere('products.name', 'like', '%'.$request->search.'%');
            });
        }

        // Filter tanggal
        if ($request->date_from) {
            $query->where('transactions.date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->where('transactions.date', '<=', $request->date_to);
        }

        // Filter kategori
        if ($request->category) {
            $query->where('categories.name', $request->category);
        }

        // Pagination
        $transactions = $query->orderBy('transactions.date', 'desc')
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'transactions' => $transactions,
            'stats' => [
                'total_transactions' => Transaction::count(),
                'total_revenue' => Transaction::sum(DB::raw('quantity * price')),
                'today_transactions' => Transaction::whereDate('date', today())->count(),
                'total_items' => Transaction::sum('quantity')
            ]
        ]);
    }
}
