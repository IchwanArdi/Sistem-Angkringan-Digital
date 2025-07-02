<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Angkringan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef7ee',
                            100: '#fdecd3',
                            200: '#fad5a5',
                            300: '#f7b96d',
                            400: '#f39232',
                            500: '#f0730a',
                            600: '#e15900',
                            700: '#ba4502',
                            800: '#953708',
                            900: '#782f0a',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-primary-600 to-primary-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-white text-xl font-bold flex items-center">
                            <i class="fas fa-utensils mr-2"></i>
                            Sistem Angkringan
                        </h1>
                    </div>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" 
                        class="text-white hover:bg-primary-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                        <a href="{{ route('menus.index') }}" 
                        class="text-primary-100 hover:bg-primary-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center">
                            <i class="fas fa-utensils mr-2"></i> Menu
                        </a>
                        <a href="{{ route('orders.index') }}" 
                        class="text-primary-100 hover:bg-primary-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i> Pesanan
                        </a>
                        <a href="{{ route('reports.index') }}" 
                        class="text-primary-100 hover:bg-primary-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center">
                            <i class="fas fa-chart-bar mr-2"></i> Laporan
                        </a>

                        @auth
                            <span class="text-primary-100 px-3 py-2 text-sm font-medium flex items-center">
                                <i class="fas fa-user mr-2"></i> Halo, {{ Auth::user()->nama }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-white hover:bg-red-600 bg-red-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        @endauth
                    </div>

                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-primary-200 p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-primary-700">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @auth
                    <div class="px-3 py-2 text-white">
                        <i class="fas fa-user mr-2"></i> Halo, {{ Auth::user()->nama }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left text-white hover:bg-red-600 bg-red-500 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @endauth

                <a href="{{ route('dashboard') }}" 
                   class="text-white hover:bg-primary-600 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('menus.index') }}" 
                   class="text-primary-100 hover:bg-primary-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-utensils mr-2"></i>Menu
                </a>
                <a href="{{ route('orders.index') }}" 
                   class="text-primary-100 hover:bg-primary-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-shopping-cart mr-2"></i>Pesanan
                </a>
                <a href="{{ route('reports.index') }}" 
                   class="text-primary-100 hover:bg-primary-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-chart-bar mr-2"></i>Laporan
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; 2025 Sistem Angkringan. Dibuat dengan ❤️ untuk kemudahan pengelolaan angkringan Anda.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>