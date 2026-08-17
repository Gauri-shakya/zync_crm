@extends('components.layout')

@section('content')

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<div class="flex-1 overflow-auto p-3 sm:p-4 md:p-5 lg:p-6 relative bg-slate-50/30">
    @unless(auth()->user()->hasRole('admin'))
    <!-- Particles Canvas (Only for non-admin) -->
    <canvas id="dashboard-particles" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>
    @endunless

    <div class="max-w-7xl mx-auto space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6 relative z-10">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl sm:rounded-2xl p-4 sm:p-5 text-white shadow-[0_8px_30px_-4px_rgba(79,70,229,0.3)] flex items-center justify-between relative overflow-hidden mx-2 sm:mx-3 md:mx-0">
            <!-- Decorative shapes -->
            <div class="absolute right-0 top-0 w-48 h-48 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-16 pointer-events-none"></div>
            <div class="absolute right-32 bottom-0 w-32 h-32 bg-white opacity-5 rounded-full transform translate-y-12 pointer-events-none"></div>
            
            <div class="relative z-10">
                <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-tight flex items-center gap-2">
                    Welcome back, {{ auth()->user()->name }}! <span class="animate-bounce inline-block">👋</span>
                </h2>
                <p class="text-[10px] sm:text-xs md:text-sm text-indigo-100 mt-0.5 sm:mt-1">Here's what's happening with your projects today.</p>
            </div>
            
            @unless(auth()->user()->hasRole('admin'))
            <div class="relative z-10">
                <button onclick="document.getElementById('customizeCardsModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-white/20 hover:bg-white/30 rounded-lg sm:rounded-xl transition-all duration-300 backdrop-blur-md border border-white/30 shadow-sm hover:shadow-md hover:scale-105 active:scale-95">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Customize
                </button>
            </div>
            @endunless
        </div>

        @hasrole('admin')
        <!-- Stats Cards - Mobile optimized grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5 lg:gap-6 px-2 sm:px-3 md:px-0">
            <!-- Revenue Card -->
            <div onclick="openSidebar('users')" class="cursor-pointer fade-in bg-white rounded-lg sm:rounded-xl border border-gray-200 p-3 sm:p-4 md:p-5 lg:p-6 relative overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                <div class="absolute top-0 right-0 w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 transform translate-x-3 -translate-y-3 sm:translate-x-4 sm:-translate-y-4 md:translate-x-5 md:-translate-y-5 lg:translate-x-6 lg:-translate-y-6 bg-green-500 rounded-full opacity-10 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start">
                    <div class="flex-1 pr-2">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Users</p>
                        <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mt-1 sm:mt-1.5 md:mt-2 text-gray-900 leading-none">{{ $totalUsers }}</h3>
                        <div class="flex items-center mt-1.5 sm:mt-2 md:mt-3">
                            @php $isUserPos = $userGrowth >= 0; @endphp
                            <span class="text-xs font-semibold {{ $isUserPos ? 'text-green-600' : 'text-red-600' }}">
                                {{ $isUserPos ? '↑' : '↓' }} {{ number_format(abs($userGrowth), 1) }}%
                            </span>
                            <span class="text-xs text-gray-500 ml-1">vs last month</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-100 shadow-sm ml-2 flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Clients Card -->
            <div onclick="openSidebar('attendance')" class="cursor-pointer fade-in bg-white rounded-lg sm:rounded-xl border border-gray-200 p-3 sm:p-4 md:p-5 lg:p-6 relative overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                <div class="absolute top-0 right-0 w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 transform translate-x-3 -translate-y-3 sm:translate-x-4 sm:-translate-y-4 md:translate-x-5 md:-translate-y-5 lg:translate-x-6 lg:-translate-y-6 bg-blue-500 rounded-full opacity-10 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start">
                    <div class="flex-1 pr-2">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Present Today</p>
                        <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mt-1 sm:mt-1.5 md:mt-2 text-gray-900 leading-none">{{ $presentToday }}</h3>
                        <div class="flex items-center mt-1.5 sm:mt-2 md:mt-3">
                            @php $isAttPos = $attendanceGrowth >= 0; @endphp
                            <span class="text-xs font-semibold {{ $isAttPos ? 'text-green-600' : 'text-red-600' }}">
                                {{ $isAttPos ? '↑' : '↓' }} {{ number_format(abs($attendanceGrowth), 1) }}%
                            </span>
                            <span class="text-xs text-gray-500 ml-1">vs yesterday</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-100 shadow-sm ml-2 flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Campaigns Card (Total Clients) -->
            <div onclick="openSidebar('clients')" class="cursor-pointer fade-in bg-white rounded-lg sm:rounded-xl border border-gray-200 p-3 sm:p-4 md:p-5 lg:p-6 relative overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                <div class="absolute top-0 right-0 w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 transform translate-x-3 -translate-y-3 sm:translate-x-4 sm:-translate-y-4 md:translate-x-5 md:-translate-y-5 lg:translate-x-6 lg:-translate-y-6 bg-purple-500 rounded-full opacity-10 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start">
                    <div class="flex-1 pr-2">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Clients</p>
                        <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mt-1 sm:mt-1.5 md:mt-2 text-gray-900 leading-none">{{ $totalClients }}</h3>
                        <div class="flex items-center mt-1.5 sm:mt-2 md:mt-3">
                            @php $isClientPos = $clientGrowth >= 0; @endphp
                            <span class="text-xs font-semibold {{ $isClientPos ? 'text-green-600' : 'text-red-600' }}">
                                {{ $isClientPos ? '↑' : '↓' }} {{ number_format(abs($clientGrowth), 1) }}%
                            </span>
                            <span class="text-xs text-gray-500 ml-1">vs last month</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-100 shadow-sm ml-2 flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 0h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- ROI Card (Total Contacts) -->
            <div onclick="openSidebar('contacts')" class="cursor-pointer fade-in bg-white rounded-lg sm:rounded-xl border border-gray-200 p-3 sm:p-4 md:p-5 lg:p-6 relative overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                <div class="absolute top-0 right-0 w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 transform translate-x-3 -translate-y-3 sm:translate-x-4 sm:-translate-y-4 md:translate-x-5 md:-translate-y-5 lg:translate-x-6 lg:-translate-y-6 bg-orange-500 rounded-full opacity-10 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start">
                    <div class="flex-1 pr-2">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Contacts</p>
                        <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold mt-1 sm:mt-1.5 md:mt-2 text-gray-900 leading-none">{{ $totalContacts }}</h3>
                        <div class="flex items-center mt-1.5 sm:mt-2 md:mt-3">
                            @php $isContactPos = $contactGrowth >= 0; @endphp
                            <span class="text-xs font-semibold {{ $isContactPos ? 'text-green-600' : 'text-red-600' }}">
                                {{ $isContactPos ? '↑' : '↓' }} {{ number_format(abs($contactGrowth), 1) }}%
                            </span>
                            <span class="text-xs text-gray-500 ml-1">vs last month</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-100 shadow-sm ml-2 flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section - Stack on mobile, side-by-side on larger screens -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 md:gap-5 lg:gap-6 px-2 sm:px-3 md:px-0">
            <!-- Users Chart -->
            <div class="bg-white rounded-lg sm:rounded-xl border border-gray-200 shadow-sm">
                <div class="p-3 sm:p-4 md:p-5 lg:p-6 border-b border-gray-200">
                    <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 leading-tight">Users (last 12 months)</h3>
                </div>
                <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                    <div class="relative h-40 sm:h-48 md:h-56 lg:h-64">
                        <canvas id="usersChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Attendance Chart -->
            <div class="bg-white rounded-lg sm:rounded-xl border border-gray-200 shadow-sm">
                <div class="p-3 sm:p-4 md:p-5 lg:p-6 border-b border-gray-200">
                    <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 leading-tight">Attendances (last 12 months)</h3>
                </div>
                <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                    <div class="relative h-40 sm:h-48 md:h-56 lg:h-64">
                        <canvas id="attChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- User Dashboard (Non-Admin) -->
        <div class="mb-4 px-2 sm:px-3 md:px-0">
            <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 leading-tight">My Shortcuts</h3>
        </div>

        <!-- Stats Cards - Shortcut Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5 lg:gap-6 px-2 sm:px-3 md:px-0 mb-6">
            @php
            $sidebarItems = [
                ['name' => 'Users', 'route' => 'users', 'permission' => 'users', 'bg' => 'from-blue-50 to-blue-100 border-blue-100', 'text' => 'text-blue-600', 'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                ['name' => 'Roles', 'route' => 'roles', 'permission' => 'roles', 'bg' => 'from-indigo-50 to-indigo-100 border-indigo-100', 'text' => 'text-indigo-600', 'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                ['name' => 'Besdex', 'route' => 'clients.index', 'permission' => 'besdex', 'bg' => 'from-purple-50 to-purple-100 border-purple-100', 'text' => 'text-purple-600', 'icon' => '<path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                ['name' => 'Attendance Records', 'route' => 'attendance-record.index', 'permission' => 'Attendance Records', 'bg' => 'from-emerald-50 to-emerald-100 border-emerald-100', 'text' => 'text-emerald-600', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>'],
                ['name' => 'My Leads', 'route' => 'myleads', 'permission' => 'my leads', 'bg' => 'from-blue-50 to-blue-100 border-blue-100', 'text' => 'text-blue-600', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="23 11 20 14 17 11"/>'],
                ['name' => 'Proposal', 'route' => 'proposal', 'permission' => 'proposal', 'bg' => 'from-pink-50 to-pink-100 border-pink-100', 'text' => 'text-pink-600', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>'],
                ['name' => 'My Attendance', 'route' => 'my-attendance.index', 'permission' => 'My Attendance', 'bg' => 'from-teal-50 to-teal-100 border-teal-100', 'text' => 'text-teal-600', 'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
                ['name' => 'Salary', 'route' => 'salary.index', 'permission' => 'salary', 'bg' => 'from-green-50 to-green-100 border-green-100', 'text' => 'text-green-600', 'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
                ['name' => 'To-Do', 'route' => 'todo.index', 'permission' => 'To-Do', 'bg' => 'from-yellow-50 to-yellow-100 border-yellow-100', 'text' => 'text-yellow-600', 'icon' => '<polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>'],
                ['name' => 'Tasks', 'route' => 'tasks.index', 'permission' => 'task', 'bg' => 'from-orange-50 to-orange-100 border-orange-100', 'text' => 'text-orange-600', 'icon' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>'],
                ['name' => 'Calendar', 'route' => 'calendar.index', 'permission' => 'Calendar', 'bg' => 'from-red-50 to-red-100 border-red-100', 'text' => 'text-red-600', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                ['name' => 'Links and Remarks', 'route' => 'linksandremark.index', 'permission' => 'Links and Remarks', 'bg' => 'from-cyan-50 to-cyan-100 border-cyan-100', 'text' => 'text-cyan-600', 'icon' => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>'],
                ['name' => 'Invoice', 'route' => 'invoices.index', 'permission' => 'invoice', 'bg' => 'from-slate-50 to-slate-100 border-slate-100', 'text' => 'text-slate-600', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>'],
                ['name' => 'Leave Record', 'route' => 'employeeportal.index', 'permission' => 'Leave Record', 'bg' => 'from-lime-50 to-lime-100 border-lime-100', 'text' => 'text-lime-600', 'icon' => '<path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>'],
                ['name' => 'Leave Apply', 'route' => 'employeeportal.index', 'permission' => 'Leave Apply', 'bg' => 'from-rose-50 to-rose-100 border-rose-100', 'text' => 'text-rose-600', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/>'],
                ['name' => 'Contact', 'route' => 'contacts.index', 'permission' => 'contact', 'bg' => 'from-sky-50 to-sky-100 border-sky-100', 'text' => 'text-sky-600', 'icon' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>'],
                ['name' => 'Report', 'route' => 'rr.index', 'permission' => 'report', 'bg' => 'from-violet-50 to-violet-100 border-violet-100', 'text' => 'text-violet-600', 'icon' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>'],
                ['name' => 'Notepad', 'route' => 'notepad.index', 'permission' => 'notepad', 'bg' => 'from-amber-50 to-amber-100 border-amber-100', 'text' => 'text-amber-600', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>'],
                ['name' => 'My Tickets', 'route' => 'user.support.ticket.index', 'permission' => 'Raise Ticket', 'bg' => 'from-stone-50 to-stone-100 border-stone-100', 'text' => 'text-stone-600', 'icon' => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>'],
                ['name' => 'Upgrade Plan', 'route' => 'upgrade.index', 'permission' => null, 'bg' => 'from-orange-50 to-orange-100 border-orange-100', 'text' => 'text-orange-600', 'icon' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>']
            ];
            @endphp
            
            @php 
                $displayedCards = 0; 
                $preferences = auth()->user()->dashboard_preferences;
            @endphp
            @foreach($sidebarItems as $item)
                @if(!$item['permission'] || auth()->user()->hasRole('admin') || auth()->user()->can($item['permission']))
                    @php 
                        if (is_array($preferences)) {
                            if (!in_array($item['name'], $preferences)) continue;
                        } else {
                            // Default behavior: show first 6 allowed items
                            if($displayedCards >= 6) continue;
                        }
                        $displayedCards++;
                    @endphp
                <div onclick="window.location.href='{{ route($item['route']) }}'" class="cursor-pointer bg-white rounded-xl sm:rounded-2xl border border-gray-100/80 p-4 sm:p-5 md:p-6 relative overflow-hidden shadow-[0_8px_24px_-8px_rgba(0,0,0,0.12)] hover:shadow-[0_16px_32px_-12px_rgba(79,70,229,0.15)] hover:-translate-y-1.5 hover:border-indigo-200 transition-all duration-300 group flex items-center justify-between">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br {{ $item['bg'] }} rounded-full opacity-30 group-hover:scale-150 transition-transform duration-500 blur-xl z-0 pointer-events-none"></div>
                    <div class="relative z-10">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-indigo-400 transition-colors">Shortcut</p>
                        <h3 class="text-sm sm:text-base md:text-lg font-extrabold text-gray-800 leading-tight group-hover:text-indigo-900 transition-colors">{{ $item['name'] }}</h3>
                    </div>
                    <div class="relative z-10 p-2.5 sm:p-3 rounded-2xl bg-gradient-to-br {{ $item['bg'] }} border border-white/50 shadow-[0_4px_12px_rgba(0,0,0,0.05)] flex-shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ $item['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon'] !!}</svg>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endhasrole

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg sm:rounded-xl border border-gray-200 shadow-sm mx-2 sm:mx-3 md:mx-0">
            <div class="p-3 sm:p-4 md:p-5 lg:p-6 border-b border-gray-200">
                <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 flex items-center gap-1.5 sm:gap-2 leading-tight">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-4.5 md:h-4.5 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Activity
                </h3>
            </div>
            <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                <div class="space-y-3 sm:space-y-4">
                    @forelse($recentTasks as $task)
                        <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-3 pb-3 sm:pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                            <div class="flex items-start gap-2 sm:gap-3 flex-1 min-w-0">
                                <div class="p-1.5 sm:p-2 rounded-lg sm:rounded-lg bg-blue-100 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $task->title ?? 'Untitled task' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 sm:mt-1 leading-relaxed">{{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y • h:i A') }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-1.5 sm:px-2 py-0.5 sm:py-1 bg-gray-100 text-gray-700 rounded-full self-start sm:self-auto mt-1 sm:mt-0">
                                {{ $task->type ?? 'Task' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs sm:text-sm text-gray-500 text-center py-3 sm:py-4">No recent tasks found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Right Sidebar (Drawer) -->
<div id="statsSidebar" class="fixed inset-0 z-[100] invisible transition-all duration-300">
    <!-- Backdrop -->
    <div id="sidebarBackdrop" class="absolute inset-0 bg-gray-900/0 transition-all duration-300 cursor-pointer" onclick="closeSidebar()"></div>
    
    <!-- Sidebar Content -->
    <div id="sidebarContent" class="absolute top-0 right-0 h-full w-full sm:w-[400px] md:w-[450px] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        <!-- Header -->
        <div class="p-4 sm:p-6 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div>
                <h3 id="sidebarTitle" class="text-lg sm:text-xl font-bold text-gray-900">Details</h3>
                <p id="sidebarSubtitle" class="text-xs sm:text-sm text-gray-500 mt-1">Viewing summary information</p>
            </div>
            <button onclick="closeSidebar()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content Area -->
        <div id="sidebarBody" class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50/50">
            <div id="sidebarLoading" class="hidden flex flex-col items-center justify-center h-full space-y-3">
                <div class="w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-sm text-gray-500">Loading information...</p>
            </div>
            <div id="sidebarData" class="space-y-4">
                <!-- Data will be injected here -->
            </div>
        </div>

        <!-- Footer -->
        <div class="p-4 sm:p-6 border-t border-gray-100 bg-white sticky bottom-0">
            <button onclick="closeSidebar()" class="w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                Close Panel
            </button>
        </div>
    </div>
</div>

<!-- Chart.js CDN + initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Injected data for sidebar
    const dashboardData = {
        users: @json($usersList),
        attendance: @json($attendanceList),
        clients: @json($clientsList),
        contacts: @json($contactsList)
    };

    // Sidebar logic
    function openSidebar(type) {
        const sidebar = document.getElementById('statsSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const content = document.getElementById('sidebarContent');
        const title = document.getElementById('sidebarTitle');
        const subtitle = document.getElementById('sidebarSubtitle');
        const dataArea = document.getElementById('sidebarData');
        const loading = document.getElementById('sidebarLoading');

        // Show sidebar container and backdrop
        sidebar.classList.remove('invisible');
        backdrop.classList.replace('bg-gray-900/0', 'bg-gray-900/50');
        
        // Slight delay for smooth backdrop fade before content slides
        setTimeout(() => {
            content.classList.remove('translate-x-full');
        }, 50);

        // Update titles based on type
        let info = {
            'users': { title: 'User Directory', subtitle: 'Manage active system users' },
            'attendance': { title: 'Today\'s Attendance', subtitle: 'List of users present today' },
            'clients': { title: 'Client Portfolio', subtitle: 'Manage your current client list' },
            'contacts': { title: 'Contact List', subtitle: 'Viewing all system contacts' }
        };

        if (info[type]) {
            title.textContent = info[type].title;
            subtitle.textContent = info[type].subtitle;
        }

        // Simulate data loading
        dataArea.innerHTML = '';
        loading.classList.remove('hidden');

        setTimeout(() => {
            loading.classList.add('hidden');
            
            // Fetch data from injected dashboardData
            let items = [];
            if (type === 'users') {
                items = dashboardData.users.map(u => ({
                    name: u.name,
                    info: u.role || u.email,
                    status: 'Active'
                }));
            } else if (type === 'attendance') {
                items = dashboardData.attendance.map(a => ({
                    name: a.employee ? a.employee.name : 'Unknown',
                    info: `In: ${a.punch_in}`,
                    status: 'Present'
                }));
            } else if (type === 'clients') {
                items = dashboardData.clients.map(c => ({
                    name: c.company_name,
                    info: c.industry || 'No industry specified',
                    status: c.status || 'Active'
                }));
            } else if (type === 'contacts') {
                items = dashboardData.contacts.map(c => ({
                    name: c.name,
                    info: c.phone || c.email || 'No contact info',
                    status: 'Contacted'
                }));
            }

            // If no items found
            if (items.length === 0) {
                dataArea.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">No data found</p>
                        <p class="text-xs text-gray-500 mt-1">There are no records to display in this list.</p>
                    </div>
                `;
                return;
            }

            // Inject items
            items.forEach((item, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = `p-4 bg-white rounded-xl border border-gray-100 shadow-sm animate-fadeIn opacity-0`;
                itemDiv.style.animationDelay = `${index * 0.05}s`;
                itemDiv.style.animationFillMode = 'forwards';
                
                itemDiv.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="min-w-0 flex-1 pr-4">
                            <p class="text-sm font-bold text-gray-900 truncate">${item.name}</p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">${item.info}</p>
                        </div>
                        <span class="px-2 py-1 text-[10px] font-bold rounded-full ${item.status === 'Online' || item.status === 'Present' || item.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'} uppercase whitespace-nowrap">
                            ${item.status}
                        </span>
                    </div>
                `;
                dataArea.appendChild(itemDiv);
            });
        }, 600);
    }

    function closeSidebar() {
        const sidebar = document.getElementById('statsSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const content = document.getElementById('sidebarContent');

        content.classList.add('translate-x-full');
        backdrop.classList.replace('bg-gray-900/50', 'bg-gray-900/0');
        
        setTimeout(() => {
            sidebar.classList.add('invisible');
        }, 300);
    }

    // Prevent zoom on mobile
    document.addEventListener('touchstart', function(event) {
        if (event.touches.length > 1) {
            event.preventDefault();
        }
    }, { passive: false });

    // Prevent double-tap zoom
    let lastTouchEnd = 0;
    document.addEventListener('touchend', function(event) {
        const now = (new Date()).getTime();
        if (now - lastTouchEnd <= 300) {
            event.preventDefault();
        }
        lastTouchEnd = now;
    }, false);

    // Ensure font size is 16px for inputs to prevent iOS zoom
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            @media screen and (max-width: 767px) {
                input, select, textarea {
                    font-size: 16px !important;
                }
            }
        `;
        document.head.appendChild(style);
    });

    (function () {
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            const usersLabels = @json($usersChartLabels);
            const usersData   = @json($usersChartData);
            const attLabels = @json($attChartLabels);
            const attData   = @json($attChartData);

            // Users chart
            const ctxUsersCanvas = document.getElementById('usersChart');
            if (ctxUsersCanvas) {
                const ctxUsers = ctxUsersCanvas.getContext('2d');
                // Create gradient for Users Chart
                const gradientUsers = ctxUsers.createLinearGradient(0, 0, 0, 400);
                gradientUsers.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); 
                gradientUsers.addColorStop(1, 'rgba(59, 130, 246, 0.0)'); 

                new Chart(ctxUsers, {
                    type: 'line',
                    data: {
                        labels: usersLabels,
                        datasets: [{
                            label: 'New users',
                            data: usersData,
                            fill: true,
                            backgroundColor: gradientUsers,
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 3,
                            tension: 0.4, // Smooth bezier curve
                            pointRadius: 0, // Clean look, no points by default
                            pointHoverRadius: 6,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#111827',
                                bodyColor: '#4b5563',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true,
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 }
                            }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: {
                                    color: '#9ca3af',
                                    font: { size: 11 },
                                    padding: 10
                                },
                                grid: {
                                    color: '#f3f4f6',
                                    borderDash: [4, 4],
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#9ca3af',
                                    font: { size: 11 },
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 6
                                },
                                grid: { display: false }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest'
                        }
                    }
                });
            }

            // Attendance chart
            const ctxAttCanvas = document.getElementById('attChart');
            if (ctxAttCanvas) {
                const ctxAtt = ctxAttCanvas.getContext('2d');
                // Create gradient for Attendance Chart
                const gradientAtt = ctxAtt.createLinearGradient(0, 0, 0, 400);
                gradientAtt.addColorStop(0, 'rgba(139, 92, 246, 0.9)'); 
                gradientAtt.addColorStop(1, 'rgba(139, 92, 246, 0.4)'); 

                new Chart(ctxAtt, {
                    type: 'bar',
                    data: {
                        labels: attLabels,
                        datasets: [{
                            label: 'Attendance entries',
                            data: attData,
                            backgroundColor: gradientAtt,
                            borderRadius: 6,
                            barThickness: 'flex',
                            maxBarThickness: 32,
                            hoverBackgroundColor: 'rgba(139, 92, 246, 1)'
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#111827',
                                bodyColor: '#4b5563',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: {
                                    color: '#9ca3af',
                                    font: { size: 11 },
                                    padding: 10
                                },
                                grid: {
                                    color: '#f3f4f6',
                                    borderDash: [4, 4],
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#9ca3af',
                                    font: { size: 11 },
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 6
                                },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // Helper functions for chart font sizes
            function getChartFontSize() {
                return window.innerWidth < 640 ? 10 : 11;
            }
            function getTooltipFontSize() {
                return window.innerWidth < 640 ? 11 : 12;
            }

            // Update chart font sizes on window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const chartFontSize = getChartFontSize();
                    const tooltipFontSize = getTooltipFontSize();
                    
                    Chart.defaults.font.size = chartFontSize;
                    Chart.defaults.plugins.tooltip.bodyFont.size = tooltipFontSize;
                    Chart.defaults.plugins.tooltip.titleFont.size = tooltipFontSize;
                    
                    // Update existing charts if any (Chart.js v3+ uses Chart.instances object)
                    Object.values(Chart.instances).forEach((chart) => {
                        if (chart.options.plugins && chart.options.plugins.tooltip) {
                            chart.options.plugins.tooltip.titleFont.size = tooltipFontSize;
                            chart.options.plugins.tooltip.bodyFont.size = tooltipFontSize;
                        }
                        if (chart.options.scales) {
                            if (chart.options.scales.x && chart.options.scales.x.ticks) chart.options.scales.x.ticks.font.size = chartFontSize;
                            if (chart.options.scales.y && chart.options.scales.y.ticks) chart.options.scales.y.ticks.font.size = chartFontSize;
                        }
                        chart.update('none');
                    });
                }, 250);
            });
            
            // Handle orientation change
            window.addEventListener('orientationchange', function() {
                setTimeout(function() {
                    Object.values(Chart.instances).forEach((chart) => {
                        chart.resize();
                    });
                }, 300);
            });
        });
    })();

    // Particles Animation (wrapped in DOMContentLoaded to ensure canvas is found)
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('dashboard-particles');
        if(canvas) {
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            
            function resize() {
                width = canvas.width = canvas.parentElement.offsetWidth;
                height = canvas.height = canvas.parentElement.offsetHeight;
            }
            
            window.addEventListener('resize', resize);
            resize();
            
            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.size = Math.random() * 3 + 1; // slightly larger
                    this.speedX = Math.random() * 0.6 - 0.3; // slightly faster
                    this.speedY = Math.random() * -0.8 - 0.3;
                    this.opacity = Math.random() * 0.5 + 0.2; // more visible
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if(this.y < 0) {
                        this.y = height;
                        this.x = Math.random() * width;
                    }
                    if(this.x < 0) this.x = width;
                    if(this.x > width) this.x = 0;
                }
                draw() {
                    ctx.fillStyle = `rgba(99, 102, 241, ${this.opacity})`; // indigo color matching theme
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
            
            function init() {
                particles = [];
                // More particles for a better effect
                let count = window.innerWidth < 768 ? 40 : 80;
                for(let i = 0; i < count; i++) {
                    particles.push(new Particle());
                }
            }
            
            function animate() {
                ctx.clearRect(0, 0, width, height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                requestAnimationFrame(animate);
            }
            
            init();
            animate();
        }
    });

    // Modal logic for customizing cards
    function closeCustomizeModal() {
        document.getElementById('customizeCardsModal').classList.add('hidden');
    }
</script>

<!-- Customize Cards Modal -->
@unless(auth()->user()->hasRole('admin'))
<div id="customizeCardsModal" class="hidden fixed inset-0 z-[200] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeCustomizeModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div id="customizeModalContent" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle w-full max-w-[95%] sm:max-w-lg md:max-w-xl relative">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-50 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Customize Dashboard Cards</h3>
                        <p class="text-sm text-gray-500 mt-1">Select the shortcuts you want to appear on your dashboard.</p>
                    </div>
                </div>
            </div>
            
            <form id="customizePreferencesForm" action="{{ route('dashboard.preferences') }}" method="POST">
                @csrf
                <div class="bg-slate-50/50 px-4 py-5 sm:p-6 max-h-[65vh] overflow-y-auto">
                    <div class="space-y-3">
                        @php 
                            $preferences = auth()->user()->dashboard_preferences;
                            $defaultCardsCount = 0;
                        @endphp
                        @foreach($sidebarItems as $item)
                            @if(!$item['permission'] || auth()->user()->can($item['permission']))
                                @php
                                    // Determine if this card is checked
                                    if (is_array($preferences)) {
                                        $isChecked = in_array($item['name'], $preferences);
                                    } else {
                                        $isChecked = ($defaultCardsCount < 6);
                                        $defaultCardsCount++;
                                    }
                                @endphp
                                <label class="flex items-center p-3 sm:p-4 border border-gray-200 rounded-xl bg-white cursor-pointer hover:bg-slate-50 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                                    <input type="checkbox" name="dashboard_cards[]" value="{{ $item['name'] }}" class="peer w-4 h-4 sm:w-5 sm:h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 z-10 transition-transform hover:scale-110 cursor-pointer" {{ $isChecked ? 'checked' : '' }}>
                                    <div class="ml-3 sm:ml-4 flex items-center gap-3 sm:gap-4 z-10 w-full">
                                        <div class="p-2 sm:p-2.5 rounded-lg sm:rounded-xl bg-gradient-to-br {{ $item['bg'] }} shrink-0 shadow-sm group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $item['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon'] !!}</svg>
                                        </div>
                                        <span class="text-sm sm:text-base font-bold text-gray-700 group-hover:text-gray-900 transition-colors">{{ $item['name'] }}</span>
                                    </div>
                                    <!-- Checked state overlay -->
                                    <div class="absolute inset-0 border-2 border-transparent peer-checked:border-indigo-500 peer-checked:bg-indigo-50/40 rounded-xl transition-all duration-300 pointer-events-none"></div>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="bg-white px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 z-10 relative">
                    <button type="submit" id="savePreferencesBtn" class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-[0_4px_14px_0_rgba(99,102,241,0.39)] px-4 py-2 sm:py-2.5 text-base font-bold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 hover:shadow-[0_6px_20px_rgba(99,102,241,0.23)] hover:-translate-y-0.5 relative overflow-hidden bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 bg-[length:200%_auto] animate-gradient-shift">
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4 animate-[spin_4s_linear_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Save Preferences
                        </span>
                    </button>
                    <button type="button" onclick="closeCustomizeModal()" class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-200 shadow-sm px-4 py-2 sm:py-2.5 bg-white text-base font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 hover:border-gray-300 hover:shadow-md">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endunless

<script>
    // Customize Modal Animation Logic
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('customizePreferencesForm');
        if(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Pause submission
                
                const btn = document.getElementById('savePreferencesBtn');
                const originalWidth = btn.offsetWidth;
                
                // Change button state
                btn.style.width = originalWidth + 'px'; // maintain width
                btn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                `;
                btn.classList.add('opacity-90', 'cursor-not-allowed', 'scale-95');

                // Create bubble animation inside modal
                const modalContent = document.getElementById('customizeModalContent');
                const bubble = document.createElement('div');
                bubble.className = 'absolute bg-indigo-500 rounded-full z-50 pointer-events-none';
                
                // Position at the button's center
                const btnRect = btn.getBoundingClientRect();
                const modalRect = modalContent.getBoundingClientRect();
                const centerX = btnRect.left - modalRect.left + (btnRect.width / 2);
                const centerY = btnRect.top - modalRect.top + (btnRect.height / 2);
                
                bubble.style.width = '20px';
                bubble.style.height = '20px';
                bubble.style.left = centerX + 'px';
                bubble.style.top = centerY + 'px';
                bubble.style.transform = 'translate(-50%, -50%)';
                bubble.style.opacity = '0.8';
                bubble.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                
                modalContent.appendChild(bubble);
                
                // Trigger animation
                setTimeout(() => {
                    bubble.style.width = '1200px';
                    bubble.style.height = '1200px';
                    bubble.style.opacity = '0';
                }, 10);
                
                // Submit form after animation finishes
                setTimeout(() => {
                    form.submit();
                }, 600);
            });
        }
    });
</script>

<!-- Additional responsive CSS for very small screens -->
<style>
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .animate-gradient-shift {
        animation: gradient-shift 3s ease infinite;
    }

    /* Mobile-first responsive design */
    * {
        -webkit-tap-highlight-color: transparent;
        box-sizing: border-box;
    }
    
    html, body {
        overflow-x: hidden;
        width: 100%;
        position: relative;
        -webkit-text-size-adjust: 100%;
        -moz-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        text-size-adjust: 100%;
    }
    
    /* Extra small screens (less than 375px) */
    @media (max-width: 374px) {
        .flex-1 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
        }
        
        .p-3 {
            padding: 0.75rem !important;
        }
        
        h2 {
            font-size: 1.125rem !important;
        }
        
        h3 {
            font-size: 0.875rem !important;
        }
    }
    
    /* Small screens (375px - 639px) */
    @media (min-width: 375px) and (max-width: 639px) {
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.75rem !important;
        }
        
        .p-3 {
            padding: 0.875rem !important;
        }
    }
    
    /* Mobile optimizations */
    @media (max-width: 639px) {
        /* Ensure touch targets are at least 44px */
        button, 
        [role="button"],
        input[type="button"],
        input[type="submit"],
        input[type="reset"] {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Improve text readability */
        p, span, div {
            line-height: 1.5;
        }
        
        /* Reduce padding on very small screens */
        .space-y-3 > * + * {
            margin-top: 0.5rem !important;
        }
        
        /* Optimize chart containers */
        .h-40 {
            height: 10rem !important;
        }
        
        /* Adjust card spacing */
        .gap-3 {
            gap: 0.5rem !important;
        }
        
        /* Improve badge visibility */
        .px-1\\.5 {
            padding-left: 0.375rem !important;
            padding-right: 0.375rem !important;
        }
        
        .py-0\\.5 {
            padding-top: 0.125rem !important;
            padding-bottom: 0.125rem !important;
        }
    }
    
    /* Tablet optimizations (640px - 767px) */
    @media (min-width: 640px) and (max-width: 767px) {
        .sm\:p-4 {
            padding: 1rem !important;
        }
        
        .sm\:text-base {
            font-size: 1rem !important;
        }
        
        .sm\:h-48 {
            height: 12rem !important;
        }
        
        .grid-cols-2 {
            gap: 1rem !important;
        }
    }
    
    /* Medium screens (768px - 1023px) */
    @media (min-width: 768px) and (max-width: 1023px) {
        .md\:p-5 {
            padding: 1.25rem !important;
        }
        
        .md\:text-xl {
            font-size: 1.25rem !important;
        }
        
        .md\:h-56 {
            height: 14rem !important;
        }
        
        .md\:gap-5 {
            gap: 1.25rem !important;
        }
    }
    
    /* Large screens (1024px and above) */
    @media (min-width: 1024px) {
        .lg\:p-6 {
            padding: 1.5rem !important;
        }
        
        .lg\:text-2xl {
            font-size: 1.5rem !important;
        }
        
        .lg\:h-64 {
            height: 16rem !important;
        }
        
        .lg\:gap-6 {
            gap: 1.5rem !important;
        }
    }
    
    /* Prevent iOS zoom on input focus */
    @media screen and (max-width: 767px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }
    
    /* Smooth transitions */
    .transition-shadow {
        transition: box-shadow 0.2s ease-in-out;
    }
    
    /* Fade-in animation */
    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out;
    }
    
    /* Improve readability on small screens */
    @media (max-width: 639px) {
        .text-gray-500 {
            font-size: 0.6875rem !important; /* 11px */
        }
        
        .text-xs {
            font-size: 0.6875rem !important; /* 11px */
        }
        
        /* Adjust icon sizes for mobile */
        .w-4 {
            width: 1rem !important;
        }
        
        .h-4 {
            height: 1rem !important;
        }
        
        /* Adjust spacing between elements */
        .space-y-3 > * + * {
            margin-top: 0.75rem !important;
        }
        
        /* Improve card layouts */
        .flex-1 {
            min-width: 0; /* Prevent flex item overflow */
        }
        
        /* Truncate long text */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
    
    /* Fix for very small height screens */
    @media (max-height: 600px) {
        .h-40 {
            height: 8rem !important;
        }
        
        .sm\:h-48 {
            height: 10rem !important;
        }
        
        .md\:h-56 {
            height: 12rem !important;
        }
        
        .lg\:h-64 {
            height: 14rem !important;
        }
    }
    
    /* Ensure proper width constraints */
    .max-w-7xl {
        max-width: 100% !important;
    }
    
    @media (min-width: 640px) {
        .max-w-7xl {
            max-width: 640px !important;
        }
    }
    
    @media (min-width: 768px) {
        .max-w-7xl {
            max-width: 768px !important;
        }
    }
    
    @media (min-width: 1024px) {
        .max-w-7xl {
            max-width: 1024px !important;
        }
    }
    
    @media (min-width: 1280px) {
        .max-w-7xl {
            max-width: 1280px !important;
        }
    }
    
    @media (min-width: 1536px) {
        .max-w-7xl {
            max-width: 1536px !important;
        }
    }
</style>
@endsection