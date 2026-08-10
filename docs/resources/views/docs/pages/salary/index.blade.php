<h1>Salary Management & Payroll Automation</h1>
<p>The <strong>Salary</strong> module is a comprehensive payroll solution within ZynCRM, designed to automate the generation of employee salary slips with precision. By integrating directly with attendance and leave data, it ensures that financial calculations are accurate, transparent, and compliant with your organization's policies.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-gray-900 font-bold m-0">Salary Management Dashboard</h3>
        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
            <i data-lucide="file-text" class="w-4 h-4"></i> Salary Records
        </a>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-blue-50 rounded-lg text-center">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Employees</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">1</div>
            </div>
            <div class="p-4 bg-green-50 rounded-lg text-center">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Avg. Salary</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">₹100,000</div>
            </div>
            <div class="p-4 bg-purple-50 rounded-lg text-center">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">This Month</div>
                <div class="text-xl font-bold text-gray-900 mt-1">March 2026</div>
            </div>
        </div>
    </div>
</div>

<h2>Generating Employee Salaries</h2>
<p>The core functionality of this module allows administrators to generate individual or bulk salary slips in just a few clicks. The process is highly automated to minimize manual errors.</p>

<div class="bg-blue-50 p-8 rounded-xl border border-blue-100 my-10 shadow-sm">
    <h3 class="text-blue-900 mt-0 flex items-center gap-2">
        <i data-lucide="calculator" class="w-5 h-5"></i>
        Salary Generation Workflow
    </h3>
    
    <div class="space-y-6 mt-6">
        <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
            <div>
                <h4 class="font-bold text-gray-900 m-0">Select Employee & Period</h4>
                <p class="mt-1 text-sm text-gray-700">Choose the employee from the dropdown list and select the specific <strong>Month</strong> and <strong>Year</strong> for which the salary needs to be calculated.</p>
            </div>
        </div>

        <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
            <div>
                <h4 class="font-bold text-gray-900 m-0">Calculate & Review</h4>
                <p class="mt-1 text-sm text-gray-700">Click <strong>"Generate Salary"</strong> to let the system pull attendance data and calculate earnings and deductions. Use <strong>"Bulk Generate"</strong> to process payroll for the entire team at once.</p>
            </div>
        </div>
    </div>
</div>

<h2>Understanding the Salary Breakdown</h2>
<p>Once calculated, the system provides a detailed breakdown of the <strong>Final Net Salary</strong>. This transparent view includes:</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-10">
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
        <h4 class="font-bold text-green-700 mb-4 flex items-center gap-2">
            <i data-lucide="trending-up" class="w-5 h-5"></i> Income
        </h4>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex justify-between"><span>Basic Salary:</span> <span class="font-bold text-gray-900">₹100,000.00</span></li>
            <li class="flex justify-between"><span>Allowances:</span> <span class="font-bold text-gray-900">+₹0.00</span></li>
            <li class="flex justify-between"><span>Overtime:</span> <span class="font-bold text-gray-900">+₹0.00</span></li>
        </ul>
    </div>

    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
        <h4 class="font-bold text-red-700 mb-4 flex items-center gap-2">
            <i data-lucide="trending-down" class="w-5 h-5"></i> Deductions
        </h4>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex justify-between"><span>Absent Days:</span> <span class="font-bold text-gray-900">-₹0.00</span></li>
            <li class="flex justify-between"><span>Other Deductions:</span> <span class="font-bold text-gray-900">-₹0.00</span></li>
            <li class="flex justify-between font-bold text-red-600 pt-2 border-t"><span>Total Deductions:</span> <span>-₹0.00</span></li>
        </ul>
    </div>
</div>

<div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-10">
    <h4 class="font-bold text-gray-900 mb-3">Attendance Integration</h4>
    <p class="text-sm text-gray-600 mb-4">The system automatically summarizes the employee's monthly attendance to calculate deductions for <strong>Absent Days</strong>, <strong>Late Days</strong>, or <strong>Half Days</strong>.</p>
    <div class="grid grid-cols-4 gap-4 text-center">
        <div class="p-2 bg-white rounded border border-gray-100"><div class="text-xs text-gray-400">Present</div><div class="font-bold text-green-600">0</div></div>
        <div class="p-2 bg-white rounded border border-gray-100"><div class="text-xs text-gray-400">Late</div><div class="font-bold text-yellow-600">0</div></div>
        <div class="p-2 bg-white rounded border border-gray-100"><div class="text-xs text-gray-400">Half</div><div class="font-bold text-orange-600">0</div></div>
        <div class="p-2 bg-white rounded border border-gray-100"><div class="text-xs text-gray-400">Absent</div><div class="font-bold text-red-600">0</div></div>
    </div>
</div>

<h2>Finalizing & Distribution</h2>
<p>After reviewing the calculations, you can take the following actions:</p>
<ul class="list-disc ml-6 space-y-2 text-gray-700 mb-8">
    <li><strong>View Detailed Salary Slip:</strong> Open a full-page digital slip with company branding.</li>
    <li><strong>Download PDF:</strong> Generate a professional PDF document for record-keeping.</li>
    <li><strong>Print:</strong> Directly print the salary slip for physical distribution.</li>
</ul>

<div class="p-4 bg-yellow-50 border border-yellow-100 rounded-lg text-sm text-yellow-800 italic">
    <strong>Note:</strong> Ensure all attendance records for the month are finalized before generating salaries to maintain calculation accuracy.
</div>
