<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAKAD SMK Kreatif Dompu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .form-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fff;
        }
        .form-input:focus {
            outline: none;
            border-color: #3C50E0;
            box-shadow: 0 0 0 3px rgba(60,80,224,0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/bg.jpg') }}') center/cover no-repeat fixed;">
    
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-full h-40 object-contain">
                
            </div>

            <!-- Login Form -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Masuk</h2>
                <p class="text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <span class="text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email / Username / NIS / NIP</label>
                    <div class="relative">
                        <input type="text" name="email" value="{{ old('email') }}" required
                            class="form-input"
                            placeholder="Masukkan email, username, NIS, atau NIP">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="form-input"
                            placeholder="Masukkan password">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#3C50E0] text-white py-3 rounded-lg font-medium hover:bg-[#3344c4] transition-colors shadow-lg shadow-blue-500/30">
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-white/80 text-sm mt-6">
            &copy; {{ date('Y') }} SMK Kreatif Dompu. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
