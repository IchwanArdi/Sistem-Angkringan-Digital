<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Angkringan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-angkringan {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-angkringan rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-utensils text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">
                    @yield('title')
                </h2>
                <p class="mt-2 text-gray-600">
                    @yield('subtitle')
                </p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content -->
            <div class="bg-white py-8 px-6 shadow-lg rounded-xl">
                @yield('content')
            </div>

            <!-- Footer Links -->
            <div class="text-center space-y-2">
                @yield('footer-links')
                
                <div class="text-sm text-gray-500 mt-4">
                    <p>&copy; 2024 Sistem Angkringan. Made with ❤️ for UMKM Indonesia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Memproses...</span>
        </div>
    </div>

    <script>
        // Show loading on form submit
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const loading = document.getElementById('loading');
            
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    loading.classList.remove('hidden');
                    loading.classList.add('flex');
                });
            });
            
            // Hide loading after 5 seconds (fallback)
            setTimeout(() => {
                loading.classList.add('hidden');
                loading.classList.remove('flex');
            }, 5000);
        });
    </script>
</body>
</html>