@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Detail Produk</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="flex items-center justify-center h-48 w-full bg-white rounded-lg border border-gray-200">
                    <i class="fas fa-box text-5xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div>
            <div class="space-y-4">
                <div>
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-500">{{ $product->category->name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Harga</p>
                        <p class="font-semibold">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Stok</p>
                        <p class="font-semibold">{{ $product->stock }} unit</p>
                    </div>
                </div>

                @if($product->description)
                <div>
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="whitespace-pre-line">{{ $product->description }}</p>
                </div>
                @endif

                <div class="pt-4 flex space-x-3">
                    <a href="{{ route('products.edit', $product->id) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
