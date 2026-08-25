{{-- resources/views/admin/partials/attendance-setup.blade.php --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<style>
    .shadow-custom { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .animate-bounce-subtle {
        animation: bounce-subtle 3s infinite ease-in-out;
    }
    #map {
        height: 300px;
        width: 100%;
        border-radius: 1rem;
        margin-top: 1rem;
        border: 1px solid #e5e7eb;
        z-index: 1;
    }
    .leaflet-control-geocoder {
        border-radius: 0.75rem !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
    .leaflet-control-geocoder-form input {
        padding: 8px 12px !important;
        font-family: inherit !important;
        border-radius: 0.5rem !important;
    }
</style>

<div id="company-details-modal" class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="flex justify-center">
            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                <i class="fas fa-building text-indigo-600 text-xl"></i>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            {{ isset($isEdit) && $isEdit ? 'Update Office Details' : 'Complete Setup' }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ $company->name ?? 'Your Company' }}
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="bg-white py-8 px-4 shadow-2xl sm:rounded-xl sm:px-10 border border-gray-100">
            <form id="company-details-form" class="space-y-6">
                
                <!-- Location Section -->
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-gray-700"> Office Location </label>
                    
                    <p class="text-xs text-gray-500 italic">Search for your address or click/drag the marker on the map to set your office location.</p>

                    <div id="map" class="shadow-inner"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-xs font-black uppercase tracking-widest">Lat</span>
                            </div>
                            <input type="text" id="details_latitude" name="latitude" value="{{ $company->latitude ?? '' }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 py-3 sm:text-sm border border-gray-200 rounded-xl transition-all font-bold text-gray-700" placeholder="0.0000" readonly required>
                        </div>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-xs font-black uppercase tracking-widest">Lng</span>
                            </div>
                            <input type="text" id="details_longitude" name="longitude" value="{{ $company->longitude ?? '' }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 py-3 sm:text-sm border border-gray-200 rounded-xl transition-all font-bold text-gray-700" placeholder="0.0000" readonly required>
                        </div>
                    </div>
                    
                    <button type="button" id="get-location-btn" class="w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-indigo-100 rounded-xl text-sm font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none transition-all duration-200">
                        <i class="fas fa-location-crosshairs"></i> Use My Current GPS Location
                    </button>
                    
                    <p id="location-error" class="mt-2 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Office Wi-Fi IP Address -->
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-gray-700"> Office Wi-Fi IP Address </label>
                    <p class="text-xs text-gray-500 italic">Save your office's public IP address. Employees connected to this Wi-Fi will be able to punch in without location checks.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1 rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-wifi text-gray-400"></i>
                            </div>
                            <input type="text" id="office_ip_address" name="office_ip_address" value="{{ $company->office_ip_address ?? '' }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 py-3 sm:text-sm border border-gray-200 rounded-xl transition-all font-bold text-gray-700" placeholder="e.g. 192.168.1.1">
                        </div>
                        <button type="button" onclick="getPublicIP()" class="w-full sm:w-auto flex justify-center items-center gap-2 py-2.5 px-4 border border-indigo-100 rounded-xl text-sm font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none transition-all duration-200">
                            <i class="fas fa-network-wired"></i> Auto Detect IP
                        </button>
                    </div>
                </div>

                <!-- Working Days & Times -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="total_working_days" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2"> Working Days </label>
                        <div class="relative">
                            <input type="number" step="0.5" name="total_working_days" id="total_working_days" value="{{ $company->total_working_days ?? '' }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 sm:text-sm border border-gray-200 rounded-xl font-bold text-gray-700" placeholder="e.g. 26" required>
                        </div>
                    </div>
                    <div>
                        <label for="office_start_time" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2"> Start Time </label>
                        <input type="time" name="office_start_time" id="office_start_time" value="{{ $company->office_start_time ?? '' }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 sm:text-sm border border-gray-200 rounded-xl font-bold text-gray-700" required>
                    </div>
                    <div>
                        <label for="office_end_time" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2"> End Time </label>
                        <input type="time" name="office_end_time" id="office_end_time" value="{{ $company->office_end_time ?? '' }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 sm:text-sm border border-gray-200 rounded-xl font-bold text-gray-700" required>
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-4">
                    @if(isset($isEdit) && $isEdit)
                    <button type="button" onclick="toggleSetupMode(false)" class="flex-1 flex justify-center py-4 px-6 border border-gray-200 rounded-2xl shadow-sm text-sm font-black uppercase tracking-widest text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all duration-300">
                        Cancel
                    </button>
                    @endif
                    <button type="submit" class="flex-[2] flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-xl text-sm font-black uppercase tracking-widest text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">
                        {{ isset($isEdit) && $isEdit ? 'Save Changes' : 'Complete Setup & Dashboard' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function getPublicIP() {
        const ipInput = document.getElementById('office_ip_address');
        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detecting...';
        btn.disabled = true;

        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                ipInput.value = data.ip;
                btn.innerHTML = '<i class="fas fa-check"></i> Detected';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }, 2000);
            })
            .catch(error => {
                console.error('Error fetching IP:', error);
                alert('Could not auto-detect IP. Please enter it manually.');
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            });
    }
</script>
