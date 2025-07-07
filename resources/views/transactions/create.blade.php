@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
            <div>
                <h1 class="text-2xl text-center sm:text-3xl font-bold text-gray-900 mb-2">Tambah Transaksi Baru</h1>
                <p class="text-sm text-center sm:text-base text-gray-600">Masukkan informasi transaksi penjualan</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 lg:p-8">
            <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                @csrf

                <div class="space-y-6">
                    {{-- Product Selection --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="product_id" required>Pilih Produk</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400 text-sm"></i>
                            </div>
                            <select
                                name="product_id"
                                id="product_id"
                                required
                                class="block w-full pl-10 pr-10 py-2.5 sm:py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none text-sm sm:text-base"
                            >
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                        data-category="{{ $product->category->name }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('product_id')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Product Details (Readonly) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Category --}}
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Kategori</p>
                            <p id="categoryDisplay" class="text-base font-medium text-gray-900">-</p>
                        </div>

                        {{-- Price --}}
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Harga Satuan</p>
                            <p id="priceDisplay" class="text-base font-medium text-gray-900">Rp 0</p>
                            <input type="hidden" name="price" id="priceInput">
                        </div>

                        {{-- Available Stock --}}
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Stok Tersedia</p>
                            <p id="stockDisplay" class="text-base font-medium text-gray-900">0</p>
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="quantity" required>Jumlah</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400 text-sm"></i>
                            </div>
                            <x-input-field
                                type="number"
                                name="quantity"
                                id="quantity"
                                placeholder="0"
                                required
                                min="1"
                                class="pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm sm:text-base"
                                value="{{ old('quantity', 1) }}"
                            />
                        </div>
                        <p id="quantityError" class="mt-1 text-sm text-red-600 hidden">Jumlah melebihi stok tersedia</p>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div class="transform transition-transform duration-200 hover:scale-[1.01] sm:hover:scale-[1.02]">
                        <x-form-label for="date" required>Tanggal Transaksi</x-form-label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400 text-sm"></i>
                            </div>
                            <x-input-field
                                type="date"
                                name="date"
                                id="date"
                                required
                                class="pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm sm:text-base"
                                value="{{ old('date', date('Y-m-d')) }}"
                            />
                        </div>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Price Preview --}}
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-medium text-blue-800">Total Harga</p>
                            <p id="totalDisplay" class="text-xl font-bold text-blue-600">Rp 0</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row sm:justify-between pt-6 mt-6 sm:mt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 order-2 sm:order-1 mt-6 sm:mt-0">
                        <a href="{{ route('transactions.index') }}"
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
                            Simpan Transaksi
                        </x-button-primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transactionForm');
    const submitBtn = document.getElementById('submitBtn');
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const categoryDisplay = document.getElementById('categoryDisplay');
    const priceDisplay = document.getElementById('priceDisplay');
    const priceInput = document.getElementById('priceInput');
    const stockDisplay = document.getElementById('stockDisplay');
    const totalDisplay = document.getElementById('totalDisplay');
    const quantityError = document.getElementById('quantityError');

    // Update product details when product selection changes
    function updateProductDetails() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = selectedOption ? parseFloat(selectedOption.dataset.price) : 0;
        const category = selectedOption ? selectedOption.dataset.category : '-';
        const stock = selectedOption ? parseInt(selectedOption.dataset.stock) : 0;
        const quantity = parseInt(quantityInput.value) || 0;

        // Update displays
        categoryDisplay.textContent = category;
        priceDisplay.textContent = 'Rp ' + price.toLocaleString('id-ID');
        priceInput.value = price;
        stockDisplay.textContent = stock;

        // Calculate and update total
        const total = price * quantity;
        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Validate quantity
        if (quantity > stock) {
            quantityError.classList.remove('hidden');
            submitBtn.disabled = true;
        } else {
            quantityError.classList.add('hidden');
            submitBtn.disabled = false;
        }
    }

    // Event listeners
    productSelect.addEventListener('change', updateProductDetails);
    quantityInput.addEventListener('input', updateProductDetails);

    // Initial update
    updateProductDetails();

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        // Final quantity validation
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stock = selectedOption ? parseInt(selectedOption.dataset.stock) : 0;
        const quantity = parseInt(quantityInput.value) || 0;

        if (quantity > stock) {
            e.preventDefault();
            quantityError.classList.remove('hidden');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    });

    // Reset form function
    window.resetForm = function() {
        if (confirm('Apakah Anda yakin ingin membatalkan? Semua data yang telah diisi akan hilang.')) {
            form.reset();
            productSelect.selectedIndex = 0;
            quantityInput.value = 1;
            updateProductDetails();
        }
    };

    // Auto-focus product select on desktop
    if (window.innerWidth > 768) {
        productSelect.focus();
    }
});
</script>
@endsection
