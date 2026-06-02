<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lab TEFA PPLG</title>
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
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold mt-2 text-primary">Lab TEFA PPLG</h2>
                <p class="text-mediumGray">Peminjaman Peralatan</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-darkGray mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-6">
                    <label class="block text-darkGray mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primaryLight transition">
                    Login
                </button>
            </form>

            <div class="mt-4 text-center text-sm">
                <a href="{{ route('register') }}" class="text-primary hover:text-primaryLight">Belum punya akun? Register</a>
            </div>

            <div class="mt-4 text-center text-xs text-mediumGray">
                <p>Demo Akun:</p>
                <p>Admin: admin@tefa.com / admin123</p>
                <p>User: ahmad@tefa.com / user123</p>
            </div>
        </div>
    </div>
</body>
</html>