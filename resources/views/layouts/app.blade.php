<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIAKAD') - Sistem Informasi Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { satoshi: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#3C50E0',
                        secondary: '#80CAEE',
                        stroke: '#E2E8F0',
                        strokedark: '#2E3A47',
                        hoverdark: '#253746',
                        formbg: '#F9FAFB',
                        forminput: '#1D2A39',
                        boxdark: '#24303F',
                        'boxdark-2': '#1A222C',
                        bodydark: '#AEB7C0',
                        bodydark1: '#DEE4EE',
                        bodydark2: '#8A99AF',
                        graydark: '#333A48',
                        whiten: '#F1F5F9',
                        whiter: '#F5F7FD',
                        meta: {
                            1: '#DC3545',
                            2: '#EFF2F7',
                            3: '#10B981',
                            4: '#313D4A',
                            5: '#259AE6',
                            6: '#FFBA00',
                            7: '#FF6766',
                            8: '#F0950C',
                            9: '#E5E7EB',
                            10: '#0FADCF'
                        }
                    },
                    boxShadow: {
                        default: '0px 8px 13px -3px rgba(0, 0, 0, 0.07)',
                        card: '0px 1px 3px rgba(0, 0, 0, 0.12)',
                        'card-2': '0px 1px 2px rgba(0, 0, 0, 0.05)',
                        switcher: '0px 2px 4px rgba(0, 0, 0, 0.2)',
                        1: '0px 1px 3px rgba(0, 0, 0, 0.08)',
                        2: '0px 1px 4px rgba(0, 0, 0, 0.12)'
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a1a1a1; }
        
        /* Sidebar Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #3E4A5B; border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: #4E5A6B; }
        
        /* Sidebar */
        .sidebar { background: linear-gradient(180deg, #1C2434 0%, #1C2434 100%); }
        .sidebar-item { color: #DEE4EE; transition: all 0.3s ease; }
        .sidebar-item:hover { background: rgba(255,255,255,0.05); }
        .sidebar-item.active { background: rgba(60, 80, 224, 0.1); color: #fff; }
        .sidebar-item.active::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: #3C50E0; border-radius: 0 3px 3px 0; }
        
        /* Sidebar Menu Group */
        .sidebar-group-title { font-size: 11px; font-weight: 600; color: #8A99AF; letter-spacing: 0.05em; text-transform: uppercase; padding: 0 20px; margin: 20px 0 10px; }
        
        /* Sidebar Collapsed State */
        .sidebar-collapsed { width: 80px !important; }
        .sidebar-collapsed .sidebar-text { display: none; }
        .sidebar-collapsed .sidebar-group-title { display: none; }
        .sidebar-collapsed .sidebar-header-text { display: none; }
        .sidebar-collapsed .sidebar-item { justify-content: center; padding: 12px; }
        .sidebar-collapsed .sidebar-item i { margin-right: 0; }
        
        /* Main Content */
        .main-expanded { margin-left: 280px; }
        .main-collapsed { margin-left: 80px; }
        @media (max-width: 1024px) {
            .main-expanded, .main-collapsed { margin-left: 0 !important; }
        }
        
        /* Cards */
        .card { background: #fff; border-radius: 8px; border: 1px solid #E2E8F0; }
        
        /* DataTables */
        .dataTables_wrapper { padding: 0; }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input { 
            padding: 8px 12px; border-radius: 6px; border: 1px solid #E2E8F0; font-size: 14px;
        }
        .dataTables_wrapper .dataTables_filter input:focus { outline: none; border-color: #3C50E0; box-shadow: 0 0 0 2px rgba(60,80,224,0.1); }
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 6px 12px; border-radius: 4px; margin: 0 2px; font-size: 14px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #3C50E0 !important; color: white !important; border: none; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) { background: #EFF4FB !important; color: #3C50E0 !important; border: none; }
        table.dataTable thead th { background: #F9FAFB; font-weight: 600; color: #64748B; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; padding: 12px 16px; border-bottom: 1px solid #E2E8F0; }
        table.dataTable tbody td { padding: 14px 16px; border-bottom: 1px solid #EFF4FB; color: #1C2434; font-size: 14px; }
        table.dataTable tbody tr:hover { background: #F9FAFB !important; }
        table.dataTable.no-footer { border-bottom: none; }
        .dataTables_info, .dataTables_length, .dataTables_filter { margin-bottom: 16px; font-size: 14px; color: #64748B; }
        
        /* Forms */
        .form-input { width: 100%; padding: 10px 14px; border: 1px solid #E2E8F0; border-radius: 6px; font-size: 14px; transition: all 0.2s; background: #fff; }
        .form-input:focus { outline: none; border-color: #3C50E0; box-shadow: 0 0 0 2px rgba(60,80,224,0.1); }
        .form-input::placeholder { color: #9CA3AF; }
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #1C2434; margin-bottom: 8px; }
        .form-select { appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 12px center; background-repeat: no-repeat; background-size: 16px; padding-right: 40px; }
        
        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; font-size: 14px; font-weight: 500; border-radius: 6px; transition: all 0.2s; cursor: pointer; }
        .btn-primary { background: #3C50E0; color: #fff; }
        .btn-primary:hover { background: #3344c4; }
        .btn-secondary { background: #EFF4FB; color: #3C50E0; }
        .btn-secondary:hover { background: #dce5f5; }
        .btn-danger { background: #DC3545; color: #fff; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #10B981; color: #fff; }
        .btn-success:hover { background: #0d9668; }
        .btn-outline { background: transparent; color: #64748B; border: 1px solid #E2E8F0; }
        .btn-outline:hover { background: #F9FAFB; border-color: #d1d5db; }
        
        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; font-size: 12px; font-weight: 500; border-radius: 4px; }
        .badge-primary { background: #EFF4FB; color: #3C50E0; }
        .badge-success { background: #ECFDF3; color: #10B981; }
        .badge-warning { background: #FEF9C3; color: #CA8A04; }
        .badge-danger { background: #FEF2F2; color: #DC3545; }
        .badge-info { background: #E0F2FE; color: #0EA5E9; }
        
        /* Alerts */
        .alert { padding: 14px 16px; border-radius: 6px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px; font-size: 14px; }
        .alert-success { background: #ECFDF3; border: 1px solid #A7F3D0; color: #065F46; }
        .alert-danger { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
        .alert-warning { background: #FFFBEB; border: 1px solid #FDE68A; color: #92400E; }
        .alert-info { background: #EFF6FF; border: 1px solid #BFDBFE; color: #1E40AF; }
        
        /* Stats Card */
        .stat-card { position: relative; overflow: hidden; background: #fff; border-radius: 8px; border: 1px solid #E2E8F0; padding: 24px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { float: none; text-align: left; margin-bottom: 12px; }
            .dataTables_wrapper .dataTables_filter input { width: 100%; margin-left: 0; margin-top: 8px; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F1F5F9] min-h-screen">
    <div class="flex">
        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden fixed top-4 left-4 z-50 bg-primary text-white p-2.5 rounded-lg shadow-lg">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-[280px] h-screen fixed left-0 top-0 z-40 transform -translate-x-full lg:translate-x-0 transition-all duration-300 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-[#2E3A47] flex-shrink-0">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <div class="sidebar-header-text">
                    <span class="text-white font-bold text-xl">SIAKAD</span>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 py-4 overflow-y-auto sidebar-scroll">
                @yield('sidebar')
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 min-h-screen main-expanded transition-all duration-300">
            <!-- Header -->
            <header class="bg-white border-b border-stroke sticky top-0 z-20 px-4 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="lg:hidden w-10"></div>
                        <!-- Collapse Button (Desktop) -->
                        <button id="collapse-btn" class="hidden lg:flex w-10 h-10 rounded-lg bg-[#F9FAFB] items-center justify-center text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] transition-colors" title="Toggle Sidebar">
                            <i class="fas fa-bars" id="collapse-icon"></i>
                        </button>
                        <!-- Search -->
                        <div class="hidden sm:block relative">
                            <input type="text" placeholder="Cari..." class="form-input pl-10 w-64 bg-[#F9FAFB]">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#9CA3AF]"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <!-- Notification -->
                        <div class="relative" id="notif-dropdown">
                            <button id="notif-btn" class="relative w-10 h-10 rounded-full bg-[#F9FAFB] flex items-center justify-center text-[#64748B] hover:text-primary hover:bg-[#EFF4FB] transition-colors">
                                <i class="fas fa-bell"></i>
                                <span id="notif-count" class="absolute -top-1 -right-1 w-5 h-5 bg-meta-1 text-white text-xs rounded-full flex items-center justify-center hidden">0</span>
                            </button>
                            <div id="notif-menu" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-default border border-stroke z-50">
                                <div class="px-4 py-3 border-b border-stroke flex justify-between items-center">
                                    <span class="font-semibold text-[#1C2434]">Notifikasi</span>
                                    <a href="{{ route('notifikasi.index') }}" class="text-xs text-primary hover:underline">Lihat Semua</a>
                                </div>
                                <div id="notif-list" class="max-h-80 overflow-y-auto"></div>
                            </div>
                        </div>
                        
                        <!-- User -->
                        <div class="flex items-center gap-3 pl-3 border-l border-stroke">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-medium text-[#1C2434]">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-[#64748B] capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 rounded-full bg-[#F9FAFB] flex items-center justify-center text-[#64748B] hover:text-meta-1 hover:bg-red-50 transition-colors" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-8">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle text-meta-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle text-meta-1"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const overlay = document.getElementById('sidebar-overlay');
        const menuBtn = document.getElementById('mobile-menu-btn');
        const collapseBtn = document.getElementById('collapse-btn');
        const collapseIcon = document.getElementById('collapse-icon');

        // Mobile menu
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Close sidebar on link click (mobile)
        document.querySelectorAll('.sidebar-item').forEach(link => {
            link.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 && !e.currentTarget.id.includes('collapse')) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            });
        });

        // Collapse toggle
        let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        function updateSidebarState() {
            if (window.innerWidth >= 1024) {
                if (isCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('main-expanded');
                    mainContent.classList.add('main-collapsed');
                    collapseIcon.classList.remove('fa-bars');
                    collapseIcon.classList.add('fa-indent');
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.classList.remove('main-collapsed');
                    mainContent.classList.add('main-expanded');
                    collapseIcon.classList.remove('fa-indent');
                    collapseIcon.classList.add('fa-bars');
                }
            }
        }

        updateSidebarState();

        collapseBtn.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            updateSidebarState();
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
            updateSidebarState();
        });

        // DataTables
        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    responsive: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        zeroRecords: "Tidak ada data yang cocok",
                        paginate: { first: "Pertama", last: "Terakhir", next: "<i class='fas fa-chevron-right'></i>", previous: "<i class='fas fa-chevron-left'></i>" }
                    },
                    pageLength: 10
                });
            }

            // Notifications
            const notifBtn = document.getElementById('notif-btn');
            const notifMenu = document.getElementById('notif-menu');
            const notifCount = document.getElementById('notif-count');
            const notifList = document.getElementById('notif-list');

            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifMenu.classList.toggle('hidden');
                if (!notifMenu.classList.contains('hidden')) loadNotifications();
            });

            document.addEventListener('click', (e) => {
                if (!document.getElementById('notif-dropdown').contains(e.target)) {
                    notifMenu.classList.add('hidden');
                }
            });

            function loadNotifications() {
                fetch('{{ route("notifikasi.unread") }}')
                    .then(res => res.json())
                    .then(data => {
                        if (data.count > 0) {
                            notifCount.textContent = data.count > 99 ? '99+' : data.count;
                            notifCount.classList.remove('hidden');
                        } else {
                            notifCount.classList.add('hidden');
                        }
                        
                        if (data.notifikasi.length === 0) {
                            notifList.innerHTML = '<div class="p-6 text-center text-[#64748B]"><i class="fas fa-bell-slash text-2xl mb-2 text-[#9CA3AF]"></i><p class="text-sm">Tidak ada notifikasi</p></div>';
                            return;
                        }

                        let html = '';
                        data.notifikasi.forEach(n => {
                            const colors = { success: ['bg-[#ECFDF3]', 'text-meta-3'], warning: ['bg-[#FEF9C3]', 'text-meta-6'], danger: ['bg-[#FEF2F2]', 'text-meta-1'], info: ['bg-[#E0F2FE]', 'text-meta-5'] };
                            const c = colors[n.tipe] || colors.info;
                            html += `
                                <a href="#" onclick="event.preventDefault(); document.getElementById('notif-form-${n.id}').submit();" class="flex items-start gap-3 px-4 py-3 hover:bg-[#F9FAFB] border-b border-stroke transition-colors">
                                    <div class="w-9 h-9 ${c[0]} rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-bell ${c[1]} text-sm"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-[#1C2434] truncate">${n.judul}</p>
                                        <p class="text-xs text-[#64748B] truncate mt-0.5">${n.pesan}</p>
                                    </div>
                                </a>
                                <form id="notif-form-${n.id}" action="/notifikasi/${n.id}/baca" method="POST" class="hidden"><input type="hidden" name="_token" value="{{ csrf_token() }}"></form>
                            `;
                        });
                        notifList.innerHTML = html;
                    })
                    .catch(() => {
                        notifList.innerHTML = '<div class="p-4 text-center text-meta-1 text-sm">Gagal memuat</div>';
                    });
            }

            loadNotifications();
            setInterval(loadNotifications, 30000);
        });
    </script>
    @stack('scripts')
</body>
</html>
