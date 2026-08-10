<h1>My Tickets & Support Center</h1>
<p>The <strong>My Tickets</strong> module, also known as the <strong>Support Center</strong>, is your dedicated space for communicating with our technical and customer success teams. This module ensures that every inquiry you raise is tracked, prioritized, and resolved efficiently.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-200">
        <h3 class="text-gray-900 font-bold m-0 text-lg sm:text-xl">Support Center Dashboard</h3>
    </div>
    <div class="p-4 sm:p-6">
        <p class="leading-relaxed">On the main dashboard, you can view all your existing tickets. Each entry displays a <strong>Ticket Identity</strong> (a unique reference ID), the <strong>Subject & Category</strong>, current <strong>Status</strong>, and <strong>Last Activity</strong>. You can click on <strong>Details</strong> to view the full conversation or add updates to a ticket.</p>
    </div>
</div>

<h2>Creating a New Support Request</h2>
<p>To start a new inquiry, click the <strong>"+ Open New Ticket"</strong> button located at the top right of the Support Center dashboard. This will open a form with several critical fields designed to help us understand and resolve your issue quickly.</p>

<div class="bg-blue-50 p-4 sm:p-8 rounded-xl border border-blue-100 my-10">
    <h3 class="text-blue-900 mt-0">Support Form Field Guide</h3>
    <p class="text-blue-800 mb-6">Providing detailed and accurate information in these fields ensures that your request is routed to the right specialist immediately.</p>
    
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
            <div class="min-w-0 flex-1">
                <h4 class="font-bold text-gray-900 m-0">Inquiry Subject</h4>
                <p class="mt-2 text-gray-700 leading-relaxed">This should be a brief, one-sentence summary of your issue. Avoid generic subjects like "Help" or "Error." Instead, use specific titles like <em>"Unable to download Q3 Tax Report"</em> or <em>"Attendance sync failed for March 24."</em></p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
            <div class="min-w-0 flex-1">
                <h4 class="font-bold text-gray-900 m-0">Priority Level</h4>
                <p class="mt-2 text-gray-700 leading-relaxed">Select how this issue affects your business:</p>
                <ul class="mt-2 space-y-1 text-sm text-gray-600">
                    <li><strong>Low:</strong> General questions or minor UI suggestions.</li>
                    <li><strong>Medium:</strong> Features working incorrectly but with a workaround.</li>
                    <li><strong>High:</strong> Significant impact on daily operations.</li>
                    <li><strong>Urgent:</strong> Business-critical systems are down (e.g., cannot process payroll).</li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
            <div class="min-w-0 flex-1">
                <h4 class="font-bold text-gray-900 m-0">Related Domains (Optional)</h4>
                <p class="mt-2 text-gray-700 leading-relaxed">Specify which module of ZynCRM you are having trouble with (e.g., HR, Sales, Billing, Projects). This helps us skip the triage phase and send your ticket directly to the specialized team for that domain.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">4</div>
            <div class="min-w-0 flex-1">
                <h4 class="font-bold text-gray-900 m-0">Detailed Description</h4>
                <div class="mt-2 text-gray-700 leading-relaxed">
                    <p>This is the most important field. Please include:</p>
                    <ul class="list-disc ml-5 mt-2 space-y-1">
                        <li>The steps you took before the issue occurred.</li>
                        <li>Any specific error codes or messages displayed.</li>
                        <li>Your expected result vs. what actually happened.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">5</div>
            <div class="min-w-0 flex-1">
                <h4 class="font-bold text-gray-900 m-0">Supporting Documentation</h4>
                <p class="mt-2 text-gray-700 leading-relaxed">Attach screenshots, screen recordings (MP4/GIF), or log files. Visual evidence is often the fastest way for our engineers to diagnose a bug.</p>
            </div>
        </div>
    </div>
</div>

<h2>Ticket Statuses</h2>
<p>Track the progress of your inquiry by monitoring its status label:</p>
<ul class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    <li class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-center">
        <span class="text-blue-600 font-bold">OPEN</span><br>
        <small class="text-gray-500">Awaiting agent assignment</small>
    </li>
    <li class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-center">
        <span class="text-orange-600 font-bold">IN-PROGRESS</span><br>
        <small class="text-gray-500">Currently being investigated</small>
    </li>
    <li class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-center">
        <span class="text-green-600 font-bold">RESOLVED</span><br>
        <small class="text-gray-500">Issue has been fixed</small>
    </li>
</ul>
