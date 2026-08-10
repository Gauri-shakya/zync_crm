<h1>Roles Management & Permissions</h1>
<p>The <strong>Roles</strong> module is the security foundation of ZynCRM. It allows administrators to define exactly what different users can see and do within the system. By creating custom roles and assigning specific permissions, you can ensure that team members, clients, and partners have access only to the modules relevant to their responsibilities.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-gray-900 font-bold m-0">Roles Management Dashboard</h3>
        <button class="px-3 py-1 bg-green-600 text-white text-xs rounded-lg font-bold flex items-center gap-1 italic">
            <i data-lucide="plus" class="w-3 h-3"></i> Create New Role
        </button>
    </div>
    <div class="p-6">
        <p>The dashboard provides an overview of all system roles. For each role, you can see:</p>
        <ul class="list-disc ml-6 mt-2 space-y-2 text-sm text-gray-600">
            <li><strong>Name:</strong> The designation of the role (e.g., Admin, Client, Web Developer).</li>
            <li><strong>Permissions:</strong> The total number of system modules the role can access.</li>
            <li><strong>Users:</strong> A count of how many active users are currently assigned to that role.</li>
        </ul>
    </div>
</div>

<h2>Creating and Customizing Roles</h2>
<p>To set up a new access level, click the <strong>"+ Create New Role"</strong> button. This opens the <strong>"Create Role"</strong> form, where you can define granular access controls.</p>

<div class="bg-blue-50 p-8 rounded-xl border border-blue-100 my-10 shadow-sm">
    <h3 class="text-blue-900 mt-0 flex items-center gap-2">
        <i data-lucide="shield-check" class="w-5 h-5"></i>
        Permission Configuration Guide
    </h3>
    
    <div class="space-y-6 mt-6">
        <div>
            <h4 class="font-bold text-gray-900 m-0">Role Name</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Enter a clear, descriptive name for the role, such as <em>"SEO Specialist"</em> or <em>"Project Manager"</em>.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Assign Permissions</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">This section lists every module available in ZynCRM. Simply check the boxes for the features you want this role to access:</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-4">
                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white p-2 rounded border border-blue-100"><i data-lucide="check-square" class="w-3 h-3 text-blue-500"></i> Dashboard</div>
                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white p-2 rounded border border-blue-100"><i data-lucide="check-square" class="w-3 h-3 text-blue-500"></i> My Leads</div>
                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white p-2 rounded border border-blue-100"><i data-lucide="check-square" class="w-3 h-3 text-blue-500"></i> Invoice</div>
                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white p-2 rounded border border-blue-100"><i data-lucide="check-square" class="w-3 h-3 text-blue-500"></i> Project Management</div>
                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white p-2 rounded border border-blue-100"><i data-lucide="check-square" class="w-3 h-3 text-blue-500"></i> Attendance Records</div>
                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white p-2 rounded border border-blue-100"><i data-lucide="check-square" class="w-3 h-3 text-blue-500"></i> Support Tickets</div>
            </div>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-blue-100 flex justify-end gap-4">
        <span class="px-4 py-2 text-sm font-semibold text-gray-500">Cancel</span>
        <span class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md">Save Role</span>
    </div>
</div>

<h2>Module Purpose & Best Practices</h2>
<p>Proper role management is essential for maintaining data privacy and operational focus. Use this module to:</p>
<ul class="list-disc ml-6 space-y-3 text-gray-700">
    <li><strong>Ensure Security:</strong> Prevent sensitive financial data (Invoices/Salary) from being visible to unauthorized staff.</li>
    <li><strong>Simplify the Interface:</strong> By unchecking unused modules, you provide a cleaner, more focused dashboard for your team members.</li>
    <li><strong>Client Portals:</strong> Create a "Client" role with limited access to only their specific Projects, Invoices, and Support Tickets.</li>
</ul>

<div class="p-4 bg-yellow-50 border border-yellow-100 rounded-lg text-sm text-yellow-800 italic mt-10">
    <strong>Pro-Tip:</strong> Use the <strong>"View"</strong> action on the dashboard to review exactly which permissions are assigned to a role before linking it to a new user.
</div>
