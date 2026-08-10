<h1>Task Management & Collaboration</h1>
<p>The <strong>Task</strong> module is the operational core of ZynCRM, designed to streamline team productivity and project execution. It provides a comprehensive <strong>Task Management</strong> dashboard where you can assign, track, and complete work items with precision and transparency.</p>

<div class="my-8 grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm border-l-4 border-l-indigo-500">
        <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest">Total Tasks</div>
        <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-2">0</div>
    </div>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm border-l-4 border-l-yellow-500">
        <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest">Pending</div>
        <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-2">0</div>
    </div>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm border-l-4 border-l-blue-500">
        <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest">In Progress</div>
        <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-2">0</div>
    </div>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm border-l-4 border-l-green-500">
        <div class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest">Completed</div>
        <div class="text-2xl sm:text-3xl font-black text-green-600 mt-2">0</div>
    </div>
</div>

<h2>The Task Dashboard</h2>
<p>The dashboard offers a real-time snapshot of your workload. You can filter <strong>Recent Tasks</strong> by status, priority, or assignee. Each task entry displays the <strong>Task Title</strong>, <strong>Assigned To</strong>, <strong>Priority</strong>, <strong>Status</strong>, <strong>Due Date</strong>, and <strong>Assigned By</strong>, ensuring full accountability across the team.</p>

<h2>Creating and Assigning a New Task</h2>
<p>To initiate a new workflow, click the <strong>"+ Add New Task"</strong> button. This opens a multi-section form designed to capture all necessary details for successful task completion.</p>

<div class="bg-indigo-50 p-4 sm:p-8 rounded-xl border border-indigo-100 my-10 shadow-sm">
    <h3 class="text-indigo-900 mt-0 flex items-center gap-2">
        <i data-lucide="clipboard-check" class="w-5 h-5"></i>
        Task Configuration Guide
    </h3>
    
    <div class="space-y-8 mt-6">
        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
            <div class="w-full sm:w-1/3">
                <h4 class="font-bold text-gray-900 m-0">1. Basic Information</h4>
                <p class="mt-1 text-xs text-gray-500 italic">Mandatory Fields</p>
            </div>
            <div class="w-full sm:w-2/3">
                <p class="text-sm text-gray-700 leading-relaxed">Enter a descriptive <strong>Task Title</strong> and select a <strong>Task Category</strong>. Provide a <strong>Task Description</strong> to detail the specific requirements and expected outcomes.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 border-t border-indigo-100 pt-6">
            <div class="w-full sm:w-1/3">
                <h4 class="font-bold text-gray-900 m-0">2. Assignment Type</h4>
                <p class="mt-1 text-xs text-gray-500 italic">Individual or Team</p>
            </div>
            <div class="w-full sm:w-2/3">
                <p class="text-sm text-gray-700 leading-relaxed">Choose whether to assign the task to <strong>Individual Users</strong> or the <strong>Whole Team</strong>. Use the search bar to find team members by name or role (e.g., Admin, Web Developer) and select them from the list.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 border-t border-indigo-100 pt-6">
            <div class="w-full sm:w-1/3">
                <h4 class="font-bold text-gray-900 m-0">3. Attachments</h4>
                <p class="mt-1 text-xs text-gray-500 italic">Optional Resources</p>
            </div>
            <div class="w-full sm:w-2/3">
                <p class="text-sm text-gray-700 leading-relaxed">Drag and drop or browse to upload supporting documents (PDF, JPG, PNG, DOC). This is useful for providing design mocks, requirement docs, or error logs.</p>
            </div>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-indigo-100 flex flex-col sm:flex-row justify-end gap-4">
        <span class="px-4 py-2 text-sm font-semibold text-gray-500 text-center">Cancel</span>
        <span class="px-6 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md text-center">Create Task</span>
    </div>
</div>

<h2>Operational Purpose</h2>
<p>The Task module is essential for maintaining a high-velocity work environment. It ensures that:</p>
<ul class="list-disc ml-6 space-y-2 text-gray-700">
    <li><strong>No Work is Lost:</strong> Every item is logged with a due date and assignee.</li>
    <li><strong>Prioritization is Clear:</strong> Teams can focus on high-priority items first.</li>
    <li><strong>Collaboration is Easy:</strong> Attachments and descriptions provide all the context needed to start working immediately.</li>
</ul>
