<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Notification Header</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body class="bg-gray-100">

<header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-4 sticky top-0 z-50">
    <div class="flex justify-between items-center">

        <!-- Dynamic Title & Mobile Logo -->
        <div class="flex items-center">
            <!-- Mobile Logo -->
            <div class="block sm:hidden flex-shrink-0">
                @if(auth()->check() && auth()->user()->company && auth()->user()->company->logo)
                    <img src="{{ asset('storage/' . auth()->user()->company->logo) }}" 
                         alt="{{ auth()->user()->company->name }}" 
                         class="max-h-8 w-auto object-contain rounded">
                @else
                    <img src="{{ asset('images/social-cults-logo.png') }}" 
                         alt="Company Logo" 
                         class="max-h-8 w-auto object-contain">
                @endif
            </div>

            <!-- Desktop Title -->
            <h1 class="hidden sm:block text-lg sm:text-xl font-bold text-gray-900">
                {{ $title ?? 'Dashboard' }}
            </h1>
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-3 relative">

            <!-- Notification Button -->
            <button id="notificationBtn"
                class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                <span
                    class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 text-white text-xs rounded-full flex items-center justify-center" id="notify-count">
                     {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </button>

            <!-- Notification Dropdown -->
            <div id="notificationDropdown"
                class="hidden absolute top-12 right-0 
                       w-[280px] sm:w-[320px] 
                       bg-white border border-gray-100 
                       rounded-xl shadow-2xl overflow-hidden z-50 transition-all duration-300">

                <div class="px-4 py-3 border-b bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-gray-900">
                        Notifications
                    </h3>
                    <span id="unreadCountBadge" class="{{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'hidden' }} px-1.5 py-0.5 bg-indigo-100 text-indigo-600 text-[10px] font-bold rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }} New
                    </span>
                </div>

                <div id="notificationList" class="max-h-[320px] overflow-y-auto custom-scrollbar">
                    @forelse(auth()->user()->notifications()->latest()->take(10)->get() as $notification)
                        <a href="javascript:void(0)"
                           onclick="handleNotificationClick('{{ $notification->id }}', '{{ $notification->data['url'] ?? '#' }}')"
                           class="block px-4 py-3 border-b border-gray-50 transition-colors group {{ $notification->read_at ? 'bg-gray-50/50 grayscale-[0.8] opacity-75' : 'hover:bg-indigo-50/50 bg-white' }}">
                            <div class="flex gap-3">
                                @if(!$notification->read_at)
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-{{ $notification->data['icon'] ?? 'bell' }} text-xs"></i>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-0.5">
                                        <p class="text-xs font-bold {{ $notification->read_at ? 'text-gray-500' : 'text-gray-900' }} truncate">
                                            {{ $notification->data['title'] }}
                                        </p>
                                        <span class="text-[9px] font-medium text-gray-400 whitespace-nowrap ml-2 uppercase tracking-wider">
                                            {{ $notification->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] {{ $notification->read_at ? 'text-gray-400' : 'text-gray-600' }} leading-tight line-clamp-2">
                                        {{ $notification->data['message'] }}
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

                <div id="markAllContainer" class="px-4 py-2 text-center bg-gray-50/50 border-t {{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'hidden' }}">
                    <button onclick="markNotificationsRead()" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition-colors">
                        Mark all as read
                    </button>
                </div>
            </div>

            <!-- Search Button -->
            {{-- <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 0 0114 0z" />
                </svg>
            </button> --}}

        </div>
    </div>
</header>

<!-- JS -->
<script>
    const btn = document.getElementById('notificationBtn');
    const dropdown = document.getElementById('notificationDropdown');
    const countEl = document.getElementById('notify-count');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const userId = {{ auth()->id() }};
    const storageKey = 'notifyLastSeenCount_' + userId;
    const currentCount = parseInt((countEl?.textContent || '0').trim()) || 0;
    let autoHideTimer = null;
    let lastFetchedCount = currentCount;

    // Notification Sound
    const notificationSound = new Audio("{{ asset('sounds/notification.mp3') }}");

    function fetchNotifications() {
        if (!csrfToken) return;
        fetch('/notifications/fetch')
            .then(response => response.json())
            .then(data => {
                const newUnreadCount = data.unread_count;
                
                // Update UI count badge
                const unreadBadge = document.getElementById('unreadCountBadge');
                if (unreadBadge) {
                    if (newUnreadCount > 0) {
                        unreadBadge.textContent = newUnreadCount + ' New';
                        unreadBadge.classList.remove('hidden');
                        document.getElementById('markAllContainer')?.classList.remove('hidden');
                    } else {
                        unreadBadge.classList.add('hidden');
                        document.getElementById('markAllContainer')?.classList.add('hidden');
                    }
                }

                if (newUnreadCount > lastFetchedCount) {
                    notificationSound.play().catch(e => console.log('Audio play failed:', e));
                }
                
                // Refresh the list
                const listContainer = document.getElementById('notificationList');
                if (listContainer && data.notifications.length > 0) {
                    let html = '';
                    data.notifications.forEach(n => {
                        const isRead = n.read_at !== null;
                        html += `
                            <a href="javascript:void(0)" 
                               onclick="handleNotificationClick('${n.id}', '${n.url}')"
                               class="block px-4 py-3 border-b border-gray-50 transition-colors group ${isRead ? 'bg-gray-50/50 grayscale-[0.8] opacity-75' : 'hover:bg-indigo-50/50 bg-white'}">
                                <div class="flex gap-3">
                                    ${!isRead ? `
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-${n.icon} text-xs"></i>
                                    </div>
                                    ` : ''}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-0.5">
                                            <p class="text-xs font-bold ${isRead ? 'text-gray-500' : 'text-gray-900'} truncate">${n.title}</p>
                                            <span class="text-[9px] font-medium text-gray-400 whitespace-nowrap ml-2 uppercase tracking-wider">${n.time}</span>
                                        </div>
                                        <p class="text-[11px] ${isRead ? 'text-gray-400' : 'text-gray-600'} leading-tight line-clamp-2">${n.message}</p>
                                    </div>
                                </div>
                            </a>
                        `;
                    });
                    listContainer.innerHTML = html;
                } else if (data.notifications.length === 0) {
                    listContainer.innerHTML = `
                        <div class="px-5 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="fas fa-bell-slash text-2xl"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-500">No notifications</p>
                        </div>
                    `;
                }
                lastFetchedCount = newUnreadCount;
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Poll for new notifications every 30 seconds
    setInterval(fetchNotifications, 30000);

    function handleNotificationClick(id, url) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).finally(() => {
            window.location.href = url;
        });
    }

    function markNotificationsRead() {
        if (!csrfToken) return;
        fetch('/notifications/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Immediate UI feedback
                const listItems = document.querySelectorAll('#notificationList > a');
                listItems.forEach(item => {
                    item.classList.add('bg-gray-50/50', 'grayscale-[0.8]', 'opacity-75');
                    item.classList.remove('hover:bg-indigo-50/50', 'bg-white');
                    // Hide icons
                    const iconContainer = item.querySelector('.w-10.h-10');
                    if (iconContainer) iconContainer.remove();
                    // Gray out text
                    const title = item.querySelector('.text-sm.font-bold');
                    if (title) {
                        title.classList.add('text-gray-500');
                        title.classList.remove('text-gray-900');
                    }
                    const message = item.querySelector('.text-xs');
                    if (message) {
                        message.classList.add('text-gray-400');
                        message.classList.remove('text-gray-600');
                    }
                });
                
                // Hide badge and button
                document.getElementById('unreadCountBadge')?.classList.add('hidden');
                document.getElementById('markAllContainer')?.classList.add('hidden');
                lastFetchedCount = 0;
            }
        })
        .catch(error => console.error('Error marking notifications as read:', error));
    }
    document.addEventListener('DOMContentLoaded', () => {
        const lastCount = localStorage.getItem(storageKey);
        const shouldAutoSlide = currentCount > 0 && lastCount !== String(currentCount);
        if (shouldAutoSlide) {
            // Play sound
            notificationSound.play().catch(e => console.log('Audio play failed:', e));

            dropdown.classList.remove('hidden');
            dropdown.style.animation = 'slideInRight 0.3s ease-out';
            if (autoHideTimer) clearTimeout(autoHideTimer);
            autoHideTimer = setTimeout(() => {
                dropdown.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => dropdown.classList.add('hidden'), 300);
            }, 2000);
            localStorage.setItem(storageKey, String(currentCount));
        }
        if (currentCount === 0 && countEl) countEl.classList.add('hidden');
    });

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (!dropdown.classList.contains('hidden')) {
            dropdown.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => dropdown.classList.add('hidden'), 300);
            return;
        }
        dropdown.classList.remove('hidden');
        dropdown.style.animation = 'slideInRight 0.2s ease-out';
        if (autoHideTimer) { clearTimeout(autoHideTimer); autoHideTimer = null; }
    });


    dropdown.addEventListener('click', (e) => {
        const a = e.target.closest('a[href]');
        if (a) {
            e.preventDefault();
            e.stopPropagation();
            fetch('/notifications/read', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            }).finally(() => {
                window.location.href = a.href;
            });
        } else {
            e.stopPropagation();
        }
    });

    document.addEventListener('click', () => {
        if (!dropdown.classList.contains('hidden')) {
            dropdown.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => dropdown.classList.add('hidden'), 300);
        }
    });
</script>

</body>
</html>
