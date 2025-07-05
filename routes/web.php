<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/products');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

// intergrasi backend
// Route::get('/products/create', function () {
//     return view('products.create');
// })->name('products.create');

Route::get('/products/create', function () {
    return view('products.create', [
        'categories' => [
            'elektronik' => 'Elektronik',
            'fashion' => 'Fashion',
            'makanan' => 'Makanan',
            'olahraga' => 'Olahraga',
            'kesehatan' => 'Kesehatan',
            'otomotif' => 'Otomotif',
        ]
    ]);
})->name('products.create');

// Simulasi submit store (tidak perlu simpan ke DB)
Route::post('/products', function () {
    return redirect()->route('products.create')->with('success', 'Produk berhasil disimpan (dummy)');
})->name('products.store');

// Index dummy juga (untuk tombol Kembali)
Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

// intergrasi backend
// Route::get('/categories/create', function () {
//     return view('categories.create');
// })->name('categories.create');

// Halaman Create Kategori (dummy frontend)
Route::get('/categories/create', function () {
    return view('categories.create');
})->name('categories.create');

// Simulasi penyimpanan kategori (tidak menyimpan data apa pun)
Route::post('/categories', function () {
    return redirect()->route('categories.create')->with('success', 'Kategori berhasil disimpan (dummy)');
})->name('categories.store');

// Optional: halaman index kategori dummy
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');


Route::get('/transactions', function () {
    return view('transactions.index');
})->name('transactions.index');

// Halaman form tambah transaksi (dummy)
Route::get('/transactions/create', function () {
    return view('transactions.insert');
})->name('transactions.create');

// Simulasi penyimpanan transaksi (tidak menyimpan data apa pun)
Route::post('/transactions', function () {
    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan (dummy)');
})->name('transactions.store');


// Halaman form edit transaksi (dummy)
Route::get('/transactions/{id}/edit', function ($id) {
    // Kirim data dummy ke view
    return view('transactions.update', ['transaction' => ['id' => $id, 'name' => 'Contoh Barang']]);
})->name('transactions.edit');



// Simulasi update transaksi (tidak menyimpan data apa pun)
Route::put('/transactions/{id}', function ($id) {
    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui (dummy)');
})->name('transactions.update');
