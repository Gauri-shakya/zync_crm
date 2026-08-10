<header class="sticky top-0 z-40 w-full bg-white border-b border-gray-200 shadow-sm shrink-0">
    <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile Menu Toggle -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors" aria-label="Toggle Menu">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <a href="/" class="flex items-center gap-2 shrink-0">
                <!-- Logo Image -->
                <img src="/assets/logo.png" alt="ZynCRM Logo" class="w-16 sm:w-23 h-8 sm:h-[44px] object-contain">
                <!-- Text -->
                <span class="text-blue-600 ml-1 text-lg sm:text-xl font-bold">Docs</span>
            </a>
        </div>

        <div class="flex-1 max-w-2xl flex items-center justify-end gap-3 sm:gap-6">
            <div class="relative flex-1 max-w-md group">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text" id="docs-search" placeholder="Search..." 
                       class="w-full pl-10 pr-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                
                <!-- Search Results Dropdown -->
                <div id="search-results" class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden hidden max-h-96 overflow-y-auto z-50">
                    <div class="p-2 text-xs font-semibold text-gray-400 uppercase tracking-wider bg-gray-50">Search Results</div>
                    <div id="results-list" class="divide-y divide-gray-100">
                        <!-- Results will be injected here -->
                    </div>
                </div>
            </div>
            
            <a href="https://zyncrm.in/" class="hidden sm:block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shrink-0">
                Get Started
            </a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('docs-search');
        const searchResults = document.getElementById('search-results');
        const resultsList = document.getElementById('results-list');
        let debounceTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/docs-search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsList.innerHTML = '';
                        
                        if (data.results.length === 0) {
                            resultsList.innerHTML = '<div class="p-4 text-sm text-gray-500">No results found for "' + query + '"</div>';
                        } else {
                            data.results.forEach(result => {
                                const item = document.createElement('a');
                                item.href = result.url;
                                item.className = 'block p-4 hover:bg-blue-50 transition';
                                item.innerHTML = `
                                    <div class="text-sm font-semibold text-gray-900">${result.title}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-2">${result.excerpt}</div>
                                    <div class="text-[10px] text-blue-600 mt-1 uppercase font-bold tracking-tight">${result.module}</div>
                                `;
                                resultsList.appendChild(item);
                            });
                        }
                        searchResults.classList.remove('hidden');
                    });
            }, 300);
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    });
</script>
