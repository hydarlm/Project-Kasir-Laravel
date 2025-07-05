@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
            <div>
                <h1 class="text-2xl text-center sm:text-3xl font-bold text-gray-900 mb-2">Tambah Produk Baru</h1>
                <p class="text-sm text-center sm:text-base text-gray-600">Masukkan informasi produk yang akan ditambahkan ke inventory</p>
            </div>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                        <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 lg:p-8">
            <form action="{{ route('products.store') }}" method="POST" id="productForm">
                @csrf

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
                                value="{{ old('name') }}"
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
                                value="{{ old('price') }}"
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
                                value="{{ old('stock') }}"
                            />
                        </div>
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="category" required>Kategori</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                <i class="fas fa-tags text-gray-400 text-sm"></i>
                            </div>
                            <select
                                name="category"
                                id="category"
                                class="block w-full pl-10 pr-10 py-2.5 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none text-sm sm:text-base"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $key => $value)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('category')
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
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Preview Card --}}
                <div class="mt-6 sm:mt-8 bg-gray-50 rounded-lg p-4 sm:p-6" id="previewCard" style="display: none;">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Preview Produk
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Nama Produk</p>
                            <p class="font-semibold text-gray-900 break-words" id="previewName">-</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Harga</p>
                            <p class="font-semibold text-gray-900" id="previewPrice">-</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Stok</p>
                            <p class="font-semibold text-gray-900" id="previewStock">-</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kategori</p>
                            <p class="font-semibold text-gray-900" id="previewCategory">-</p>
                        </div>
                        <div class="col-span-1 sm:col-span-2">
                            <p class="text-gray-600">Deskripsi</p>
                            <p class="font-medium text-gray-900 break-words" id="previewDescription">-</p>
                        </div>
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
                            Batal
                        </x-button-secondary>
                        <x-button-primary type="submit" id="submitBtn" class="w-full sm:w-auto">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Produk
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
    const previewCard = document.getElementById('previewCard');

    // Form inputs
    const inputs = {
        name: document.querySelector('input[name="name"]'),
        price: document.querySelector('input[name="price"]'),
        stock: document.querySelector('input[name="stock"]'),
        category: document.querySelector('select[name="category"]'),
        description: document.querySelector('textarea[name="description"]')
    };

    // Preview elements
    const preview = {
        name: document.getElementById('previewName'),
        price: document.getElementById('previewPrice'),
        stock: document.getElementById('previewStock'),
        category: document.getElementById('previewCategory'),
        description: document.getElementById('previewDescription')
    };

    // Categories mapping
    const categories = {
        'elektronik': 'Elektronik',
        'fashion': 'Fashion',
        'makanan': 'Makanan',
        'olahraga': 'Olahraga',
        'kesehatan': 'Kesehatan',
        'otomotif': 'Otomotif'
    };

    // Format currency
    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    }

    // Update preview
    function updatePreview() {
        const hasContent = inputs.name.value || inputs.price.value || inputs.stock.value || inputs.category.value;

        if (hasContent) {
            preview.name.textContent = inputs.name.value || '-';
            preview.price.textContent = inputs.price.value ? formatCurrency(inputs.price.value) : '-';
            preview.stock.textContent = inputs.stock.value ? inputs.stock.value + ' unit' : '-';
            preview.category.textContent = inputs.category.value ? categories[inputs.category.value] : '-';
            preview.description.textContent = inputs.description.value || 'Tidak ada deskripsi';
            previewCard.style.display = 'block';
        } else {
            previewCard.style.display = 'none';
        }
    }

    // Add event listeners for real-time preview
    Object.values(inputs).forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    });

    // Reset form function
    window.resetForm = function() {
        if (confirm('Apakah Anda yakin ingin membatalkan? Semua data yang telah diisi akan hilang.')) {
            form.reset();
            updatePreview();
        }
    };

    // Auto-focus first input (only on desktop)
    if (window.innerWidth > 768) {
        inputs.name.focus();
    }

    // Initial preview update
    updatePreview();

    // Handle viewport changes for better mobile experience
    function handleViewportChange() {
        if (window.innerWidth <= 768) {
            // Mobile optimizations
            document.querySelectorAll('.hover\\:scale-\\[1\\.02\\]').forEach(el => {
                el.classList.remove('hover:scale-[1.02]');
                el.classList.add('hover:scale-[1.01]');
            });
        }
    }

    window.addEventListener('resize', handleViewportChange);
    handleViewportChange();
});
</script>
@endsection
