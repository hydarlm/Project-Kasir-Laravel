@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-4 sm:p-6">
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Transaksi</h1>
    </div>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-4 mb-6">
            <div>
                <x-form-label for="product_id">Produk</x-form-label>
                <select name="product_id" id="product_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            data-price="{{ $product->price }}"
                            {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ $product->category->name }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-form-label for="quantity">Jumlah</x-form-label>
                <x-input-field type="number" name="quantity" min="1" value="{{ $transaction->quantity }}" required />
            </div>
            <div>
                <x-form-label for="date">Tanggal</x-form-label>
                <x-input-field type="date" name="date" value="{{ $transaction->date }}" required />
            </div>
        </div>
        <div class="flex justify-end space-x-3">
            <x-button-secondary onclick="window.location.href='{{ route('transactions.index') }}'">
                Batal
            </x-button-secondary>
            <x-button-primary type="submit">
                Simpan Perubahan
            </x-button-primary>
        </div>
    </form>
</div>
@endsection
