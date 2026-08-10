<h1>Leave Calendar & Holiday Manager</h1>
<p>The <strong>Calendar</strong> module, specifically the <strong>Leave Calendar</strong>, is your organization's central hub for tracking time-off, public holidays, and team availability. It provides a visual, month-by-month overview that helps managers and employees stay aligned on who is available and when the next company break is scheduled.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-gray-900 font-bold m-0">Calendar Interface Overview</h3>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg font-bold">March 2026</span>
        </div>
    </div>
    <div class="p-6">
        <p>The main calendar view uses a color-coded system to identify different types of events at a glance:</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-red-500"></span> Holiday
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-green-500"></span> Approved Leave
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span> Pending Leave
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-gray-500"></span> Rejected Leave
            </div>
        </div>
    </div>
</div>

<h2>Today's Overview & Upcoming Events</h2>
<p>To the right of the calendar, the <strong>Today's Overview</strong> pane provides a quick summary of current and upcoming activities:</p>
<ul class="list-disc ml-6 space-y-2 text-gray-700">
    <li><strong>Today's Leaves:</strong> See which team members are currently away.</li>
    <li><strong>Upcoming Holidays:</strong> Get a countdown to the next scheduled company holiday.</li>
    <li><strong>Pending Requests:</strong> Administrators can quickly identify leave applications awaiting approval.</li>
</ul>

<h2>Adding and Managing Holidays</h2>
<p>Administrators can easily populate the calendar with official breaks. Clicking the <strong>"Add Holiday"</strong> button opens a configuration form with the following fields:</p>

<div class="bg-indigo-50 p-8 rounded-xl border border-indigo-100 my-10 shadow-sm">
    <h3 class="text-indigo-900 mt-0 flex items-center gap-2">
        <i data-lucide="calendar-plus" class="w-5 h-5"></i>
        Holiday Configuration Form
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        <div>
            <h4 class="font-bold text-gray-900 m-0">Holiday Title</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Enter the name of the event, such as <em>"Independence Day"</em> or <em>"Annual Company Retreat."</em></p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Date</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Select the specific day for the holiday using the date picker.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Category</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Classify the holiday (e.g., Public, Restricted, or Corporate) to help employees understand the leave policy for that day.</p>
        </div>

        <div>
            <h4 class="font-bold text-gray-900 m-0">Description (Optional)</h4>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">Add extra details or specific instructions for the team regarding the holiday.</p>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-indigo-100 flex justify-end gap-4">
        <span class="px-4 py-2 text-sm font-semibold text-gray-500">Cancel</span>
        <span class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md">Save Holiday</span>
    </div>
</div>

<h2>Core Utility</h2>
<p>The Calendar module is essential for resource planning. By having all leave and holiday data in one place, your team can:</p>
<ul class="list-disc ml-6 space-y-2 text-gray-700">
    <li><strong>Avoid Project Delays:</strong> Schedule deadlines around known holidays and team absences.</li>
    <li><strong>Streamline Approvals:</strong> Managers can see existing leaves before approving new requests to ensure adequate department coverage.</li>
    <li><strong>Import/Export Data:</strong> Use the <strong>"Import Excel"</strong> feature to bulk-upload holiday lists at the start of the year.</li>
</ul>
