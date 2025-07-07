@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@php
    $categories = \App\Models\Category::all();
@endphp

<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        border-radius: 0.5rem;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    @media (min-width: 640px) {
        .modal-content {
            padding: 24px;
        }
    }
</style>

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
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
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
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="p-4 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Transaksi</h3>
            <div id="detail-content">
                <!-- Content akan diisi secara dinamis -->
            </div>
            <div class="flex justify-end pt-4">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    let itemsPerPage = 10;
    let totalRecords = 0;

    // Format Rupiah
    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    // Load transactions on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadTransactions();
    });

    function loadTransactions() {
        const search = document.querySelector('input[name="search"]').value;
        const dateFrom = document.querySelector('input[name="date_from"]').value;
        const dateTo = document.querySelector('input[name="date_to"]').value;
        const category = document.querySelector('select[name="category"]').value;

        fetch(`{{ route('transactions.get') }}?page=${currentPage}&search=${search}&date_from=${dateFrom}&date_to=${dateTo}&category=${category}`)
            .then(response => response.json())
            .then(data => {
                displayTransactions(data.transactions.data);
                updatePagination(data.transactions.total, data.transactions.current_page, data.transactions.per_page);
                updateStatistics(data.stats);
            })
            .catch(error => console.error('Error:', error));
    }

    function displayTransactions(transactions) {
        const tableBody = document.getElementById('transaction-table-body');

        tableBody.innerHTML = transactions.map(transaction => `
            <tr class="odd:bg-white even:bg-gray-50 border-b hover:bg-gray-100">
                <td class="px-3 sm:px-6 py-3 sm:py-4">
                    <input type="checkbox" class="transaction-checkbox"
                           value="${transaction.id}" onchange="updateBulkActions()">
                </td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 font-medium text-gray-900 text-sm">${transaction.transaction_id}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm whitespace-nowrap">${new Date(transaction.date).toLocaleDateString('id-ID')}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm">
                    <div class="max-w-xs sm:max-w-none truncate">${transaction.product_name}</div>
                </td>
                <td class="px-3 sm:px-6 py-3 sm:py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap
                           ${transaction.category_name === 'Elektronik' ? 'bg-blue-100 text-blue-800' :
                             transaction.category_name === 'Aksesoris' ? 'bg-green-100 text-green-800' :
                             'bg-purple-100 text-purple-800'}">
                        ${transaction.category_name}
                    </span>
                </td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm text-center">${transaction.quantity}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm whitespace-nowrap">${formatRupiah(transaction.price)}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4 font-semibold text-sm whitespace-nowrap">${formatRupiah(transaction.total)}</td>
                <td class="px-3 sm:px-6 py-3 sm:py-4">
                    <div class="flex space-x-1 sm:space-x-2">
                        <button onclick="showTransactionDetail(${transaction.id})"
                                class="text-blue-600 hover:text-blue-900 p-1" title="Detail">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                        <button onclick="editTransaction(${transaction.id})"
                                class="text-yellow-600 hover:text-yellow-900 p-1" title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <button onclick="deleteTransaction(${transaction.id})"
                                class="text-red-600 hover:text-red-900 p-1" title="Delete">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function showTransactionDetail(id) {
        fetch(`/transactions/${id}`)
            .then(response => response.json())
            .then(transaction => {
                // Format tanggal
                const transactionDate = new Date(transaction.date);
                const formattedDate = transactionDate.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });

                // Isi konten modal
                document.getElementById('detail-content').innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="font-medium text-gray-700">ID Transaksi:</span>
                                <span class="ml-2">${transaction.transaction_id}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Tanggal:</span>
                                <span class="ml-2">${formattedDate}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="font-medium text-gray-700">Nama Barang:</span>
                                <span class="ml-2">${transaction.product.name}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Kategori:</span>
                                <span class="ml-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        ${transaction.product.category.name === 'Elektronik' ? 'bg-blue-100 text-blue-800' :
                                          transaction.product.category.name === 'Aksesoris' ? 'bg-green-100 text-green-800' :
                                          'bg-purple-100 text-purple-800'}">
                                        ${transaction.product.category.name}
                                    </span>
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Jumlah:</span>
                                <span class="ml-2">${transaction.quantity}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Harga Satuan:</span>
                                <span class="ml-2">${formatRupiah(transaction.price)}</span>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-lg">Total Harga:</span>
                                <span class="font-bold text-lg text-blue-600">
                                    ${formatRupiah(transaction.quantity * transaction.price)}
                                </span>
                            </div>
                        </div>
                    </div>
                `;

                // Buka modal
                document.getElementById('detailModal').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat detail transaksi');
            });
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function updateStatistics(stats) {
        document.getElementById('total-transactions').textContent = stats.total_transactions;
        document.getElementById('total-revenue').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(stats.total_revenue);
        document.getElementById('today-transactions').textContent = stats.today_transactions;
        document.getElementById('total-items').textContent = stats.total_items;
    }

    function updatePagination(total, currentPage, perPage) {
        const totalPages = Math.ceil(total / perPage);
        const start = (currentPage - 1) * perPage + 1;
        const end = Math.min(currentPage * perPage, total);

        document.getElementById('showing-from').textContent = start;
        document.getElementById('showing-to').textContent = end;
        document.getElementById('total-records').textContent = total;

        document.getElementById('prev-btn').disabled = currentPage === 1;
        document.getElementById('next-btn').disabled = currentPage === totalPages || total === 0;
    }

    function filterTransactions() {
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
        currentPage++;
        loadTransactions();
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
            fetch('{{ route("transactions.bulk-delete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ids: selectedIds})
            })
            .then(response => response.json())
            .then(data => {
                alert(data.success);
                loadTransactions();
                document.getElementById('bulk-actions').style.display = 'none';
            })
            .catch(error => console.error('Error:', error));
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
