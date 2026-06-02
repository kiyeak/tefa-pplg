<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab TEFA PPLG - Peminjaman Peralatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#b6252a',
                        primaryLight: '#ed1e28',
                        darkGray: '#55565b',
                        mediumGray: '#959597',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar untuk konten utama */
        .main-content::-webkit-scrollbar {
            width: 8px;
        }
        .main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .main-content::-webkit-scrollbar-thumb {
            background: #b6252a;
            border-radius: 10px;
        }
        .main-content::-webkit-scrollbar-thumb:hover {
            background: #ed1e28;
        }
    </style>
</head>
<body class="bg-gray-100 overflow-hidden">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - FIXED/TETAP (tidak ikut scroll) -->
        <div class="w-64 bg-primary shadow-lg flex flex-col h-full flex-shrink-0">
            <!-- Custom scrollbar untuk sidebar jika kontennya panjang -->
            <style>
                .sidebar-scroll::-webkit-scrollbar {
                    width: 4px;
                }
                .sidebar-scroll::-webkit-scrollbar-track {
                    background: rgba(255,255,255,0.1);
                    border-radius: 10px;
                }
                .sidebar-scroll::-webkit-scrollbar-thumb {
                    background: rgba(255,255,255,0.3);
                    border-radius: 10px;
                }
            </style>
            
            <!-- Logo/Tulisan di atas (tanpa icon) -->
            <div class="pt-6 pb-4 flex-shrink-0">
                <div class="text-center border-b border-white border-opacity-30 pb-4 mx-4">
                    <h1 class="text-white text-xl font-bold tracking-wide">Lab TEFA PPLG</h1>
                    <p class="text-white text-xs opacity-80 mt-1">Peminjaman Peralatan</p>
                </div>
            </div>

            <!-- Menu Navigasi (flex-grow untuk mendorong user & logout ke bawah) -->
            <div class="flex-1 overflow-y-auto sidebar-scroll">
                <nav class="mt-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('dashboard') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('pengguna.index') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('pengguna.*') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Data Pengguna</span>
                    </a>
                    <a href="{{ route('peralatan.index') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('peralatan.*') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-tools w-5"></i>
                        <span class="ml-3">Data Peralatan</span>
                    </a>
                    @endif
                    <a href="{{ route('peminjaman.index') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('peminjaman.*') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-hand-holding w-5"></i>
                        <span class="ml-3">Data Peminjaman</span>
                    </a>
                </nav>
            </div>

            <!-- User & Logout di paling bawah sidebar (mt-auto) -->
            <div class="flex-shrink-0 pb-6 mt-auto">
                <div class="border-t border-white border-opacity-30 pt-4 mx-4">
                    <div class="flex items-center px-4 py-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-white text-sm font-semibold">{{ auth()->user()->nama }}</p>
                            <p class="text-white text-xs opacity-75">{{ ucfirst(auth()->user()->role) }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="flex items-center w-full py-3 px-6 text-white hover:bg-primaryLight transition rounded-lg">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="ml-3">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content - BISA DI-SCROLL -->
        <div class="flex-1 overflow-y-auto main-content">
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>