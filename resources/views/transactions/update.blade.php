@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Update Transaksi</h1>
        <div class="flex space-x-2">
            <x-button-secondary onclick="window.location.href='{{ route('transactions.index') }}'">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </x-button-secondary>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <form class="space-y-6" x-data="updateTransactionForm()" @submit.prevent="submitUpdate()">

            <!-- Step 1: Cari Transaksi -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h3 class="text-lg font-medium text-blue-900 mb-4">
                    <i class="fas fa-search mr-2"></i>
                    Cari Transaksi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-form-label for="transaction_id" required>ID Transaksi</x-form-label>
                        <x-input-field name="transaction_id" x-model="transactionId"
                                       placeholder="Masukkan ID transaksi" required />
                    </div>
                    <div class="flex items-end">
                        <x-button-primary type="button" @click="searchTransaction()"
                                          x-bind:disabled="!transactionId">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </x-button-primary>
                    </div>
                </div>
            </div>

            <!-- Step 2: Data Transaksi yang Ditemukan -->
            <div x-show="transactionFound" class="bg-green-50 p-4 rounded-lg border border-green-200">
                <h3 class="text-lg font-medium text-green-900 mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    Data Transaksi Ditemukan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Transaksi:</span>
                            <span class="font-medium" x-text="currentTransaction.id"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-medium" x-text="currentTransaction.date"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Barang:</span>
                            <span class="font-medium" x-text="currentTransaction.productName"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kategori:</span>
                            <span class="font-medium" x-text="currentTransaction.category"></span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Saat Ini:</span>
                            <span class="font-medium text-blue-600" x-text="currentTransaction.quantity"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga Satuan:</span>
                            <span class="font-medium" x-text="currentTransaction.price"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Saat Ini:</span>
                            <span class="font-bold text-lg" x-text="currentTransaction.total"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stock Tersedia:</span>
                            <span class="font-medium text-green-600" x-text="currentTransaction.availableStock"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Form Update -->
            <div x-show="transactionFound" class="bg-white p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-edit mr-2"></i>
                    Update Data Transaksi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <x-form-label for="new_quantity" required>Jumlah Baru</x-form-label>
                            <x-input-field type="number" name="new_quantity" x-model="newQuantity"
                                           min="1" required @input="calculateNewTotal()" />
                            <div x-show="newQuantity <= 0" class="mt-1 text-sm text-red-600">
                                Jumlah harus lebih dari 0
                            </div>
                            <div x-show="newQuantity > maxQuantity" class="mt-1 text-sm text-red-600">
                                Jumlah tidak boleh melebihi stock tersedia + jumlah saat ini
                            </div>
                        </div>

                        <div>
                            <x-form-label for="new_date">Tanggal Transaksi</x-form-label>
                            <x-input-field type="date" name="new_date" x-model="newDate" />
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <x-form-label for="new_total">Total Baru</x-form-label>
                            <x-input-field name="new_total" x-model="newTotal" readonly
                                           class="bg-gray-50 text-gray-600 font-semibold text-lg" />
                        </div>

                        <div>
                            <x-form-label for="quantity_difference">Selisih Jumlah</x-form-label>
                            <x-input-field name="quantity_difference" x-model="quantityDifference" readonly
                                           class="bg-gray-50 text-gray-600" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Perubahan -->
            <div x-show="transactionFound && hasChanges" class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <h3 class="text-lg font-medium text-yellow-900 mb-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Ringkasan Perubahan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Sebelum:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>Jumlah: <span x-text="currentTransaction.quantity"></span></li>
                            <li>Total: <span x-text="currentTransaction.total"></span></li>
                            <li>Tanggal: <span x-text="currentTransaction.date"></span></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Sesudah:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>Jumlah: <span x-text="newQuantity"></span></li>
                            <li>Total: <span x-text="newTotal"></span></li>
                            <li>Tanggal: <span x-text="newDate"></span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('transactions.update', $transaction['id']) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form-label for="name" required>Nama Barang</x-form-label>
                <x-input-field id="name" name="name" value="{{ $transaction['name'] }}" required />

                <x-button-primary type="submit">
                    Simpan Perubahan
                </x-button-primary>
            </form>
            {{-- <div class="flex justify-end space-x-3 pt-6 border-t">
                <x-button-secondary onclick="window.location.href='{{ route('transactions.index') }}'">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </x-button-secondary>
                <x-button-primary type="button" @click="resetForm()" class="bg-gray-600 hover:bg-gray-700">
                    <i class="fas fa-undo mr-2"></i>
                    Reset
                </x-button-primary>
                <x-button-primary type="submit" x-bind:disabled="!canUpdate" x-show="transactionFound">
                    <i class="fas fa-save mr-2"></i>
                    Update Transaksi
                </x-button-primary>
            </div> --}}
        </form>
    </div>
</div>

<script>
    function updateTransactionForm() {
        return {
            transactionId: '',
            transactionFound: false,
            newQuantity: 1,
            newDate: '',
            newTotal: '',
            quantityDifference: '',
            currentTransaction: {},

            // Mock data untuk simulasi
            mockTransactions: {
                '001': {
                    id: '001',
                    date: '2024-01-15',
                    productName: 'Laptop Asus',
                    category: 'Elektronik',
                    quantity: 1,
                    price: 'Rp 8.500.000',
                    rawPrice: 8500000,
                    total: 'Rp 8.500.000',
                    availableStock: 15
                },
                '002': {
                    id: '002',
                    date: '2024-01-16',
                    productName: 'Mouse Logitech',
                    category: 'Elektronik',
                    quantity: 2,
                    price: 'Rp 250.000',
                    rawPrice: 250000,
                    total: 'Rp 500.000',
                    availableStock: 25
                },
                '003': {
                    id: '003',
                    date: '2024-01-17',
                    productName: 'Keyboard Mechanical',
                    category: 'Elektronik',
                    quantity: 1,
                    price: 'Rp 750.000',
                    rawPrice: 750000,
                    total: 'Rp 750.000',
                    availableStock: 10
                }
            },

            get maxQuantity() {
                if (this.currentTransaction.availableStock) {
                    return this.currentTransaction.availableStock + this.currentTransaction.quantity;
                }
                return 0;
            },

            get hasChanges() {
                return this.newQuantity != this.currentTransaction.quantity ||
                       this.newDate != this.currentTransaction.date;
            },

            get canUpdate() {
                return this.transactionFound &&
                       this.newQuantity > 0 &&
                       this.newQuantity <= this.maxQuantity &&
                       this.hasChanges;
            },

            searchTransaction() {
                if (!this.transactionId) {
                    alert('Masukkan ID transaksi terlebih dahulu');
                    return;
                }

                // Simulasi pencarian di backend
                const transaction = this.mockTransactions[this.transactionId];

                if (transaction) {
                    this.currentTransaction = { ...transaction };
                    this.newQuantity = transaction.quantity;
                    this.newDate = transaction.date;
                    this.newTotal = transaction.total;
                    this.quantityDifference = '0';
                    this.transactionFound = true;

                    // Scroll ke form update
                    setTimeout(() => {
                        document.querySelector('[x-show="transactionFound"]').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }, 100);
                } else {
                    alert('Transaksi dengan ID ' + this.transactionId + ' tidak ditemukan');
                    this.transactionFound = false;
                }
            },

            calculateNewTotal() {
                if (this.currentTransaction.rawPrice && this.newQuantity > 0) {
                    const totalAmount = this.currentTransaction.rawPrice * this.newQuantity;
                    this.newTotal = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(totalAmount);

                    // Hitung selisih jumlah
                    const diff = this.newQuantity - this.currentTransaction.quantity;
                    this.quantityDifference = diff > 0 ? '+' + diff : diff.toString();
                } else {
                    this.newTotal = '';
                    this.quantityDifference = '';
                }
            },

            resetForm() {
                this.transactionId = '';
                this.transactionFound = false;
                this.newQuantity = 1;
                this.newDate = '';
                this.newTotal = '';
                this.quantityDifference = '';
                this.currentTransaction = {};
            },

            submitUpdate() {
                if (!this.canUpdate) {
                    alert('Mohon periksa kembali data yang akan diupdate');
                    return;
                }

                const updateData = {
                    id: this.transactionId,
                    oldQuantity: this.currentTransaction.quantity,
                    newQuantity: this.newQuantity,
                    oldDate: this.currentTransaction.date,
                    newDate: this.newDate,
                    oldTotal: this.currentTransaction.total,
                    newTotal: this.newTotal,
                    difference: this.quantityDifference
                };

                // Simulasi update data
                console.log('Data update:', updateData);

                if (confirm('Apakah Anda yakin ingin mengupdate transaksi ini?')) {
                    // Update mock data
                    this.mockTransactions[this.transactionId].quantity = this.newQuantity;
                    this.mockTransactions[this.transactionId].date = this.newDate;
                    this.mockTransactions[this.transactionId].total = this.newTotal;

                    alert('Transaksi berhasil diupdate!');
                    // Di sini akan ada proses submit ke backend
                    window.location.href = '{{ route("transactions.index") }}';
                }
            }
        }
    }
</script>
@endsection
