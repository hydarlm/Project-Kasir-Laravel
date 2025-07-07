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

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mobile Card View -->
    <div class="block sm:hidden space-y-4">
        @forelse($categories as $category)
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-medium text-gray-900 text-base">{{ $category->name }}</h3>
                    @if($category->description)
                        <p class="text-gray-500 text-sm mt-1">{{ Str::limit($category->description, 50) }}</p>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 p-2">
                        <i class="fas fa-edit text-lg"></i>
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 p-2">
                            <i class="fas fa-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-4 text-gray-500">
            Tidak ada kategori tersedia
        </div>
        @endforelse
    </div>

    <!-- Desktop/Tablet Table View -->
    <div class="hidden sm:block overflow-x-auto">
        <x-data-table :headers="['Nama Kategori', 'Deskripsi', 'Aksi']">
            @forelse($categories as $category)
            <tr class="odd:bg-white even:bg-gray-50 border-b hover:bg-gray-50">
                <td class="px-4 md:px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                <td class="px-4 md:px-6 py-4 text-gray-500">
                    {{ $category->description ? Str::limit($category->description, 50) : '-' }}
                </td>
                <td class="px-4 md:px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 p-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-4 md:px-6 py-4 text-center text-gray-500">
                    Tidak ada data kategori
                </td>
            </tr>
            @endforelse
        </x-data-table>
    </div>
</div>
@endsection
