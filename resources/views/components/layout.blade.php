<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Cults - Dashboard</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}?v={{ time() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            500: '#3b82f6',
                            600: '#2563eb',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-50">











    @if(session('showWelcome'))
        <div id="welcomeOverlay" style="
            position: fixed; 
            inset: 0; 
            z-index: 999999; 
            background: #ffffff; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: center;
         ">

            <div style="position: relative; overflow: hidden; padding: 20px;">
                <h1 id="welcomeText" style="
                    font-family: -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
                    font-size: clamp(2.5rem, 7vw, 5rem);
                    font-weight: 800;
                    color: #111827;
                    margin: 0;
                    display: flex;
                    gap: 15px;
                    line-height: 1;
                ">
                    <span style="opacity: 0; animation: slideUp 1.2s cubic-bezier(0.2, 0, 0.2, 1) forwards;">Welcome,</span>
                    <span style="
                    background: linear-gradient(135deg, #2563eb, #7c3aed);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    opacity: 0;
                    animation: slideUp 1.2s cubic-bezier(0.2, 0, 0.2, 1) 0.2s forwards;
                ">
                        {{ auth()->user()->name }}
                    </span>
                </h1>
            </div>

            <div style="
            margin-top: 30px;
            width: 40px;
            height: 2px;
            background: #e2e8f0;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        ">
                <div style="
                position: absolute;
                height: 100%;
                width: 100%;
                background: #2563eb;
                left: -100%;
                animation: loadingSlide 2.5s cubic-bezier(0.45, 0, 0.55, 1) forwards;
            "></div>
            </div>

            <audio id="welcomeSound" preload="auto">
                <source src="{{ asset('sounds/intro.mp3') }}" type="audio/mpeg">
            </audio>
        </div>
    @endif

    <style>
        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(60px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes loadingSlide {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .premium-exit {
            opacity: 0 !important;
            transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        /* Sidebar Collapse Styles */
        .sidebar-collapsed {
            width: 5.5rem !important; /* slightly wider (88px) to fit icons comfortably */
        }
        .sidebar-collapsed-main {
            margin-left: 5.5rem !important;
        }
        #desktop-sidebar.sidebar-collapsed span.font-medium,
        #desktop-sidebar.sidebar-collapsed .text-xs.font-semibold,
        #desktop-sidebar.sidebar-collapsed .sidebar-logo,
        #desktop-sidebar.sidebar-collapsed .sidebar-footer,
        #desktop-sidebar.sidebar-collapsed .trial-block,
        #desktop-sidebar.sidebar-collapsed .status-badge {
            display: none !important;
        }
        #desktop-sidebar.sidebar-collapsed a {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        #desktop-sidebar.sidebar-collapsed a svg {
            margin-left: auto !important;
            margin-right: auto !important;
        }
        #sidebar-toggle-btn {
            transition: all 0.3s ease;
        }
        #sidebar-toggle-btn svg {
            transition: transform 0.3s ease;
        }
        #desktop-sidebar.sidebar-collapsed #sidebar-toggle-btn {
            top: 50% !important;
            right: 50% !important;
            transform: translate(50%, -50%) !important;
        }
        #desktop-sidebar.sidebar-collapsed #sidebar-toggle-btn svg {
            transform: rotate(180deg);
        }
        
        /* Hide scrollbar for sidebar */
        .sidebar-scroll-container::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll-container::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll-container::-webkit-scrollbar-thumb {
            background-color: transparent;
            border-radius: 20px;
        }
        .sidebar-scroll-container:hover::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
        }
        #desktop-sidebar.sidebar-collapsed .sidebar-scroll-container::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('welcomeOverlay');
            const sound = document.getElementById('welcomeSound');

            if (!overlay) return;

            document.body.style.overflow = 'hidden';
            
            // Play sound
            if (sound) {
                setTimeout(() => { sound.play().catch(() => { }); }, 400);
            }

            // Keep it on screen for 3 seconds, then fade out
            setTimeout(() => {
                overlay.classList.add('premium-exit');
                setTimeout(() => {
                    overlay.remove();
                    document.body.style.overflow = '';
                }, 1200);
            }, 5000);
        });
    </script>
    
    <div class="min-h-screen flex">


        <!-- Desktop Sidebar -->
        @include('components.sidebar')
        <!-- Desktop Sidebar -->


        <!-- Main Content -->
        <div id="main-content" class="flex-1 min-w-0 flex flex-col lg:ml-64 transition-all duration-300">

            <!-- Header -->
            @include('components.header')
            <!-- Header -->

            <!-- Dashboard Content -->

            <div class="pb-24">
                <main>
                    @yield('content')
                </main>

            </div>


        </div>
    </div>



    <script>
        // Animation for cards on page load
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.fade-in');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('visible');
                }, index * 100);
            });

            // Sidebar Toggle Logic
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebar = document.getElementById('desktop-sidebar');
            const mainContent = document.getElementById('main-content');
            
            if (toggleBtn && sidebar && mainContent) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('sidebar-collapsed');
                    mainContent.classList.toggle('sidebar-collapsed-main');
                });
            }
        });
    </script>

</body>

</html>