<h1>Todo Management & Personal Productivity</h1>
<p>The <strong>Todo</strong> module is your personal productivity assistant within ZynCRM. It is designed to help you organize your daily work, prioritize important actions, and ensure that no small task falls through the cracks. Unlike the broader Task module, Todo Management focuses on your individual workflow and immediate priorities.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <h3 class="text-gray-900 font-bold m-0">Todo Dashboard Overview</h3>
        <div class="flex flex-wrap gap-4 text-sm">
            <span class="text-gray-500">Total: <strong class="text-gray-900">0</strong></span>
            <span class="text-orange-500">Pending: <strong class="text-orange-900">0</strong></span>
            <span class="text-green-500">Completed: <strong class="text-green-900">0</strong></span>
        </div>
    </div>
    <div class="p-6">
        <p>The dashboard provides a visual hierarchy of your workload, categorized by priority levels. You can filter your view by <strong>Due Date</strong>, <strong>Category</strong>, or <strong>Status</strong>, and sort items to focus on what's most urgent.</p>
    </div>
</div>

<h2>Priority-Based Organization</h2>
<p>ZynCRM automatically groups your todos into three priority tiers, allowing you to manage your energy and time effectively:</p>

<div class="grid grid-cols-1 gap-4 my-8">
    <div class="p-4 bg-red-50 border border-red-100 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-red-500"></div>
            <span class="font-bold text-red-900">High Priority</span>
        </div>
        <span class="text-xs text-red-700 font-medium italic">Critical deadlines & essential actions</span>
    </div>
    <div class="p-4 bg-yellow-50 border border-yellow-100 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
            <span class="font-bold text-yellow-900">Medium Priority</span>
        </div>
        <span class="text-xs text-yellow-700 font-medium italic">Important but not immediate</span>
    </div>
    <div class="p-4 bg-green-50 border border-green-100 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-green-500"></div>
            <span class="font-bold text-green-900">Low Priority</span>
        </div>
        <span class="text-xs text-green-700 font-medium italic">Long-term goals & minor tasks</span>
    </div>
</div>

<h2>Adding a New Todo</h2>
<p>To capture a new item, click the <strong>"+ New Todo"</strong> button at the top or the <strong>"+ Add New"</strong> link within a specific priority section. This opens the <strong>"Add New Task"</strong> (Todo) form:</p>

<div class="bg-blue-50 p-4 sm:p-8 rounded-xl border border-blue-100 my-10 shadow-sm">
    <h3 class="text-blue-900 mt-0 flex items-center gap-2">
        <i data-lucide="plus-circle" class="w-5 h-5"></i>
        Todo Configuration Form
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        <div>
            <h4 class="font-bold text-gray-900 m-0">Task Title & Description</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Provide a clear title (e.g., <em>"Call Client for Approval"</em>) and an optional detailed description for extra context.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Priority & Due Date</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Select the priority tier and set a deadline. This ensures the item appears in the correct dashboard section and alerts you when due.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Category</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Assign the todo to a specific category like <strong>Projects</strong>, <strong>Internal</strong>, or <strong>Personal</strong> for better filtering.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Status</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Set the initial status (usually <strong>Pending</strong>). Once finished, you can mark it as <strong>Completed</strong> directly from the dashboard.</p>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-blue-100 flex justify-end gap-4">
        <span class="px-4 py-2 text-sm font-semibold text-gray-500">Cancel</span>
        <span class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md">Save Task</span>
    </div>
</div>

<h2>Why Use the Todo Module?</h2>
<ul class="list-disc ml-6 space-y-2 text-gray-700">
    <li><strong>Clear Focus:</strong> By categorizing by priority, you always know what to work on next.</li>
    <li><strong>Accountability:</strong> Tracking your pending vs. completed items helps you maintain a consistent work rhythm.</li>
    <li><strong>Flexibility:</strong> Use the <strong>"Load More Tasks"</strong> feature to review your long-term history or <strong>"Clear Filters"</strong> to see your entire workload at once.</li>
</ul>
