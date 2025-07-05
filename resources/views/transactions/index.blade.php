@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Transaksi</h1>
        <div class="flex flex-wrap gap-2">
            <x-button-secondary onclick="loadTransactions()" class="flex-1 sm:flex-none">
                <i class="fas fa-sync-alt mr-2"></i>
                <span class="hidden sm:inline">Refresh</span>
                <span class="sm:hidden">Refresh</span>
            </x-button-secondary>
            <x-button-primary onclick="window.location.href='{{ route('transactions.create') }}'" class="flex-1 sm:flex-none">
                <i class="fas fa-plus mr-2"></i>
                <span class="hidden sm:inline">Tambah</span>
                <span class="sm:hidden">Tambah</span>
            </x-button-primary>
            <x-button-primary onclick="updateSelected()" class="bg-yellow-600 hover:bg-yellow-700 flex-1 sm:flex-none">
                <i class="fas fa-edit mr-2"></i>
                <span class="hidden sm:inline">Update</span>
                <span class="sm:hidden">Update</span>
            </x-button-primary>
            <x-button-primary onclick="deleteSelected()" class="bg-red-600 hover:bg-red-700 flex-1 sm:flex-none">
                <i class="fas fa-trash mr-2"></i>
                <span class="hidden sm:inline">Delete</span>
                <span class="sm:hidden">Hapus</span>
            </x-button-primary>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div class="mb-6 bg-gray-50 p-3 sm:p-4 rounded-lg">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <div class="sm:col-span-2 md:col-span-1">
                <x-form-label for="search">Cari Transaksi</x-form-label>
                <x-input-field type="text" name="search" placeholder="Cari ID, nama barang..."
                               onkeyup="filterTransactions()" />
            </div>
            <div>
                <x-form-label for="date_from">Tanggal Dari</x-form-label>
                <x-input-field type="date" name="date_from" onchange="filterTransactions()" />
            </div>
            <div>
                <x-form-label for="date_to">Tanggal Sampai</x-form-label>
                <x-input-field type="date" name="date_to" onchange="filterTransactions()" />
            </div>
            <div>
                <x-form-label for="category">Kategori</x-form-label>
                <select name="category" onchange="filterTransactions()"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Aksesoris">Aksesoris</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-cyan-600 p-3 sm:p-4 rounded-lg border border-black">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-list text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs sm:text-sm font-medium text-white">Total Transaksi</p>
                    <p class="text-lg sm:text-2xl font-bold text-white" id="total-transactions">0</p>
                </div>
            </div>
        </div>
        <div class="bg-emerald-600 p-3 sm:p-4 rounded-lg border border-black">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs sm:text-sm font-medium text-white">Total Pendapatan</p>
                    <p class="text-lg sm:text-2xl font-bold text-white" id="total-revenue">Rp 0</p>
                </div>
            </div>
        </div>
        <div class="bg-orange-500 p-3 sm:p-4 rounded-lg border border-yellow-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar-day text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs sm:text-sm font-medium text-white">Transaksi Hari Ini</p>
                    <p class="text-lg sm:text-2xl font-bold text-white" id="today-transactions">0</p>
                </div>
            </div>
        </div>
        <div class="bg-rose-500 p-3 sm:p-4 rounded-lg border border-purple-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-box text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs sm:text-sm font-medium text-white">Total Item</p>
                    <p class="text-lg sm:text-2xl font-bold text-white" id="total-items">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="mb-4" id="bulk-actions" style="display: none;">
        <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-yellow-600 mr-2"></i>
                    <span class="text-sm text-yellow-800">
                        <span id="selected-count">0</span> transaksi dipilih
                    </span>
                </div>
                <div class="flex space-x-2">
                    <button onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                        Pilih Semua
                    </button>
                    <button onclick="deselectAll()" class="text-sm text-gray-600 hover:text-gray-800">
                        Batal Pilih
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="overflow-x-auto -mx-4 sm:mx-0">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <x-data-table :headers="['', 'ID', 'Tanggal', 'Nama Barang', 'Kategori', 'Jumlah', 'Harga', 'Total', 'Aksi']">
                    <tbody id="transaction-table-body">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </x-data-table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center justify-center sm:justify-start text-sm text-gray-700">
            Menampilkan <span id="showing-from">1</span> sampai <span id="showing-to">10</span>
            dari <span id="total-records">0</span> transaksi
        </div>
        <div class="flex justify-center sm:justify-end space-x-2">
            <button onclick="previousPage()" class="px-3 py-2 text-sm border rounded hover:bg-gray-100 flex items-center"
                    id="prev-btn" disabled>
                <i class="fas fa-chevron-left mr-1"></i>
                <span class="hidden sm:inline">Sebelumnya</span>
                <span class="sm:hidden">Prev</span>
            </button>
            <button onclick="nextPage()" class="px-3 py-2 text-sm border rounded hover:bg-gray-100 flex items-center"
                    id="next-btn">
                <span class="hidden sm:inline">Selanjutnya</span>
                <span class="sm:hidden">Next</span>
                <i class="fas fa-chevron-right ml-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Detail Transaction Modal -->
<x-modal name="detail-transaction" maxWidth="lg">
    <div class="p-4 sm:p-6" id="transaction-detail">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Transaksi</h3>
        <div id="detail-content">
            <!-- Content will be loaded dynamically -->
        </div>
        <div class="flex justify-end pt-4">
            <x-button-secondary onclick="$dispatch('close-modal', 'detail-transaction')">
                Tutup
            </x-button-secondary>
        </div>
    </div>
</x-modal>

<script>
    // Mock data untuk simulasi
    const mockTransactions = [
        {
            id: '001',
            date: '2024-01-15',
            productName: 'Laptop Asus',
            category: 'Elektronik',
            quantity: 1,
            price: 'Rp 8.500.000',
            rawPrice: 8500000,
            total: 'Rp 8.500.000'
        },
        {
            id: '002',
            date: '2024-01-16',
            productName: 'Mouse Logitech',
            category: 'Elektronik',
            quantity: 2,
            price: 'Rp 250.000',
            rawPrice: 250000,
            total: 'Rp 500.000'
        },
        {
            id: '003',
            date: '2024-01-17',
            productName: 'Keyboard Mechanical',
            category: 'Elektronik',
            quantity: 1,
            price: 'Rp 750.000',
            rawPrice: 750000,
            total: 'Rp 750.000'
        },
        {
            id: '004',
            date: '2024-01-18',
            productName: 'Monitor 24 inch',
            category: 'Elektronik',
            quantity: 1,
            price: 'Rp 2.500.000',
            rawPrice: 2500000,
            total: 'Rp 2.500.000'
        },
        {
            id: '005',
            date: '2024-01-19',
            productName: 'Headphone Sony',
            category: 'Aksesoris',
            quantity: 1,
            price: 'Rp 1.200.000',
            rawPrice: 1200000,
            total: 'Rp 1.200.000'
        }
    ];

    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredTransactions = [...mockTransactions];

    // Load transactions on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadTransactions();
        updateStatistics();
    });

    function loadTransactions() {
        displayTransactions();
        updatePagination();
        updateStatistics();
    }

    function displayTransactions() {
        const tableBody = document.getElementById('transaction-table-body');
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedTransactions = filteredTransactions.slice(start, end);

        tableBody.innerHTML = paginatedTransactions.map(transaction => `
            <tr class="odd:bg-white even:bg-gray-50 border-b hover:bg-gray-100">
                <td class="px-3 sm:px-6 py-3 sm:py-4">
                    <input type="checkbox" class="transaction-checkbox"
                           value="${transaction.id}" onchange="updateBulkActions()">
                </td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 font-medium text-gray-900 text-sm">${transaction.id}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm whitespace-nowrap">${transaction.date}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm">
                    <div class="max-w-xs sm:max-w-none truncate">${transaction.productName}</div>
                </td>
                <td class="px-3 sm:px-6 py-3 sm:py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap
                           ${transaction.category === 'Elektronik' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                        ${transaction.category}
                    </span>
                </td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm text-center">${transaction.quantity}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm whitespace-nowrap">${transaction.price}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 font-semibold text-sm whitespace-nowrap">${transaction.total}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4">
                    <div class="flex space-x-1 sm:space-x-2">
                        <button onclick="showTransactionDetail('${transaction.id}')"
                                class="text-blue-600 hover:text-blue-900 p-1" title="Detail">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                        <button onclick="editTransaction('${transaction.id}')"
                                class="text-yellow-600 hover:text-yellow-900 p-1" title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <button onclick="deleteTransaction('${transaction.id}')"
                                class="text-red-600 hover:text-red-900 p-1" title="Delete">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function updateStatistics() {
        const totalTransactions = filteredTransactions.length;
        const totalRevenue = filteredTransactions.reduce((sum, t) => sum + t.rawPrice * t.quantity, 0);
        const today = new Date().toISOString().split('T')[0];
        const todayTransactions = filteredTransactions.filter(t => t.date === today).length;
        const totalItems = filteredTransactions.reduce((sum, t) => sum + t.quantity, 0);

        document.getElementById('total-transactions').textContent = totalTransactions;
        document.getElementById('total-revenue').textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(totalRevenue);
        document.getElementById('today-transactions').textContent = todayTransactions;
        document.getElementById('total-items').textContent = totalItems;
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
        const start = (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, filteredTransactions.length);

        document.getElementById('showing-from').textContent = start;
        document.getElementById('showing-to').textContent = end;
        document.getElementById('total-records').textContent = filteredTransactions.length;

        document.getElementById('prev-btn').disabled = currentPage === 1;
        document.getElementById('next-btn').disabled = currentPage === totalPages;
    }

    function filterTransactions() {
        const search = document.querySelector('input[name="search"]').value.toLowerCase();
        const dateFrom = document.querySelector('input[name="date_from"]').value;
        const dateTo = document.querySelector('input[name="date_to"]').value;
        const category = document.querySelector('select[name="category"]').value;

        filteredTransactions = mockTransactions.filter(transaction => {
            const matchSearch = !search ||
                transaction.id.toLowerCase().includes(search) ||
                transaction.productName.toLowerCase().includes(search);

            const matchDateFrom = !dateFrom || transaction.date >= dateFrom;
            const matchDateTo = !dateTo || transaction.date <= dateTo;
            const matchCategory = !category || transaction.category === category;

            return matchSearch && matchDateFrom && matchDateTo && matchCategory;
        });

        currentPage = 1;
        loadTransactions();
    }

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

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            loadTransactions();
        }
    }

    function nextPage() {
        const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            loadTransactions();
        }
    }

    function showTransactionDetail(id) {
        const transaction = mockTransactions.find(t => t.id === id);
        if (transaction) {
            document.getElementById('detail-content').innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="font-medium text-gray-700">ID Transaksi:</span>
                            <span class="ml-2">${transaction.id}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Tanggal:</span>
                            <span class="ml-2">${transaction.date}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="font-medium text-gray-700">Nama Barang:</span>
                            <span class="ml-2">${transaction.productName}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Kategori:</span>
                            <span class="ml-2">${transaction.category}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Jumlah:</span>
                            <span class="ml-2">${transaction.quantity}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="font-medium text-gray-700">Harga Satuan:</span>
                            <span class="ml-2">${transaction.price}</span>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-lg">Total Harga:</span>
                            <span class="font-bold text-lg text-blue-600">${transaction.total}</span>
                        </div>
                    </div>
                </div>
            `;
            // Open modal (assuming you have a modal system)
            $dispatch('open-modal', 'detail-transaction');
        }
    }

    function editTransaction(id) {
        window.location.href = `/transactions/${id}/edit`;
    }

    function deleteTransaction(id = null) {
        let selectedIds = [];

        if (id) {
            selectedIds = [id];
        } else {
            const selected = document.querySelectorAll('.transaction-checkbox:checked');
            if (selected.length === 0) {
                alert('Pilih transaksi yang ingin dihapus');
                return;
            }
            selectedIds = Array.from(selected).map(checkbox => checkbox.value);
        }

        const message = selectedIds.length === 1 ?
            'Apakah Anda yakin ingin menghapus transaksi ini?' :
            `Apakah Anda yakin ingin menghapus ${selectedIds.length} transaksi?`;

        if (confirm(message)) {
            alert('Transaksi berhasil dihapus');
            // Di sini akan ada proses delete ke backend
            loadTransactions();
        }
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
        deleteTransaction();
    }
</script>
@endsection
