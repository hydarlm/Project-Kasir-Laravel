@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Insert Transaksi Baru</h1>
        <div class="flex space-x-2">
            <x-button-secondary onclick="window.location.href='{{ route('transactions.index') }}'">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </x-button-secondary>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <form class="space-y-6" x-data="insertTransactionForm()" @submit.prevent="submitTransaction()">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div>
                        <x-form-label for="product_select" required>Nama Barang</x-form-label>
                        <select name="product_select" x-model="selectedProduct" @change="updateProductInfo()"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih Produk</option>
                            <option value="laptop">Laptop Asus</option>
                            <option value="mouse">Mouse Logitech</option>
                            <option value="keyboard">Keyboard Mechanical</option>
                            <option value="monitor">Monitor 24 inch</option>
                            <option value="headphone">Headphone Sony</option>
                        </select>
                        <div x-show="selectedProduct === ''" class="mt-1 text-sm text-red-600">
                            Pilih produk terlebih dahulu
                        </div>
                    </div>

                    <div>
                        <x-form-label for="quantity" required>Jumlah</x-form-label>
                        <x-input-field type="number" name="quantity" x-model="quantity" min="1" required
                                       @input="calculateTotal()" />
                        <div x-show="quantity <= 0" class="mt-1 text-sm text-red-600">
                            Jumlah harus lebih dari 0
                        </div>
                        <div x-show="quantity > parseInt(stock)" class="mt-1 text-sm text-red-600">
                            Jumlah tidak boleh melebihi stock tersedia
                        </div>
                    </div>

                    <div>
                        <x-form-label for="transaction_date" required>Tanggal Transaksi</x-form-label>
                        <x-input-field type="date" name="transaction_date" x-model="transactionDate" required />
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div>
                        <x-form-label for="price">Harga Satuan</x-form-label>
                        <x-input-field name="price" x-model="price" readonly
                                       class="bg-gray-50 text-gray-600" />
                    </div>

                    <div>
                        <x-form-label for="stock">Stock Tersedia</x-form-label>
                        <x-input-field name="stock" x-model="stock" readonly
                                       class="bg-gray-50 text-gray-600" />
                    </div>

                    <div>
                        <x-form-label for="category">Kategori Barang</x-form-label>
                        <x-input-field name="category" x-model="category" readonly
                                       class="bg-gray-50 text-gray-600" />
                    </div>

                    <div>
                        <x-form-label for="total">Total Harga</x-form-label>
                        <x-input-field name="total" x-model="total" readonly
                                       class="bg-gray-50 text-gray-600 font-semibold text-lg" />
                    </div>
                </div>
            </div>

            <!-- Ringkasan Transaksi -->
            <div x-show="selectedProduct !== ''" class="bg-gray-50 p-4 rounded-lg border">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Ringkasan Transaksi</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Nama Barang:</span>
                        <span class="font-medium ml-2" x-text="getProductName()"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Kategori:</span>
                        <span class="font-medium ml-2" x-text="category"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-medium ml-2" x-text="quantity"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Harga Satuan:</span>
                        <span class="font-medium ml-2" x-text="price"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Stock Tersisa:</span>
                        <span class="font-medium ml-2" x-text="(parseInt(stock) - parseInt(quantity))"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total Harga:</span>
                        <span class="font-bold ml-2 text-lg text-blue-600" x-text="total"></span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <x-button-secondary onclick="window.location.href='{{ route('transactions.index') }}'">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </x-button-secondary>
                <x-button-primary type="button" @click="resetForm()" class="bg-gray-600 hover:bg-gray-700">
                    <i class="fas fa-undo mr-2"></i>
                    Reset
                </x-button-primary>
                <x-button-primary type="submit" x-bind:disabled="!canInsert">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Transaksi
                </x-button-primary>
            </div>
        </form>
    </div>
</div>

<script>
    function insertTransactionForm() {
        return {
            selectedProduct: '',
            quantity: 1,
            price: '',
            stock: '',
            category: '',
            total: '',
            transactionDate: new Date().toISOString().split('T')[0],
            products: {
                laptop: {
                    name: 'Laptop Asus',
                    price: 'Rp 8.500.000',
                    rawPrice: 8500000,
                    stock: '15',
                    category: 'Elektronik'
                },
                mouse: {
                    name: 'Mouse Logitech',
                    price: 'Rp 250.000',
                    rawPrice: 250000,
                    stock: '25',
                    category: 'Elektronik'
                },
                keyboard: {
                    name: 'Keyboard Mechanical',
                    price: 'Rp 750.000',
                    rawPrice: 750000,
                    stock: '10',
                    category: 'Elektronik'
                },
                monitor: {
                    name: 'Monitor 24 inch',
                    price: 'Rp 2.500.000',
                    rawPrice: 2500000,
                    stock: '8',
                    category: 'Elektronik'
                },
                headphone: {
                    name: 'Headphone Sony',
                    price: 'Rp 1.200.000',
                    rawPrice: 1200000,
                    stock: '0',
                    category: 'Elektronik'
                }
            },
            get canInsert() {
                return this.selectedProduct &&
                       this.quantity > 0 &&
                       parseInt(this.stock) > 0 &&
                       this.quantity <= parseInt(this.stock) &&
                       this.transactionDate;
            },
            updateProductInfo() {
                if (this.selectedProduct && this.products[this.selectedProduct]) {
                    const product = this.products[this.selectedProduct];
                    this.price = product.price;
                    this.stock = product.stock;
                    this.category = product.category;
                    this.calculateTotal();
                } else {
                    this.price = '';
                    this.stock = '';
                    this.category = '';
                    this.total = '';
                }
            },
            calculateTotal() {
                if (this.selectedProduct && this.quantity > 0) {
                    const product = this.products[this.selectedProduct];
                    const totalAmount = product.rawPrice * this.quantity;
                    this.total = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(totalAmount);
                } else {
                    this.total = '';
                }
            },
            getProductName() {
                if (this.selectedProduct && this.products[this.selectedProduct]) {
                    return this.products[this.selectedProduct].name;
                }
                return '';
            },
            resetForm() {
                this.selectedProduct = '';
                this.quantity = 1;
                this.price = '';
                this.stock = '';
                this.category = '';
                this.total = '';
                this.transactionDate = new Date().toISOString().split('T')[0];
            },
            submitTransaction() {
                if (!this.canInsert) {
                    alert('Mohon lengkapi semua field yang diperlukan');
                    return;
                }

                const transactionData = {
                    product: this.selectedProduct,
                    productName: this.getProductName(),
                    quantity: this.quantity,
                    price: this.price,
                    total: this.total,
                    date: this.transactionDate,
                    category: this.category
                };

                // Simulasi penyimpanan data
                console.log('Data transaksi:', transactionData);

                if (confirm('Apakah Anda yakin ingin menyimpan transaksi ini?')) {
                    alert('Transaksi berhasil disimpan!');
                    // Di sini akan ada proses submit ke backend
                    window.location.href = '{{ route("transactions.index") }}';
                }
            }
        }
    }
</script>
@endsection
