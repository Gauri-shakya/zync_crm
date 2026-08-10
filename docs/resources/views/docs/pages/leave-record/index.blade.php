<h1>Admin Leave Portal & Records</h1>
<p>The <strong>Leave Record</strong> module, also known as the <strong>Admin Leave Portal</strong>, is a powerful management tool for HR administrators and team leads. It provides a centralized view of all leave applications across the organization, allowing for efficient review, tracking, and decision-making.</p>

<div class="my-8 grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 transition-all hover:border-blue-200 group">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-sm">
            <i data-lucide="clock" class="w-6 h-6"></i>
        </div>
        <div class="min-w-0">
            <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Pending</div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-1 leading-none">0</div>
        </div>
    </div>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 transition-all hover:border-blue-200 group">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-sm">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
        </div>
        <div class="min-w-0">
            <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Approved</div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-1 leading-none">0</div>
        </div>
    </div>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 transition-all hover:border-blue-200 group">
        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-sm">
            <i data-lucide="x-circle" class="w-6 h-6"></i>
        </div>
        <div class="min-w-0">
            <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Rejected</div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-1 leading-none">0</div>
        </div>
    </div>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 transition-all hover:border-blue-200 group">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-sm">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div class="min-w-0">
            <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Employees</div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-1 leading-none">0</div>
        </div>
    </div>
</div>

<h2>Managing Leave Applications</h2>
<p>The Admin Portal is designed to give you complete control over the leave approval workflow. You can quickly see which requests require immediate attention and track the overall leave trends within your team.</p>

<div class="bg-gray-50 p-4 sm:p-8 rounded-xl border border-gray-200 my-10 shadow-sm">
    <h3 class="text-gray-900 mt-0 flex items-center gap-2">
        <i data-lucide="search" class="w-5 h-5 text-blue-600"></i>
        Advanced Search & Filtering
    </h3>
    <p class="text-gray-700 mb-6">With hundreds of applications, finding specific records is easy using the built-in tools:</p>
    
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-white rounded-lg border border-gray-100">
            <div class="font-bold text-blue-600 shrink-0">Search:</div>
            <p class="text-sm text-gray-600">Instantly find records by typing an employee's <strong>Name</strong>, <strong>Position</strong>, or <strong>Email address</strong> into the search bar.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-white rounded-lg border border-gray-100">
            <div class="font-bold text-blue-600 shrink-0">Status Filter:</div>
            <p class="text-sm text-gray-600">Narrow down the list to see only 'Pending' requests that need approval, or review 'Approved' and 'Rejected' history.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-white rounded-lg border border-gray-100">
            <div class="font-bold text-blue-600 shrink-0">Type Filter:</div>
            <p class="text-sm text-gray-600">Filter by the category of leave, such as Sick Leave, Casual Leave, or Annual Vacation.</p>
        </div>
    </div>
</div>

<h2>Portal Features</h2>
<ul class="list-disc ml-6 space-y-3 text-gray-700">
    <li><strong>Real-time Updates:</strong> Use the <strong>"↻ Refresh"</strong> button at the top right to ensure you are viewing the most recent submissions without reloading the page.</li>
    <li><strong>Bulk Overview:</strong> The summary cards at the top provide an instant count of pending tasks and total active employees in the system.</li>
    <li><strong>Clear Filters:</strong> If your search criteria are too specific, use the <strong>"Clear Filters"</strong> button to reset the view and see all applications again.</li>
</ul>

<h2>Decision Making</h2>
<p>In the applications table, administrators can view the full details of each request and use the <strong>Actions</strong> column to either Approve or Reject the leave. Once a decision is made, the employee is automatically notified via the system.</p>
