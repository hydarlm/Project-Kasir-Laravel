@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border p-4 sm:p-6 lg:p-8">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center sm:text-left">
                    Tambah Kategori Baru
                </h1>
            </div>

            <!-- Form Section -->
            <div class="max-w-full sm:max-w-md lg:max-w-lg xl:max-w-xl mx-auto">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                    @csrf

                    <!-- Name Field -->
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
                            <p class="text-red-500 text-xs sm:text-sm mt-1 flex items-start">
                                <i class="fas fa-exclamation-circle mr-1 mt-0.5 flex-shrink-0"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Description Field -->
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
                            <p class="text-red-500 text-xs sm:text-sm mt-1 flex items-start">
                                <i class="fas fa-exclamation-circle mr-1 mt-0.5 flex-shrink-0"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-center sm:justify-end gap-3 pt-4 sm:pt-6">
                        <a href="{{ route('categories.index') }}"
                           class="inline-flex items-center justify-center w-full sm:w-auto order-3 sm:order-1 text-sm sm:text-base px-4 py-2 sm:px-6 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 border border-gray-300 rounded-md font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <x-button-secondary
                            type="button"
                            onclick="window.history.back()"
                            class="w-full sm:w-auto order-2 sm:order-2 text-sm sm:text-base px-4 py-2 sm:px-6 sm:py-3"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </x-button-secondary>
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

<!-- Success Notification -->
@if(session('success'))
    <div class="fixed top-4 right-4 left-4 sm:left-auto sm:right-4 sm:w-auto max-w-sm bg-green-500 text-white px-4 py-3 rounded-md shadow-lg z-50 transform transition-all duration-300">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2 flex-shrink-0"></i>
            <span class="text-sm sm:text-base">{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- Error Notification -->
@if(session('error'))
    <div class="fixed top-4 right-4 left-4 sm:left-auto sm:right-4 sm:w-auto max-w-sm bg-red-500 text-white px-4 py-3 rounded-md shadow-lg z-50 transform transition-all duration-300">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2 flex-shrink-0"></i>
            <span class="text-sm sm:text-base">{{ session('error') }}</span>
        </div>
    </div>
@endif

<style>
/* Custom responsive improvements */
@media (max-width: 640px) {
    .min-h-screen {
        min-height: 100vh;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    /* Better mobile button spacing */
    .flex-col > * + * {
        margin-top: 0.75rem;
    }

    /* Optimize mobile form spacing */
    .space-y-4 > * + * {
        margin-top: 1rem;
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    /* iPad specific styles */
    .max-w-4xl {
        max-width: 85%;
    }

    /* Better iPad form width */
    .max-w-md {
        max-width: 28rem;
    }
}

@media (min-width: 1025px) {
    /* Desktop specific styles */
    .max-w-4xl {
        max-width: 900px;
    }

    /* Larger form on desktop */
    .max-w-lg {
        max-width: 32rem;
    }
}

/* Enhanced focus states for better accessibility */
.focus\:ring-2:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

/* Smooth transitions for interactive elements */
a, button, input, textarea {
    transition: all 0.2s ease-in-out;
}

/* Loading animation for form submission */
form[data-loading] button[type="submit"] {
    opacity: 0.6;
    pointer-events: none;
}

form[data-loading] button[type="submit"]:before {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 8px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide notifications after 5 seconds
    const notifications = document.querySelectorAll('.fixed.top-4');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    });

    // Add loading state to form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            this.setAttribute('data-loading', 'true');
        });
    }

    // Enhance textarea auto-resize on desktop
    const textarea = document.getElementById('description');
    if (textarea && window.innerWidth >= 640) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>
@endsection
