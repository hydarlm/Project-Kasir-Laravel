{{-- File: resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Produk</h1>

        {{-- Update button untuk ke halaman create --}}
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Produk
        </a>
    </div>

    {{-- Alert Success --}}
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

    <x-data-table :headers="['Nama Barang', 'Harga', 'Stok', 'Kategori', 'Aksi']">
        @if(isset($products) && count($products) > 0)
            @foreach($products as $product)
                <tr class="odd:bg-white even:bg-gray-50 border-b hover:bg-gray-50 transition-colors">
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
                            {{ ucfirst($product->category) }}
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
            @endforeach
        @else
            <tr class="odd:bg-white even:bg-gray-50 border-b">
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
        @endif
    </x-data-table>
</div>
@endsection
