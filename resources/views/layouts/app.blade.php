<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIAKAD') - Sistem Informasi Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#8b5cf6',
                        sidebar: '#1e1b4b',
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-link.active { background: rgba(99, 102, 241, 0.2); border-left: 3px solid #6366f1; }
        .sidebar-link:hover { background: rgba(99, 102, 241, 0.1); }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        
        /* Sidebar transitions */
        .sidebar-expanded { width: 256px; }
        .sidebar-collapsed { width: 72px; }
        .sidebar-collapsed .sidebar-text { display: none; }
        .sidebar-collapsed .sidebar-link { justify-content: center; padding-left: 0; padding-right: 0; }
        .sidebar-collapsed .sidebar-link i { margin-right: 0; width: auto; }
        .sidebar-collapsed .sidebar-header-text { display: none; }
        .sidebar-collapsed .sidebar-section-title { display: none; }
        .sidebar-collapsed .sidebar-logo { justify-content: center; }
        
        /* Main content transitions */
        .main-expanded { margin-left: 256px; }
        .main-collapsed { margin-left: 72px; }
        
        /* Mobile: no margin */
        @media (max-width: 1023px) {
            .main-expanded, .main-collapsed { margin-left: 0 !important; }
        }
        
        /* Tooltip for collapsed sidebar */
        .sidebar-collapsed .sidebar-link { position: relative; }
        .sidebar-collapsed .sidebar-link:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1e1b4b;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 100;
            margin-left: 10px;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        .sidebar-collapsed .sidebar-link:hover::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #1e1b4b;
            margin-left: -2px;
        }
        
        /* DataTables custom styling */
        .dataTables_wrapper { padding: 0; }
        .dataTables_wrapper .dataTables_length select { 
            padding: 0.5rem 2rem 0.5rem 0.75rem; 
            border-radius: 0.5rem; 
            border: 1px solid #d1d5db;
        }
        .dataTables_wrapper .dataTables_filter input { 
            padding: 0.5rem 1rem; 
            border-radius: 0.5rem; 
            border: 1px solid #d1d5db;
            margin-left: 0.5rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            margin: 0 0.125rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #6366f1 !important;
            color: white !important;
            border: none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e0e7ff !important;
            color: #4338ca !important;
            border: none;
        }
        table.dataTable thead th { 
            background: #f9fafb; 
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        table.dataTable tbody tr:hover { background: #f3f4f6 !important; }
        table.dataTable.no-footer { border-bottom: none; }
        .dataTables_info, .dataTables_length, .dataTables_filter { 
            margin-bottom: 1rem; 
            font-size: 0.875rem;
            color: #6b7280;
        }
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter { 
                float: none; 
                text-align: left;
                margin-bottom: 0.75rem;
            }
            .dataTables_wrapper .dataTables_filter input { 
                width: 100%; 
                margin-left: 0;
                margin-top: 0.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden fixed top-4 left-4 z-50 bg-primary text-white p-2 rounded-lg shadow-lg">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-expanded bg-sidebar min-h-screen fixed left-0 top-0 text-white z-40 transform -translate-x-full lg:translate-x-0 transition-all duration-300 flex flex-col">
            <div class="p-4 border-b border-indigo-900 flex-shrink-0">
                <div class="sidebar-logo flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="sidebar-header-text font-bold text-lg">SIAKAD</span>
                </div>
            </div>
            <nav class="p-4 flex-1 overflow-y-auto scrollbar-hide">
                @yield('sidebar')
            </nav>
            <!-- Collapse Button (Desktop only) -->
            <div class="p-4 border-t border-indigo-900 hidden lg:block flex-shrink-0">
                <button id="collapse-btn" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white" data-title="Toggle Sidebar">
                    <i class="fas fa-chevron-left w-5 transition-transform duration-300" id="collapse-icon"></i>
                    <span class="sidebar-text">Collapse</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 min-h-screen main-expanded transition-all duration-300">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm px-4 lg:px-6 py-4 flex justify-between items-center sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <div class="lg:hidden w-8"></div>
                    <div class="relative hidden sm:block">
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border rounded-lg w-48 lg:w-64 focus:outline-none focus:ring-2 focus:ring-primary">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Notification Dropdown -->
                    <div class="relative" id="notif-dropdown">
                        <button id="notif-btn" class="relative p-2 text-gray-500 hover:text-primary">
                            <i class="fas fa-bell text-lg sm:text-xl"></i>
                            <span id="notif-count" class="absolute -top-1 -right-1 w-4 h-4 sm:w-5 sm:h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center hidden">0</span>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="notif-menu" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border z-50">
                            <div class="p-3 border-b flex justify-between items-center">
                                <span class="font-semibold text-gray-800">Notifikasi</span>
                                <a href="{{ route('notifikasi.index') }}" class="text-xs text-indigo-600 hover:underline">Lihat Semua</a>
                            </div>
                            <div id="notif-list" class="max-h-80 overflow-y-auto">
                                <div class="p-4 text-center text-gray-500 text-sm">
                                    <i class="fas fa-spinner fa-spin"></i> Memuat...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-medium text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-1 sm:ml-2">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-500" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    <!-- jQuery & DataTables JS -->
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

        // Mobile menu toggle
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Close sidebar when clicking a link on mobile
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 && !e.currentTarget.id.includes('collapse')) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            });
        });

        // Desktop collapse toggle
        let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        function updateSidebarState() {
            if (window.innerWidth >= 1024) {
                if (isCollapsed) {
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('main-expanded');
                    mainContent.classList.add('main-collapsed');
                    collapseIcon.classList.add('rotate-180');
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                    sidebar.classList.add('sidebar-expanded');
                    mainContent.classList.remove('main-collapsed');
                    mainContent.classList.add('main-expanded');
                    collapseIcon.classList.remove('rotate-180');
                }
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
            }
        }

        // Initialize
        updateSidebarState();

        collapseBtn.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            updateSidebarState();
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
            updateSidebarState();
        });

        // Initialize DataTables globally
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
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    pageLength: 10,
                    ordering: true
                });
            }

            // Notification System
            const notifBtn = document.getElementById('notif-btn');
            const notifMenu = document.getElementById('notif-menu');
            const notifCount = document.getElementById('notif-count');
            const notifList = document.getElementById('notif-list');

            // Toggle dropdown
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifMenu.classList.toggle('hidden');
                if (!notifMenu.classList.contains('hidden')) {
                    loadNotifications();
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!document.getElementById('notif-dropdown').contains(e.target)) {
                    notifMenu.classList.add('hidden');
                }
            });

            // Load notifications
            function loadNotifications() {
                fetch('{{ route("notifikasi.unread") }}')
                    .then(res => res.json())
                    .then(data => {
                        updateNotifCount(data.count);
                        renderNotifications(data.notifikasi);
                    })
                    .catch(err => {
                        notifList.innerHTML = '<div class="p-4 text-center text-red-500 text-sm">Gagal memuat</div>';
                    });
            }

            function updateNotifCount(count) {
                if (count > 0) {
                    notifCount.textContent = count > 99 ? '99+' : count;
                    notifCount.classList.remove('hidden');
                } else {
                    notifCount.classList.add('hidden');
                }
            }

            function renderNotifications(notifikasi) {
                if (notifikasi.length === 0) {
                    notifList.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm"><i class="fas fa-bell-slash mr-2"></i>Tidak ada notifikasi baru</div>';
                    return;
                }

                let html = '';
                notifikasi.forEach(n => {
                    const iconClass = n.tipe === 'success' ? 'fa-check text-green-600' : 
                                     n.tipe === 'warning' ? 'fa-exclamation text-yellow-600' : 
                                     n.tipe === 'danger' ? 'fa-times text-red-600' : 'fa-bell text-blue-600';
                    const bgClass = n.tipe === 'success' ? 'bg-green-100' : 
                                   n.tipe === 'warning' ? 'bg-yellow-100' : 
                                   n.tipe === 'danger' ? 'bg-red-100' : 'bg-blue-100';
                    
                    html += `
                        <a href="/notifikasi/${n.id}/baca" class="block p-3 hover:bg-gray-50 border-b" onclick="event.preventDefault(); document.getElementById('notif-form-${n.id}').submit();">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 ${bgClass} rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas ${iconClass} text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">${n.judul}</p>
                                    <p class="text-xs text-gray-500 truncate">${n.pesan}</p>
                                </div>
                            </div>
                        </a>
                        <form id="notif-form-${n.id}" action="/notifikasi/${n.id}/baca" method="POST" class="hidden">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    `;
                });
                notifList.innerHTML = html;
            }

            // Initial load
            loadNotifications();

            // Refresh every 30 seconds
            setInterval(loadNotifications, 30000);
        });
    </script>
    @stack('scripts')
</body>
</html>