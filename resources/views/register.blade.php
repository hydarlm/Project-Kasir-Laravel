{{-- File: resources/views/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center">
                <i class="fas fa-user-plus text-4xl text-blue-600"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Buat akun Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Masuk ke akun Anda yang sudah ada
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="#" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <x-form-label for="name" required>Username</x-form-label>
                    <x-input-field
                        type="text"
                        name="name"
                        placeholder="username"
                        required
                    />
                </div>
                <div>
                    <x-form-label for="email" required>Email Address</x-form-label>
                    <x-input-field
                        type="email"
                        name="email"
                        placeholder="email address"
                        required
                    />
                </div>
                <div>
                    <x-form-label for="password" required>Password</x-form-label>
                    <x-input-field
                        type="password"
                        name="password"
                        placeholder="password"
                        required
                    />
                </div>
                <div>
                    <x-form-label for="password_confirmation" required>Konfirmasi Password</x-form-label>
                    <x-input-field
                        type="password"
                        name="password_confirmation"
                        placeholder="Konfirmasi password"
                        required
                    />
                </div>
            </div>

            <div class="flex items-center">
                <input id="agree-terms" name="agree_terms" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                <label for="agree-terms" class="ml-2 block text-sm text-gray-900">
                    Saya setuju dengan
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Syarat dan Ketentuan</a>
                    and
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Kebijakan Privasi</a>
                </label>
            </div>

            <div>
                <x-button-primary type="submit" class="w-full justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Buat Akun
                </x-button-primary>
            </div>
        </form>
    </div>
</div>
@endsection
