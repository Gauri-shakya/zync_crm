<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZynCRM Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .prose h1 { font-size: 2.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #111827; }
        .prose h2 { font-size: 1.5rem; font-weight: 600; margin-top: 2rem; margin-bottom: 1rem; color: #1f2937; }
        .prose p { margin-bottom: 1rem; line-height: 1.625; color: #4b5563; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; color: #4b5563; }
        .prose li { margin-bottom: 0.5rem; }
        
        /* Global Responsive Fixes */
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 2rem 0;
        }
        .prose table {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-collapse: collapse;
            margin: 2rem 0;
        }
        .prose blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1rem;
            font-style: italic;
            color: #6b7280;
        }
        @media (max-width: 640px) {
            .prose h1 { font-size: 1.875rem; }
            .prose h2 { font-size: 1.25rem; }
            .prose p { font-size: 0.9375rem; }
        }

        .sidebar-link.active {
            background-color: #eff6ff;
            color: #2563eb;
            font-weight: 500;
        }
        .sidebar-link.active i {
            color: #2563eb;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
        /* Hide sidebar scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide sidebar scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex flex-col">
        <!-- Header Component -->
        @include('docs.components.header')

        <div class="flex relative">
            <!-- Mobile Sidebar Overlay -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

            <!-- Sidebar -->
            <aside id="docs-sidebar" class="fixed lg:sticky top-0 lg:top-16 left-0 w-72 bg-white border-r border-gray-200 h-screen lg:h-[calc(100vh-4rem)] overflow-y-auto no-scrollbar z-50 transition-transform -translate-x-full lg:translate-x-0 shrink-0">
                <!-- Mobile Sidebar Header -->
                <div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center gap-2">
                        <img src="/assets/logo.png" alt="ZynCRM Logo" class="w-16 h-8 object-contain">
                        <span class="text-blue-600 text-lg font-bold">Docs</span>
                    </div>
                    <button onclick="toggleSidebar()" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition-all active:scale-90" aria-label="Close Menu">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <nav class="p-6 space-y-1 pb-[90px]">
                    @foreach($sidebar as $item)
                        <a href="/docs/{{ $item['slug'] }}" 
                           class="sidebar-link flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-50 transition {{ $currentModule === $item['slug'] ? 'active' : '' }}">
                            <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 text-gray-400"></i>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 bg-white min-w-0">
                <div class="{{ in_array($currentModule, ['introduction', 'upgrade-plan']) ? 'max-w-7xl' : 'max-w-5xl' }} mx-auto px-4 sm:px-6 py-12 lg:px-12">
                    <!-- Breadcrumbs -->
                    @if($currentModule !== 'introduction')
                        <nav class="flex mb-8 text-sm text-gray-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2">
                                <li><a href="/docs" class="hover:text-gray-900">Docs</a></li>
                                <i data-lucide="chevron-right" class="w-3 h-3 shrink-0"></i>
                                <li class="capitalize text-gray-900 font-medium">{{ str_replace('-', ' ', $currentModule) }}</li>
                            </ol>
                        </nav>
                    @endif

                    <!-- Content -->
                    <div class="{{ $currentModule === 'introduction' ? '' : 'prose' }} max-w-none overflow-x-hidden">
                        @include($viewPath)
                    </div>

                    <!-- Footer Component -->
                    <div class="mt-20">
                        @include('docs.components.footer')
                    </div>
                </div>
            </main>

            <!-- Table of Contents (Right Sidebar) -->
            @if(!in_array($currentModule, ['introduction', 'upgrade-plan']))
                <aside class="w-64 p-8 hidden xl:block border-l border-gray-50 bg-white shrink-0 sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto no-scrollbar">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">On this page</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-blue-600">Overview</a></li>
                        <li><a href="#" class="hover:text-blue-600">Key Features</a></li>
                        <li><a href="#" class="hover:text-blue-600">Setup Guide</a></li>
                        <li><a href="#" class="hover:text-blue-600">FAQ</a></li>
                    </ul>
                </aside>
            @endif
        </div>
    </div>

    <script>
        // Initial icon creation
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('docs-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isHidden = sidebar.classList.contains('-translate-x-full');
            
            if (isHidden) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            // Re-initialize icons inside sidebar if needed
            lucide.createIcons();
        }
    </script>
</body>
</html>
