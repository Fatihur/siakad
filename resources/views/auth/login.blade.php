<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAKAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3C50E0',
                        strokedark: '#2E3A47',
                        boxdark: '#24303F',
                        'boxdark-2': '#1A222C',
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .form-input { width: 100%; padding: 12px 16px 12px 44px; border: 1px solid #E2E8F0; border-radius: 6px; font-size: 15px; transition: all 0.2s; }
        .form-input:focus { outline: none; border-color: #3C50E0; box-shadow: 0 0 0 3px rgba(60,80,224,0.1); }
    </style>
</head>
<body class="bg-[#F1F5F9] min-h-screen">
    <div class="flex min-h-screen">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-boxdark-2 flex-col justify-center items-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-4xl"></i>
                </div>
                <h1 class="text-white text-4xl font-bold mb-4">SIAKAD</h1>
                <p class="text-[#AEB7C0] text-lg max-w-md">Sistem Informasi Akademik untuk mengelola data akademik dengan mudah dan efisien</p>
                
                <div class="mt-12 grid grid-cols-3 gap-6 max-w-sm mx-auto">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <p class="text-[#DEE4EE] text-sm">Multi User</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-shield-alt text-primary"></i>
                        </div>
                        <p class="text-[#DEE4EE] text-sm">Aman</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-bolt text-primary"></i>
                        </div>
                        <p class="text-[#DEE4EE] text-sm">Cepat</p>
                    </div>
                </div>
            </div>
            
            <!-- Decorative -->
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/10 rounded-full -translate-x-1/2 translate-y-1/2"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full translate-x-1/3 -translate-y-1/3"></div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h1 class="text-[#1C2434] text-2xl font-bold">SIAKAD</h1>
                </div>
                
                <div class="bg-white rounded-xl shadow-card p-8 border border-[#E2E8F0]">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#1C2434]">Masuk</h2>
                        <p class="text-[#64748B] mt-2">Silakan masuk ke akun Anda</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-[#FEF2F2] border border-[#FECACA] text-[#991B1B] px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="text-sm">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-[#1C2434] text-sm font-medium mb-2">Email / Username</label>
                            <div class="relative">
                                <input type="text" name="email" value="{{ old('email') }}" required
                                    class="form-input"
                                    placeholder="Masukkan email atau username">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#9CA3AF]"></i>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-[#1C2434] text-sm font-medium mb-2">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="form-input"
                                    placeholder="Masukkan password">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#9CA3AF]"></i>
                                <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#9CA3AF] hover:text-[#64748B]">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-[#3344c4] transition-colors">
                            Masuk
                        </button>
                    </form>
                </div>

                <p class="text-center text-[#64748B] text-sm mt-6">
                    &copy; {{ date('Y') }} SIAKAD. All rights reserved.
                </p>
            </div>
        </div>
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
