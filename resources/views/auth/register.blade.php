<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lab TEFA PPLG</title>
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
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="text-center mb-6">
                <i class="fas fa-flask text-5xl text-primary"></i>
                <h2 class="text-2xl font-bold mt-2 text-primary">Registrasi</h2>
                <p class="text-mediumGray">Buat akun baru</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-darkGray mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-3">
                    <label class="block text-darkGray mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-3">
                    <label class="block text-darkGray mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-3">
                    <label class="block text-darkGray mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-3">
                    <label class="block text-darkGray mb-1">Kelas</label>
                    <input type="text" name="kelas" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-3">
                    <label class="block text-darkGray mb-1">Jurusan</label>
                    <input type="text" name="jurusan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <div class="mb-4">
                    <label class="block text-darkGray mb-1">No HP</label>
                    <input type="text" name="no_hp" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primaryLight transition">
                    Register
                </button>
            </form>

            <div class="mt-4 text-center text-sm">
                <a href="{{ route('login') }}" class="text-primary hover:text-primaryLight">Sudah punya akun? Login</a>
            </div>
        </div>
    </div>
</body>
</html>