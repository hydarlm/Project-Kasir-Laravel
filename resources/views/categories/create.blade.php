@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border p-4 sm:p-6 lg:p-8">
            <div class="mb-6 sm:mb-8">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center sm:text-left">
                    Tambah Kategori Baru
                </h1>
            </div>

            <div class="max-w-full sm:max-w-md lg:max-w-lg xl:max-w-xl mx-auto">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                    @csrf

                    <div class="space-y-1 sm:space-y-2">
                        <x-form-label for="name" required>Nama Kategori</x-form-label>
                        <x-input-field
                            name="name"
                            placeholder="Masukkan nama kategori"
                            value="{{ old('name') }}"
                            required
                            class="w-full text-sm sm:text-base h-10 sm:h-12"
                        />
                        @error('name')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1 sm:space-y-2">
                        <x-form-label for="description">Deskripsi (Opsional)</x-form-label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none sm:resize-y min-h-[80px] sm:min-h-[100px]"
                            placeholder="Masukkan deskripsi kategori"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center sm:justify-end gap-3 pt-4 sm:pt-6">
                        <a href="{{ route('categories.index') }}"
                           class="inline-flex items-center justify-center w-full sm:w-auto order-3 sm:order-1 text-sm sm:text-base px-4 py-2 sm:px-6 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 border border-gray-300 rounded-md font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <x-button-primary
                            type="submit"
                            class="w-full sm:w-auto order-1 sm:order-3 text-sm sm:text-base px-4 py-2 sm:px-6 sm:py-3"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Simpan Kategori
                        </x-button-primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
