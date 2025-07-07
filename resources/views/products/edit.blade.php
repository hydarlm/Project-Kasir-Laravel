@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
            <div>
                <h1 class="text-2xl text-center sm:text-3xl font-bold text-gray-900 mb-2">Edit Produk</h1>
                <p class="text-sm text-center sm:text-base text-gray-600">Perbarui informasi produk</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 lg:p-8">
            <form action="{{ route('products.update', $product->id) }}" method="POST" id="productForm">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Product Name --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="name" required>Nama Produk</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400 text-sm"></i>
                            </div>
                            <x-input-field
                                name="name"
                                placeholder="Masukkan nama produk"
                                required
                                class="pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm sm:text-base"
                                value="{{ old('name', $product->name) }}"
                            />
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="price" required>Harga</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-medium text-sm sm:text-base">Rp</span>
                            </div>
                            <x-input-field
                                type="number"
                                name="price"
                                placeholder="0"
                                required
                                min="0"
                                step="1000"
                                class="pl-10 sm:pl-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm sm:text-base"
                                value="{{ old('price', $product->price) }}"
                            />
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="stock" required>Stok</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-cubes text-gray-400 text-sm"></i>
                            </div>
                            <x-input-field
                                type="number"
                                name="stock"
                                placeholder="0"
                                required
                                min="0"
                                class="pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm sm:text-base"
                                value="{{ old('stock', $product->stock) }}"
                            />
                        </div>
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="category_id" required>Kategori</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                <i class="fas fa-tags text-gray-400 text-sm"></i>
                            </div>
                            <select
                                name="category_id"
                                id="category_id"
                                class="block w-full pl-10 pr-10 py-2.5 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none text-sm sm:text-base"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="description">Deskripsi <span class="text-gray-400">(Opsional)</span></x-form-label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-vertical text-sm sm:text-base"
                            placeholder="Masukkan deskripsi produk (opsional)"
                        >{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row sm:justify-between pt-6 mt-6 sm:mt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 order-2 sm:order-1 mt-6 sm:mt-0">
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors w-full sm:w-auto">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 order-1 sm:order-2">
                        <x-button-secondary type="button" onclick="resetForm()" class="w-full sm:w-auto">
                            <i class="fas fa-times mr-2"></i>
                            Reset
                        </x-button-secondary>
                        <x-button-primary type="submit" id="submitBtn" class="w-full sm:w-auto">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </x-button-primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const submitBtn = document.getElementById('submitBtn');

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    });

    // Reset form function
    window.resetForm = function() {
        if (confirm('Apakah Anda yakin ingin mengembalikan ke nilai awal?')) {
            // Reset form to original values
            form.reset();
        }
    };

    // Auto-focus first input (only on desktop)
    if (window.innerWidth > 768) {
        document.querySelector('input[name="name"]').focus();
    }
});
</script>
@endsection
