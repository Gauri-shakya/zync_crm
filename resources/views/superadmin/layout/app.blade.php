<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Admin | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">
    
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(243, 244, 246, 0.8);
        }
        .sidebar-item {
            position: relative;
            transition: all 0.2s ease-in-out;
        }
        .sidebar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 0;
            width: 3px;
            background-color: #2563eb;
            border-radius: 0 4px 4px 0;
            transition: height 0.2s ease-in-out;
            opacity: 0;
        }
        .sidebar-item.active::before {
            height: 60%;
            opacity: 1;
        }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 20px;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
        .status-active { background-color: #dcfce7; color: #166534; }
        .status-deactive { background-color: #fee2e2; color: #991b1b; }
        .status-trial { background-color: #dbeafe; color: #1e40af; }
        .status-expired { background-color: #f3f4f6; color: #374151; }
        .status-pending { background-color: #fef9c3; color: #854d0e; }
        .status-suspended { background-color: #fef2f2; color: #991b1b; }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-100 selection:text-blue-700">
    
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-72 bg-white border-r border-slate-100 flex-shrink-0 fixed md:relative z-30 h-screen hidden md:flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <!-- Logo Area -->
            <div class="h-20 flex items-center px-8 border-b border-slate-50 bg-white z-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200 transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-layer-group text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600">
                            ZynCrm
                        </span>
                        <span class="text-[10px] uppercase tracking-widest text-slate-400 font-semibold">Super Admin</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-1">
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Overview</p>
                
                <a href="{{ route('superadmin.dashboard') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.dashboard') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-chart-pie w-5 {{ request()->routeIs('superadmin.dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Dashboard
                </a>

                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 mt-8">Management</p>

                <a href="{{ route('superadmin.customers.index') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.customers.*') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-users w-5 {{ request()->routeIs('superadmin.customers.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Customers
                </a>

                <a href="{{ route('superadmin.trials.index') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.trials.*') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-stopwatch w-5 {{ request()->routeIs('superadmin.trials.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Trials
                </a>

                <a href="{{ route('superadmin.subscriptions.index') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.subscriptions.*') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-credit-card w-5 {{ request()->routeIs('superadmin.subscriptions.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Subscriptions
                </a>

                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 mt-8">System</p>

                <a href="{{ route('ticket.record.index') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('ticket.*') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-headset w-5 {{ request()->routeIs('ticket.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Support Desk
                </a>

                <a href="{{ route('superadmin.mobile-apps.index') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.mobile-apps.*') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-mobile-alt w-5 {{ request()->routeIs('superadmin.mobile-apps.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Mobile App
                </a>

                <a href="{{ route('superadmin.settings.index') }}" 
                   class="sidebar-item flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.settings.*') ? 'active bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-cog w-5 {{ request()->routeIs('superadmin.settings.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors"></i>
                    Settings
                </a>
            </div>

            <!-- Footer User Profile (Bottom Sidebar) -->
            <div class="p-4 border-t border-slate-50">
                <form method="GET" action="{{ route('superadmin.logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm font-medium text-slate-500 rounded-xl hover:bg-red-50 hover:text-red-600 transition-all duration-200 group">
                        <i class="fas fa-sign-out-alt w-5 group-hover:text-red-500 transition-colors"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
            <!-- Top Header -->
            <header class="h-20 glass-nav z-20 flex items-center justify-between px-6 lg:px-10">
                <!-- Mobile Menu Button (Visible on mobile) -->
                <button class="md:hidden text-slate-500 hover:text-slate-700 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Page Title / Breadcrumbs -->
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">@yield('header', 'Dashboard')</h1>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Welcome back, Super Admin</p>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-6">
                    <!-- Search (Optional) -->
                    <!--<div class="hidden lg:flex items-center bg-slate-100 rounded-full px-4 py-2 border border-slate-200 focus-within:border-blue-300 focus-within:ring-2 focus-within:ring-blue-100 transition-all w-64">-->
                    <!--    <i class="fas fa-search text-slate-400 text-sm"></i>-->
                    <!--    <input type="text" placeholder="Search..." class="bg-transparent border-none text-sm ml-2 w-full focus:outline-none text-slate-600 placeholder-slate-400">-->
                    <!--</div>-->

                    <div class="h-8 w-px bg-slate-200"></div>

                    <!-- Notifications -->
                    @php
                        $superadminUser = auth('superadmin')->user();
                        $notifications = $superadminUser ? $superadminUser->notifications()->latest()->get() : collect();
                        $unreadCount = $superadminUser ? $superadminUser->unreadNotifications->count() : 0;
                    @endphp
                    <div class="relative">
                        <button id="notificationBtn" class="relative p-2 text-slate-400 hover:text-blue-600 transition-colors rounded-full hover:bg-blue-50 focus:outline-none">
                            <i class="far fa-bell text-xl"></i>
                            @if($unreadCount > 0)
                                <span id="notificationPing" class="absolute top-0.5 right-0.5 w-4 h-4 bg-red-400 rounded-full animate-ping opacity-75"></span>
                                <span id="notificationBadge" class="absolute top-0.5 right-0.5 w-4 h-4 bg-red-500 rounded-full border-2 border-white flex items-center justify-center text-[10px] font-bold text-white">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="notificationDropdown" class="hidden absolute -right-16 sm:right-0 mt-2 w-[300px] sm:w-80 bg-white rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden z-50 transform origin-top-right transition-all">
                            <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                <h3 class="text-sm font-bold text-slate-800">Notifications</h3>
                                @if($unreadCount > 0)
                                    <span id="newNotifLabel" class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">{{ $unreadCount }} New</span>
                                @endif
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                @forelse($notifications as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-item block px-4 py-3 border-b border-gray-50 transition-colors group {{ $notification->read_at ? 'bg-gray-50/50 grayscale-[0.8] opacity-75' : 'hover:bg-indigo-50/50 bg-white' }}">
                                        <div class="flex gap-3">
                                            <div class="w-8 h-8 rounded-full {{ $notification->read_at ? 'bg-indigo-50 text-indigo-400' : 'bg-indigo-100 text-indigo-600' }} flex-shrink-0 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-{{ $notification->data['icon'] ?? 'bell' }} text-xs"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start mb-0.5">
                                                    <p class="text-xs {{ $notification->read_at ? 'font-medium text-gray-800' : 'font-bold text-gray-900' }} truncate">
                                                        {{ $notification->data['title'] ?? 'Notification' }}
                                                    </p>
                                                    <span class="text-[9px] font-medium text-gray-400 whitespace-nowrap ml-2 uppercase tracking-wider">
                                                        {{ $notification->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                                    </span>
                                                </div>
                                                <p class="text-[11px] {{ $notification->read_at ? 'text-gray-500' : 'text-gray-600' }} leading-tight line-clamp-2">
                                                    {{ $notification->data['message'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center">
                                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                                            <i class="fas fa-bell-slash text-xl"></i>
                                        </div>
                                        <p class="text-xs font-medium text-gray-500">No notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <div id="markAllContainer" class="px-4 py-2 text-center bg-gray-50/50 border-t {{ $unreadCount > 0 ? '' : 'hidden' }}">
                                <button onclick="markNotificationsRead()" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition-colors">
                                    Mark all as read
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="flex items-center gap-3 pl-2">
                        <div class="text-right hidden sm:block leading-tight">
                            <p class="text-sm font-bold text-slate-700">Admin User</p>
                            <p class="text-[10px] uppercase font-bold text-blue-600 tracking-wide">Super Admin</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 p-[2px] shadow-md shadow-blue-100 cursor-pointer hover:shadow-lg transition-shadow">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <span class="font-bold text-transparent bg-clip-text bg-gradient-to-tr from-blue-600 to-indigo-600 text-xs">SA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
                <div class="max-w-7xl mx-auto space-y-6">
                    @if(session('success'))
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 flex items-center gap-4 shadow-sm animate-fade-in-down" role="alert">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-emerald-600 text-sm"></i>
                            </div>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-red-800 flex items-center gap-4 shadow-sm animate-fade-in-down" role="alert">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation text-red-600 text-sm"></i>
                            </div>
                            <span class="font-medium text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out forwards;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notification Dropdown Toggle Logic
            const notifBtn = document.getElementById('notificationBtn');
            const notifDropdown = document.getElementById('notificationDropdown');
            
            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                    
                    // Auto-hide the count badge when they view the notifications
                    const badge = document.getElementById('notificationBadge');
                    const ping = document.getElementById('notificationPing');
                    const newLabel = document.getElementById('newNotifLabel');
                    
                    if (badge && badge.style.display !== 'none') {
                        badge.style.display = 'none';
                        if (ping) ping.style.display = 'none';
                        if (newLabel) newLabel.style.display = 'none';
                        
                        // Send silent background request to mark as read in DB
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        fetch('/superadmin/notifications/read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        }).catch(console.error);
                    }
                });
                
                document.addEventListener('click', function(e) {
                    if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }
        });
        
        function markNotificationsRead() {
            const badge = document.getElementById('notificationBadge');
            const ping = document.getElementById('notificationPing');
            const newLabel = document.getElementById('newNotifLabel');
            const markAllContainer = document.getElementById('markAllContainer');
            
            if (badge) badge.style.display = 'none';
            if (ping) ping.style.display = 'none';
            if (newLabel) newLabel.style.display = 'none';
            if (markAllContainer) markAllContainer.classList.add('hidden');
            
            // Update items styling to read state
            document.querySelectorAll('.notif-item').forEach(item => {
                // Change classes for read state
                item.className = 'notif-item block px-4 py-3 border-b border-gray-50 transition-colors group bg-gray-50/50 grayscale-[0.8] opacity-75';
                
                // Change icon circle colors
                const iconCircle = item.querySelector('.w-8.h-8.rounded-full');
                if (iconCircle) {
                    iconCircle.classList.remove('bg-indigo-100', 'text-indigo-600');
                    iconCircle.classList.add('bg-indigo-50', 'text-indigo-400');
                }
                
                // Change text colors
                const titleText = item.querySelector('p.truncate');
                if (titleText) {
                    titleText.classList.remove('font-bold', 'text-gray-900');
                    titleText.classList.add('font-medium', 'text-gray-800');
                }
                const msgText = item.querySelectorAll('p')[1];
                if (msgText) {
                    msgText.classList.remove('text-gray-600');
                    msgText.classList.add('text-gray-500');
                }
            });
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/superadmin/notifications/read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).catch(console.error);
        }
    </script>
    @yield('scripts')
</body>
</html>