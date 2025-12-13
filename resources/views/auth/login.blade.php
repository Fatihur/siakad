<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAKAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 sm:p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-graduation-cap text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">SIAKAD</h1>
            <p class="text-gray-500">Sistem Informasi Akademik</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Email / Username</label>
                <div class="relative">
                    <input type="text" name="email" value="{{ old('email') }}" required
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan email atau username">
                    <i class="fas fa-user absolute left-3 top-4 text-gray-400"></i>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" required
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan password">
                    <i class="fas fa-lock absolute left-3 top-4 text-gray-400"></i>
                </div>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
            </button>
        </form>

        <p class="text-center text-gray-500 text-sm mt-6">
            &copy; {{ date('Y') }} SIAKAD. All rights reserved.
        </p>
    </div>
</body>
</html>
