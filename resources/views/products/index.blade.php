@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Produk</h1>
        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <div>
                    <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 mr-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-box text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $product->name }}</div>
                                    @if($product->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ 'Rp ' . number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($product->stock > 10)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $product->stock }}
                                </span>
                            @elseif($product->stock > 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $product->stock }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="text-green-600 hover:text-green-900 hover:bg-green-50 p-2 rounded-full transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 p-2 rounded-full transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 hover:bg-red-50 p-2 rounded-full transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">Belum ada produk</p>
                                <p class="text-sm">Mulai dengan menambahkan produk pertama Anda</p>
                                <a href="{{ route('products.create') }}"
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter form submission
    const filterForm = document.getElementById('filter-form');
    const filterInputs = filterForm.querySelectorAll('input, select');

    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            filterForm.submit();
        });
    });

    // Bulk actions
    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox:checked');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');

        if (checkboxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = checkboxes.length;
        } else {
            bulkActions.style.display = 'none';
        }
    }

    function selectAll() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = true);
        updateBulkActions();
    }

    function deselectAll() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateBulkActions();
    }

    function updateSelected() {
        const selected = document.querySelectorAll('.transaction-checkbox:checked');
        if (selected.length === 0) {
            alert('Pilih transaksi yang ingin diupdate');
            return;
        }

        if (selected.length > 1) {
            alert('Pilih hanya satu transaksi untuk diupdate');
            return;
        }

        const transactionId = selected[0].value;
        window.location.href = `/transactions/${transactionId}/edit`;
    }

    function deleteSelected() {
        const selected = document.querySelectorAll('.transaction-checkbox:checked');
        if (selected.length === 0) {
            alert('Pilih transaksi yang ingin dihapus');
            return;
        }

        const message = selected.length === 1 ?
            'Apakah Anda yakin ingin menghapus transaksi ini?' :
            `Apakah Anda yakin ingin menghapus ${selected.length} transaksi?`;

        if (confirm(message)) {
            // Submit form untuk setiap transaksi yang dipilih
            selected.forEach(checkbox => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/transactions/${checkbox.value}`;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            });
        }
    }

    // Load transaction detail via AJAX
    function showTransactionDetail(id) {
        fetch(`/transactions/${id}`)
            .then(response => response.json())
            .then(data => {
                const detailContent = document.getElementById('detail-content');
                detailContent.innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="font-medium text-gray-700">Kode Transaksi:</span>
                                <span class="ml-2">${data.transaction_code}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Tanggal:</span>
                                <span class="ml-2">${new Date(data.transaction_date).toLocaleDateString()}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="font-medium text-gray-700">Total:</span>
                                <span class="ml-2 font-bold">Rp ${new Intl.NumberFormat('id-ID').format(data.total)}</span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="font-medium text-gray-900 mb-2">Detail Item:</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        ${data.details.map(detail => `
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">${detail.product.name}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">${detail.product.category.name}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">${detail.quantity}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp ${new Intl.NumberFormat('id-ID').format(detail.price)}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp ${new Intl.NumberFormat('id-ID').format(detail.subtotal)}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;

                // Open modal
                $dispatch('open-modal', 'detail-transaction');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat detail transaksi');
            });
    }
});
</script>
