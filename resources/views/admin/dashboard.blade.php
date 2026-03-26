@extends('components.layout')

@section('content')

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<div class="flex-1 overflow-auto p-3 sm:p-4 md:p-5 lg:p-6">
    <div class="max-w-7xl mx-auto space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6">
        <!-- Page Header -->
        <div class="px-2 sm:px-3 md:px-0">
            <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">Dashboard Overview</h2>
            <p class="text-xs sm:text-sm md:text-base text-gray-500 mt-1 sm:mt-1.5 md:mt-2 leading-relaxed">Track your marketing performance and client relationships</p>
        </div>

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
</script>

<!-- Additional responsive CSS for very small screens -->
<style>
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