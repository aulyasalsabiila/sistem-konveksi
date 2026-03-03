<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Puspita Indah Konveksi</title>
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Custom CSS --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-active {
            background: white !important;
            color: #1e40af !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('layouts.sidebar')
        
        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Navbar --}}
            @include('layouts.navbar')
            
            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{-- Alert Messages --}}
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <span class="text-sm font-medium text-green-800">{!! session('success') !!}</span>
                        </div>
                        <button onclick="this.closest('.bg-green-50').remove()" class="text-green-500 hover:text-green-700 ml-4 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif
                
                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <span class="text-sm font-medium text-red-800">{!! session('error') !!}</span>
                        </div>
                        <button onclick="this.closest('.bg-red-50').remove()" class="text-red-500 hover:text-red-700 ml-4 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif
                
                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-red-800 mb-2">Terdapat kesalahan:</p>
                            <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="this.closest('.bg-red-50').remove()" class="flex-shrink-0 ml-4 text-red-500 hover:text-red-700 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    {{-- Scripts --}}
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            // Only select alerts with specific structure (not all bg-green-50/bg-red-50)
            const successAlerts = document.querySelectorAll('main > .bg-green-50.border-l-4');
            const errorAlerts = document.querySelectorAll('main > .bg-red-50.border-l-4');
            
            [...successAlerts, ...errorAlerts].forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
        
        // CSRF Token for AJAX
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    </script>
    
    @stack('scripts')
</body>
</html>