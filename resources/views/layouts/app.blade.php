<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Aplikasi Kasir' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #075b5e;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --warning-color: #FFC107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--warning-color);
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--warning-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .nav-link.active::after {
            width: 100%;
        }

        .brand-logo {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }


        .brand-logo:hover {
            color: var(--warning-color) !important;
            transform: translateY(-2px);
        }

        .brand-logo i {
            background: linear-gradient(45deg, var(--success-color), var(--info-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(7, 91, 94, 0.3);
        }

        .mobile-menu {
            background: var(--color-emerald-800);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(7, 91, 94, 0.1);
        }

        .hamburger {
            transition: all 0.3s ease;
        }

        .hamburger.active {
            transform: rotate(90deg);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .search-bar {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .search-bar:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-teal-700 text-white shadow-lg sticky top-0 z-50" x-data="{ open: false, searchOpen: false }">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-8">
                    <div class="flex items-center py-4">
                        <a href="/" class="brand-logo text-2xl font-bold flex items-center space-x-2">
                            <div class="relative">
                                <i class="fas text-3xl"></i>
                                <div class="absolute -top-1 -right-1 w-3 h-3 rounded-full animate-pulse"></div>
                            </div>
                            <span>HDR KASIR</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/products" class="nav-link py-4 px-4 flex items-center space-x-2">
                            <i class="fas fa-box"></i>
                            <span>Produk</span>
                        </a>
                        <a href="/categories" class="nav-link py-4 px-4 flex items-center space-x-2">
                            <i class="fas fa-tags"></i>
                            <span>Kategori</span>
                        </a>
                        <a href="/transactions" class="nav-link py-4 px-4 flex items-center space-x-2">
                            <i class="fas fa-receipt"></i>
                            <span>Transaksi</span>
                        </a>
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="relative" x-show="searchOpen" x-transition>
                        <input type="text" placeholder="Cari produk..."
                               class="search-bar px-4 py-2 rounded-lg text-gray-700 focus:outline-none w-64">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>

                    <!-- Action Buttons -->
                    <button @click="searchOpen = !searchOpen"
                            class="p-2 rounded-lg transition-colors">
                        <i class="fas fa-search text-white hover:text-amber-400"></i>
                    </button>

                    <button class="p-2 rounded-lg transition-colors relative">
                        <i class="fas fa-bell text-amber-400 hover:text-white animate-pulse"></i>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="open = !open"
                            class="hamburger p-2 rounded-lg hover:bg-gray-100 transition-colors"
                            :class="{ 'active': open }">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-menu md:hidden" x-show="open" x-transition>
            <div class="px-4 py-2 space-y-1">
                <!-- Mobile Search -->
                <div class="relative mb-4">
                    <input type="text" placeholder="Cari produk..."
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>

                <!-- Mobile Menu Items -->
                <a href="/products" class="text-white hover:text-amber-400 py-3 px-4 rounded-lg flex items-center space-x-3">
                    <i class="fas fa-box w-5"></i>
                    <span>Produk</span>
                </a>
                <a href="/categories" class="text-white hover:text-amber-400 py-3 px-4 rounded-lg flex items-center space-x-3">
                    <i class="fas fa-tags w-5"></i>
                    <span>Kategori</span>
                </a>
                <a href="/transactions" class="text-white hover:text-amber-400 py-3 px-4 rounded-lg flex items-center space-x-3">
                    <i class="fas fa-receipt w-5"></i>
                    <span>Transaksi</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>
</body>
</html>
