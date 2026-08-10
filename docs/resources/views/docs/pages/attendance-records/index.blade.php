<h1>Monthly Attendance Summary & Records</h1>
<p>The <strong>Attendance Records</strong> module is a comprehensive administrative tool within ZynCRM designed to provide a centralized view of employee presence and organizational growth metrics. It offers a detailed <strong>Monthly Attendance Summary</strong>, allowing HR managers and administrators to monitor productivity trends and individual performance at a glance.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <h3 class="text-gray-900 font-bold m-0 text-lg sm:text-base">Summary Metrics</h3>
        <div class="flex flex-wrap gap-2">
            <button class="flex-1 sm:flex-none px-4 py-2 bg-purple-600 text-white text-xs rounded-lg font-bold flex items-center justify-center gap-2 italic transition hover:bg-purple-700 shadow-sm">
                <i data-lucide="download" class="w-3.5 h-3.5"></i> Import Excel
            </button>
            <button class="flex-1 sm:flex-none px-4 py-2 bg-white border border-gray-200 text-gray-600 text-xs rounded-lg font-bold flex items-center justify-center gap-2 italic transition hover:bg-gray-50 shadow-sm">
                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Refresh Data
            </button>
        </div>
    </div>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
            <!-- Total Users -->
            <div class="p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm group hover:border-blue-200 transition-all flex flex-col items-center text-center min-w-0">
                <div class="w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm shrink-0">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 whitespace-nowrap">Total Users</div>
                <div class="text-3xl sm:text-4xl font-black text-gray-900 leading-none">0</div>
                <div class="text-[11px] text-green-500 font-bold mt-5 flex items-center gap-1 whitespace-nowrap">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> 12.5% vs last month
                </div>
            </div>

            <!-- Present Today -->
            <div class="p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm group hover:border-blue-200 transition-all flex flex-col items-center text-center min-w-0">
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm shrink-0">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 whitespace-nowrap">Present Today</div>
                <div class="text-3xl sm:text-4xl font-black text-gray-900 leading-none">0</div>
                <div class="text-[11px] text-green-500 font-bold mt-5 flex items-center gap-1 whitespace-nowrap">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> 8.2% vs yesterday
                </div>
            </div>

            <!-- Total Clients -->
            <div class="p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm group hover:border-blue-200 transition-all flex flex-col items-center text-center min-w-0">
                <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-full flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm shrink-0">
                    <i data-lucide="briefcase" class="w-6 h-6"></i>
                </div>
                <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 whitespace-nowrap">Total Clients</div>
                <div class="text-3xl sm:text-4xl font-black text-gray-900 leading-none">1</div>
                <div class="text-[11px] text-green-500 font-bold mt-5 flex items-center gap-1 whitespace-nowrap">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> 15.3% vs last month
                </div>
            </div>

            <!-- Total Contacts -->
            <div class="p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm group hover:border-blue-200 transition-all flex flex-col items-center text-center min-w-0">
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm shrink-0">
                    <i data-lucide="phone" class="w-6 h-6"></i>
                </div>
                <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 whitespace-nowrap">Total Contacts</div>
                <div class="text-3xl sm:text-4xl font-black text-gray-900 leading-none">0</div>
                <div class="text-[11px] text-red-500 font-bold mt-5 flex items-center gap-1 whitespace-nowrap">
                    <i data-lucide="trending-down" class="w-3 h-3"></i> 3.1% vs last month
                </div>
            </div>
        </div>
    </div>
</div>

<h2>Advanced Navigation & Filtering</h2>
<p>Finding specific attendance data is made easy with ZynCRM's built-in filtering system. Administrators can drill down into specific timeframes or individual employee records:</p>

<div class="bg-blue-50 p-4 sm:p-8 rounded-xl border border-blue-100 my-10 shadow-sm">
    <h3 class="text-blue-900 mt-0 flex items-center gap-2">
        <i data-lucide="search" class="w-5 h-5"></i>
        Search & Filter Tools
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 lg:gap-x-12 gap-y-8 mt-6">
        <div>
            <h4 class="font-bold text-gray-900 m-0">Select Month</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Use the <strong>Month Picker</strong> to view attendance summaries for any historical or current month (e.g., March 2026).</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Filter by Employee</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Select a specific staff member from the dropdown to see their individual attendance metrics for the chosen period.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Global Search</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">The <strong>Search Bar</strong> above the data table allows you to instantly find an employee by name as you type.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Action Controls</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Use <strong>"Show All"</strong> to reset filters or <strong>"Clear"</strong> to empty your current search parameters.</p>
        </div>
    </div>
</div>

<h2>Attendance Data Table</h2>
<p>The core of the module is the detailed records table, which provides a granular breakdown of employee presence:</p>
<ul class="list-disc ml-6 space-y-3 text-gray-700">
    <li><strong>Employee:</strong> Displays the name and profile of the staff member.</li>
    <li><strong>Total Present:</strong> Cumulative count of days the employee was physically in the office.</li>
    <li><strong>Total Absent:</strong> Count of days the employee was missing without approved leave.</li>
    <li><strong>Total Half Day:</strong> Records where the employee worked partial hours.</li>
    <li><strong>Actions:</strong> Dive deeper into an individual's daily logs or export their specific record.</li>
</ul>

<div class="p-4 bg-yellow-50 border border-yellow-100 rounded-lg text-sm text-yellow-800 italic mt-10">
    <strong>Pro-Tip:</strong> Use the <strong>"Import Excel"</strong> button to bulk-upload attendance data from biometric devices or external systems into ZynCRM.
</div>
