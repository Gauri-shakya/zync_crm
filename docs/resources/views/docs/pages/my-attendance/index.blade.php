<h1>My Attendance & Geofencing</h1>
<p>The <strong>My Attendance</strong> module is a secure, location-based tracking system designed to ensure accurate reporting of employee presence. It uses advanced geofencing technology to verify that staff are physically present at the office before they can mark their attendance.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-blue-600 px-6 py-4 border-b border-blue-700 flex items-center gap-3">
        <i data-lucide="map-pin" class="w-6 h-6 text-white"></i>
        <h3 class="text-white font-bold m-0">Initial Office Setup</h3>
    </div>
    <div class="p-6">
        <p>Before any attendance can be recorded, the <strong>Admin</strong> must complete the office location setup. This is a critical step that defines the physical boundaries for your organization.</p>
        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
            <h4 class="text-sm font-bold text-gray-900 m-0 mb-2">Setup Requirements:</h4>
            <ul class="text-sm text-gray-600 space-y-2 list-disc ml-4">
                <li><strong>Precise Coordinates:</strong> Search for your address or use the <strong>"Use My Current GPS Location"</strong> button to set the exact Latitude (LAT) and Longitude (LNG).</li>
                <li><strong>Operating Hours:</strong> Define the <strong>Start Time</strong> and <strong>End Time</strong> for your business day.</li>
                <li><strong>Working Days:</strong> Specify the number of working days in a month (e.g., 26).</li>
            </ul>
        </div>
    </div>
</div>

<h2>The 500-Meter Geofence Rule</h2>
<p>To maintain high levels of accountability, ZynCRM implements a strict <strong>500-meter radius</strong> rule. Here is how it works for your employees:</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-10">
    <div class="p-6 bg-green-50 border border-green-100 rounded-xl shadow-sm">
        <h4 class="font-bold text-green-700 mb-2 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i> Within Range
        </h4>
        <p class="text-sm text-gray-700">When an employee is within 500 meters of the saved office coordinates, the "Mark Attendance" button becomes active, allowing them to log their presence.</p>
    </div>

    <div class="p-6 bg-red-50 border border-red-100 rounded-xl shadow-sm">
        <h4 class="font-bold text-red-700 mb-2 flex items-center gap-2">
            <i data-lucide="x-circle" class="w-5 h-5"></i> Outside Range
        </h4>
        <p class="text-sm text-gray-700">If the employee is outside the 500-meter radius, the system will prevent them from marking attendance, ensuring that work hours are only logged from the designated workplace.</p>
    </div>
</div>

<div class="bg-orange-50 p-6 rounded-xl border border-orange-100 mb-10">
    <h4 class="font-bold text-orange-900 mb-2 flex items-center gap-2">
        <i data-lucide="smartphone" class="w-5 h-5"></i>
        Mobile-Only Feature
    </h4>
    <p class="text-sm text-orange-800 leading-relaxed"><strong>Important:</strong> Attendance marking is supported <strong>only on mobile devices</strong>. Desktop and laptop computers often provide unreliable GPS data. By using mobile devices, ZynCRM ensures that location access is accurate and verified.</p>
</div>

<h2>Administrative Control</h2>
<p>While employees mark their own attendance, the <strong>Admin</strong> maintains full oversight and control of the system. The admin has the authority to:</p>
<ul class="list-disc ml-6 space-y-2 text-gray-700 mb-10">
    <li><strong>View Records:</strong> Monitor daily, weekly, and monthly attendance for the entire organization.</li>
    <li><strong>Manage Data:</strong> Handle corrections or manual adjustments if an employee encounters technical issues.</li>
    <li><strong>Analyze Trends:</strong> Export detailed attendance reports for payroll and performance reviews.</li>
</ul>

<div class="p-4 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-800 italic">
    <strong>Pro-Tip for Admins:</strong> Use a mobile device to set the office location while standing at the center of your workplace to ensure the most accurate geofence center-point.
</div>
