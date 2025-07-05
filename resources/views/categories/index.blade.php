@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Kategori</h1>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i>
            Tambah Kategori
        </a>
    </div>

    <!-- Mobile Card View -->
    <div class="block sm:hidden space-y-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-medium text-gray-900 text-base">Elektronik</h3>
                    <div class="mt-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">25</span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button class="text-blue-600 hover:text-blue-900 p-2">
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900 p-2">
                        <i class="fas fa-trash text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-medium text-gray-900 text-base">Fashion</h3>
                    <div class="mt-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">12</span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button class="text-blue-600 hover:text-blue-900 p-2">
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900 p-2">
                        <i class="fas fa-trash text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop/Tablet Table View -->
    <div class="hidden sm:block overflow-x-auto">
        <x-data-table :headers="['Nama Kategori', 'Jumlah Produk', 'Aksi']">
            <tr class="odd:bg-white even:bg-gray-50 border-b">
                <td class="px-4 md:px-6 py-4 font-medium text-gray-900">Elektronik</td>
                <td class="px-4 md:px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">25</span>
                </td>
                <td class="px-4 md:px-6 py-4">
                    <div class="flex space-x-2">
                        <button class="text-blue-600 hover:text-blue-900 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50 border-b">
                <td class="px-4 md:px-6 py-4 font-medium text-gray-900">Fashion</td>
                <td class="px-4 md:px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">12</span>
                </td>
                <td class="px-4 md:px-6 py-4">
                    <div class="flex space-x-2">
                        <button class="text-blue-600 hover:text-blue-900 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </x-data-table>
    </div>
</div>

<!-- Add Category Modal -->
<x-modal name="add-category">
    <div class="p-4 sm:p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Kategori Baru</h3>
        <form class="space-y-4">
            <div>
                <x-form-label for="category_name" required>Nama Kategori</x-form-label>
                <x-input-field name="category_name" placeholder="Masukkan nama kategori" required />
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                <x-button-secondary onclick="$dispatch('close-modal', 'add-category')" class="w-full sm:w-auto">
                    Cancel
                </x-button-secondary>
                <x-button-primary type="submit" class="w-full sm:w-auto">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </x-button-primary>
            </div>
        </form>
    </div>
</x-modal>
@endsection
