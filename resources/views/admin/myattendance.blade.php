{{-- Updated resources/views/myattendance/my-attendance.blade.php --}}
{{-- Changes: Fully responsive design for mobile, tablet, and desktop --}}

@extends('components.layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @if(isset($companyDetailsMissing) && $companyDetailsMissing)
    <!-- Setup Mode: Only show styles and the setup form -->
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
        /* Leaflet search bar styling */
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
                Complete Setup
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

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-xl text-sm font-black uppercase tracking-widest text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">
                            Complete Setup & Dashboard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    @else
    <!-- Dashboard Mode: Show standard styles and content -->
    <style>
        @media (max-width: 640px) {
            .container-padding {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .mobile-scroll {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .mobile-text-sm {
                font-size: 0.875rem;
            }

            .mobile-text-xs {
                font-size: 0.75rem;
            }

            .mobile-p-4 {
                padding: 1rem;
            }

            .mobile-mb-4 {
                margin-bottom: 1rem;
            }

            .mobile-stack {
                display: block;
            }

            .mobile-hide {
                display: none;
            }
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .tablet-text-lg {
                font-size: 1.125rem;
            }

            .tablet-p-5 {
                padding: 1.25rem;
            }

            .tablet-grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .shadow-custom {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .progress-bar {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: #10b981;
            transition: width 0.3s ease;
        }

        .location-status-valid {
            color: #10b981;
        }

        .location-status-invalid {
            color: #ef4444;
        }

        /* Mobile-first responsive table - REMOVED to avoid duplicate/broken view (using JS cards instead) */


        /* Touch-friendly buttons for mobile */
        .touch-button {
            min-height: 44px;
            min-width: 44px;
        }

        /* Better tap targets for mobile */
        @media (max-width: 640px) {

            button,
            a {
                min-height: 44px;
            }
        }

        /* Modal Styles */
        .confirmation-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .confirmation-modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 0;
            border-radius: 16px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .confirmation-modal-header {
            padding: 24px 24px 16px 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .confirmation-modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .confirmation-modal-icon.location {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .confirmation-modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .confirmation-modal-body {
            padding: 20px 24px;
            color: #6b7280;
            line-height: 1.6;
        }

        .confirmation-modal-footer {
            padding: 16px 24px 24px 24px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .confirmation-modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            min-height: 44px;
        }

        .confirmation-modal-btn.cancel {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .confirmation-modal-btn.cancel:hover {
            background-color: #e5e7eb;
        }

        .confirmation-modal-btn.confirm {
            background-color: #2563eb;
            color: white;
        }

        .confirmation-modal-btn.confirm:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .confirmation-modal-btn:active {
            transform: translateY(0);
        }

        /* Mobile-specific modal adjustments */
        @media (max-width: 640px) {
            .confirmation-modal-content {
                margin: 5% auto;
                width: 95%;
                max-width: 95%;
            }

            .confirmation-modal-header {
                padding: 16px 16px 12px 16px;
            }

            .confirmation-modal-body {
                padding: 16px;
            }

            .confirmation-modal-footer {
                padding: 12px 16px 16px 16px;
                flex-direction: column;
            }

            .confirmation-modal-btn {
                width: 100%;
                text-align: center;
            }
        }

        /* Location Modal */
        @media (max-width: 768px) {
            #location-modal .bg-white {
                margin: 1rem;
                width: calc(100% - 2rem);
                max-height: calc(100vh - 2rem);
                overflow-y: auto;
            }

            #location-modal .h-64 {
                height: 200px;
            }
        }


        /* Add these styles to your existing CSS */

        /* Break timer animations */
        @keyframes pulse-break {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .break-timer-active {
            animation: pulse-break 2s infinite;
        }

        /* Progress bar animation */
        #break-progress-bar {
            transition: width 1s linear, background-color 0.5s ease;
        }

        /* Responsive adjustments for break timer */
        @media (max-width: 640px) {
            #break-timer-display {
                font-size: 1.5rem;
                /* Adjusted for better fit in bottom sheet */
            }

            /* Mobile specific adjustments if needed */
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            #break-timer-display {
                font-size: 3rem;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto py-3 md:py-6 px-3 sm:px-4 lg:px-8 container-padding">
        <!-- Employee Dashboard -->
        <div class="mb-8 md:mb-12">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 mobile-mb-4">
                <div class="mb-3 md:mb-0">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Employee Attendance</h2>
                    <p class="text-sm md:text-base text-gray-600">By: Employee / My Attendance</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-sm md:text-base text-gray-600" id="current-date">Loading date...</p>
                    <p class="text-sm md:text-base text-gray-800 font-medium">Punch In: <span
                            id="current-punch-time">--:--</span></p>
                </div>
            </div>

            <!-- Employee Profile and Stats Section -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <!-- Employee Profile Card -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-8 flex flex-col items-center text-center group hover:shadow-md transition-all duration-300">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all duration-500"></div>
                        <img class="relative h-28 w-28 rounded-full object-cover shadow-2xl border-4 border-white transform group-hover:scale-105 transition-transform duration-500" 
                             src="{{ $profile['avatar'] }}"
                             alt="Employee avatar">
                    </div>
                    
                    <div class="space-y-1">
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ $profile['name'] }}</h3>
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest">
                            {{ $profile['role'] }}
                        </div>
                        <p class="text-xs font-bold text-gray-400 mt-2">{{ $profile['company'] }}</p>
                    </div>
                </div>

                <!-- Stats Cards Grid -->
                <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Present Days -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-check text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Present Days</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $presentDays }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Working Hours -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Working Hours</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none" id="total-hours">{{ $totalHours }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Break Duration -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-utensils text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Break Duration</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none" id="break-duration">{{ $todayBreakDuration }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Progress -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-5">
                                <div class="h-14 w-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-business-time text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Today's Progress</p>
                                    <h3 class="text-2xl font-black text-gray-900 leading-none" id="today-progress">{{ round($todayProgress) }}%</h3>
                                </div>
                            </div>
                        </div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div id="progress-fill" 
                                 class="h-full bg-gradient-to-r from-purple-500 to-indigo-600 transition-all duration-1000 shadow-[0_0_10px_rgba(147,51,234,0.3)]" 
                                 style="width: {{ $todayProgress }}%"></div>
                        </div>
                    </div>

                    <!-- Absent Days -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-times text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Absent Days</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $absentDays }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance % -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-percentage text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Attendance %</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $attendancePercentage }}%</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Break Timer Display -->
            <div id="active-break-timer"
                class="hidden fixed bottom-24 right-6 md:bottom-8 z-50 bg-white/90 backdrop-blur-2xl shadow-2xl rounded-3xl p-4 flex items-center gap-4 border border-amber-100 animate-bounce-subtle">
                <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-amber-50 text-amber-600 shadow-inner">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none mb-1">On Break</span>
                    <span id="break-timer-display" class="text-lg font-black text-gray-900 tabular-nums leading-none">00:00</span>
                </div>
                <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div id="break-progress-bar" class="h-full bg-amber-500 transition-all duration-1000 shadow-[0_0_8px_rgba(245,158,11,0.4)]" style="width: 0%"></div>
                </div>
                <button id="end-break-timer-btn"
                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-rose-500 hover:bg-rose-600 text-white shadow-lg shadow-rose-200 transition-all hover:scale-105 active:scale-95">
                    <i class="fas fa-stop text-sm"></i>
                </button>
            </div>

            <!-- Punch Controls -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fas fa-fingerprint text-xl"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 tracking-tight">Attendance Actions</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <button id="punch-in-btn"
                        class="group relative overflow-hidden bg-emerald-500 hover:bg-emerald-600 text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:-translate-y-0.5 active:translate-y-0 {{ $todayRecord && $todayRecord->punch_in ? 'opacity-50 cursor-not-allowed grayscale' : '' }}"
                        {{ $todayRecord && $todayRecord->punch_in ? 'disabled' : '' }}>
                        <div class="flex items-center justify-center gap-3">
                            <i class="fas fa-sign-in-alt text-xl group-hover:rotate-12 transition-transform"></i>
                            <span class="tracking-wide uppercase text-sm">Punch In</span>
                        </div>
                    </button>

                    <button id="punch-out-btn"
                        class="group relative overflow-hidden bg-rose-500 hover:bg-rose-600 text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg shadow-rose-200 hover:shadow-rose-300 hover:-translate-y-0.5 active:translate-y-0 {{ !$todayRecord || !$todayRecord->punch_in ? 'opacity-50 cursor-not-allowed grayscale' : '' }}"
                        {{ !$todayRecord || !$todayRecord->punch_in ? 'disabled' : '' }}>
                        <div class="flex items-center justify-center gap-3">
                            <i class="fas fa-sign-out-alt text-xl group-hover:-rotate-12 transition-transform"></i>
                            <span class="tracking-wide uppercase text-sm">Punch Out</span>
                        </div>
                    </button>

                    <button id="break-in-btn"
                        class="group relative overflow-hidden bg-amber-500 hover:bg-amber-600 text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg shadow-amber-200 hover:shadow-amber-300 hover:-translate-y-0.5 active:translate-y-0">
                        <div class="flex items-center justify-center gap-3">
                            <i class="fas fa-pause text-xl group-hover:scale-110 transition-transform"></i>
                            <span class="tracking-wide uppercase text-sm">Break In</span>
                        </div>
                    </button>

                    <button id="break-out-btn"
                        class="group relative overflow-hidden bg-blue-500 hover:bg-blue-600 text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 active:translate-y-0">
                        <div class="flex items-center justify-center gap-3">
                            <i class="fas fa-play text-xl group-hover:scale-110 transition-transform"></i>
                            <span class="tracking-wide uppercase text-sm">Break Out</span>
                        </div>
                    </button>
                </div>

                <div class="mt-8 p-4 bg-gray-50/50 rounded-2xl border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-rose-500">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Current Location</p>
                            <span id="location-display" class="text-sm font-bold text-gray-700 leading-none">
                                {{ $todayRecord->location ?? 'Location will be captured when you punch in' }}
                            </span>
                        </div>
                    </div>
                    <div id="distance-display" class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full uppercase tracking-widest"></div>
                </div>
            </div>

            <!-- Attendance Log Table -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fas fa-list-ul text-xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-gray-900 tracking-tight">Attendance Log</h3>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="relative group">
                            <select id="attendance-month-filter"
                                    class="appearance-none bg-white border border-gray-100 rounded-2xl px-5 py-2.5 pr-12 text-sm font-bold text-gray-700 shadow-sm transition-all hover:border-gray-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none cursor-pointer min-w-[200px]">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $currentMonth == $m ? 'selected' : '' }}>
                                        {{ date('F Y', mktime(0, 0, 0, $m, 1, now()->year)) }}
                                    </option>
                                @endfor
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-2.5 rounded-2xl border border-gray-100 flex items-center gap-2">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Page</span>
                            <span class="text-sm font-black text-gray-900" id="current-page-display">1/1</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <!-- Desktop Table -->
                    <table class="min-w-full hidden md:table">
                        <thead>
                            <tr class="border-b border-gray-50">
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Punch In</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Punch Out</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Work Hours</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Breaks</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Break</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/50" id="employee-attendance-log">
                            <!-- Rows populated by JS -->
                        </tbody>
                    </table>

                    <!-- Mobile Cards View -->
                    <div class="md:hidden space-y-4" id="mobile-attendance-cards">
                        <!-- Cards will be populated by JS -->
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                            <i class="fas fa-info-circle text-sm"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-400">{{ date('F 1, Y', strtotime('first day of this month')) }} of service</span>
                    </div>
                    <div class="flex items-center gap-2" id="attendance-pagination">
                        <!-- Pagination buttons will be populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>



    @if(!isset($companyDetailsMissing) || !$companyDetailsMissing)
    <!-- Location Confirmation Modal -->
    <div id="locationConfirmationModal" class="confirmation-modal">
        <div class="confirmation-modal-content">
            <div class="confirmation-modal-header">
                <div class="confirmation-modal-icon location">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="confirmation-modal-title" id="confirmationModalTitle">Location Access Required</h3>
            </div>
            <div class="confirmation-modal-body">
                <p id="confirmationModalMessage">This action requires access to your GPS location to verify your
                    attendance.</p>
                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        <div>
                            <p class="text-sm text-blue-700 font-medium">Why we need your location?</p>
                            <p class="text-xs text-blue-600 mt-1">To ensure you're within the allowed office premises
                                and maintain accurate attendance records.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="confirmation-modal-footer">
                <button type="button" class="confirmation-modal-btn cancel" id="confirmationModalCancel">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="button" class="confirmation-modal-btn confirm" id="confirmationModalConfirm">
                    <i class="fas fa-check mr-2"></i>Allow Location
                </button>
            </div>
        </div>
    </div>

    <div id="breakDetailsModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl w-full max-w-md p-5 shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-semibold text-gray-800">Break Details</h3>
                <button onclick="closeBreakDetails()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="breakDetailsList" class="space-y-2 max-h-80 overflow-y-auto text-sm text-gray-700">
            </div>
        </div>
    </div>
    @endif
    @endif

    <script>
    @if(isset($companyDetailsMissing) && $companyDetailsMissing)
        // Setup Mode Script
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('company-details-form');
            const locationBtn = document.getElementById('get-location-btn');
            const latInput = document.getElementById('details_latitude');
            const lngInput = document.getElementById('details_longitude');
            const errorMsg = document.getElementById('location-error');

            // Initialize Leaflet Map
            let map, marker;
            const defaultLat = {{ $company->latitude ?? 28.6139 }}; // Default to Delhi if empty
            const defaultLng = {{ $company->longitude ?? 77.2090 }};

            function initMap() {
                const initialLat = parseFloat(latInput.value) || defaultLat;
                const initialLng = parseFloat(lngInput.value) || defaultLng;
                
                map = L.map('map').setView([initialLat, initialLng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map);

                // Add Search/Geocoder
                const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: "Search for your office address...",
                    collapsed: false
                }).on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    map.setView(latlng, 17);
                    updateMarkerAndInputs(latlng.lat, latlng.lng);
                }).addTo(map);

                // Update on Marker Drag
                marker.on('dragend', function(e) {
                    const position = marker.getLatLng();
                    updateMarkerAndInputs(position.lat, position.lng);
                });

                // Update on Map Click
                map.on('click', function(e) {
                    updateMarkerAndInputs(e.latlng.lat, e.latlng.lng);
                });
            }

            function updateMarkerAndInputs(lat, lng) {
                const latFixed = parseFloat(lat).toFixed(6);
                const lngFixed = parseFloat(lng).toFixed(6);
                marker.setLatLng([latFixed, lngFixed]);
                latInput.value = latFixed;
                lngInput.value = lngFixed;
                errorMsg.classList.add('hidden');
            }

            // Initialize on Load
            initMap();

            locationBtn.addEventListener('click', function() {
                if (navigator.geolocation) {
                    locationBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Getting Location...';
                    locationBtn.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            map.setView([lat, lng], 17);
                            updateMarkerAndInputs(lat, lng);
                            
                            errorMsg.classList.add('hidden');
                            locationBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Location Captured';
                            locationBtn.classList.remove('bg-indigo-50', 'text-indigo-600');
                            locationBtn.classList.add('bg-green-50', 'text-green-600');
                            
                            setTimeout(() => {
                                locationBtn.disabled = false;
                                locationBtn.innerHTML = '<i class="fas fa-location-crosshairs"></i> Use My Current GPS Location';
                                locationBtn.classList.add('bg-indigo-50', 'text-indigo-600');
                                locationBtn.classList.remove('bg-green-50', 'text-green-600');
                            }, 2000);
                        },
                        function(error) {
                            console.error("Error getting location:", error);
                            let msg = "Error getting location.";
                            switch(error.code) {
                                case error.PERMISSION_DENIED: msg = "User denied the request for Geolocation."; break;
                                case error.POSITION_UNAVAILABLE: msg = "Location information is unavailable."; break;
                                case error.TIMEOUT: msg = "The request to get user location timed out."; break;
                            }
                            errorMsg.textContent = msg;
                            errorMsg.classList.remove('hidden');
                            locationBtn.innerHTML = '<i class="fas fa-location-crosshairs"></i> Retry Location';
                            locationBtn.disabled = false;
                        }
                    );
                } else {
                    errorMsg.textContent = "Geolocation is not supported by this browser.";
                    errorMsg.classList.remove('hidden');
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                
                // Add CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('{{ route("my-attendance.update-company-details") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        window.location.reload();
                    } else {
                        alert(result.error || result.message || 'Failed to update details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let message = error.message || error.error || 'An error occurred while saving details';
                    if (error.errors) {
                         message += '\n' + Object.values(error.errors).flat().join('\n');
                    }
                    alert(message);
                });
            });
        });
    @else
        // Dashboard Mode Script
        const BREAK_STORAGE_KEY = `active_break_${{{ auth()->id() }}}`;


        // ──────────────────────────────────────────────────────────────────────────────
        // CONSTANTS & CONFIG
        // ──────────────────────────────────────────────────────────────────────────────
        const OFFICE_LAT = {{ $company->latitude ?? 0 }};
        const OFFICE_LON = {{ $company->longitude ?? 0 }};
        const ALLOWED_DISTANCE_KM = 1;
        const MAX_BREAK_SECONDS = 3600; // 1 hour maximum break time

        // ──────────────────────────────────────────────────────────────────────────────
        // STATE VARIABLES
        // ──────────────────────────────────────────────────────────────────────────────
        let attendanceData = @json($jsAttendanceData);
        let currentAttendanceLog = @json($attendanceLog);
        let currentPage = 1;
        const recordsPerPage = 10;

        let workTimer = null;
        let workSeconds = 0;
        let totalWorkSeconds = 0;

        let breakTimerInterval = null;
        let breakStartTime = null;
        let currentBreakSeconds = 0;

        let breakAlertShown = false;


        let punchInTime = attendanceData.punchIn ? new Date(attendanceData.punchIn) : null;
        let lunchStartTime = attendanceData.lunchStart ? new Date(attendanceData.lunchStart) : null;

        // ──────────────────────────────────────────────────────────────────────────────
        // DOM ELEMENTS
        // ──────────────────────────────────────────────────────────────────────────────
        const elements = {
            punchInBtn: document.getElementById('punch-in-btn'),
            punchOutBtn: document.getElementById('punch-out-btn'),
            breakInBtn: document.getElementById('break-in-btn'),
            breakOutBtn: document.getElementById('break-out-btn'),

            locationDisplay: document.getElementById('location-display'),
            locationStatus: document.getElementById('location-status'),
            distanceDisplay: document.getElementById('distance-display'),

            totalHours: document.getElementById('total-hours'),
            breakDurationEl: document.getElementById('break-duration'),
            currentPunchTime: document.getElementById('current-punch-time'),
            currentDate: document.getElementById('current-date'),

            todayProgress: document.getElementById('today-progress'),
            progressFill: document.getElementById('progress-fill'),

            employeeAttendanceLog: document.getElementById('employee-attendance-log'),
            mobileAttendanceCards: document.getElementById('mobile-attendance-cards'),
            attendancePagination: document.getElementById('attendance-pagination'),
            currentPageDisplay: document.getElementById('current-page-display'),

            // Break timer specific elements
            activeBreakTimer: document.getElementById('active-break-timer'),
            noActiveBreak: document.getElementById('no-active-break'),
            breakStartTimeEl: document.getElementById('break-start-time'),
            breakTimerDisplay: document.getElementById('break-timer-display'),
            breakProgressBar: document.getElementById('break-progress-bar'),
            breakTimerProgress: document.getElementById('break-timer-progress'),
            endBreakTimerBtn: document.getElementById('end-break-timer-btn'),
        };

        // CSRF Token
        // CSRF Token already declared in header.blade.php
        // const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // ──────────────────────────────────────────────────────────────────────────────
        // INITIALIZATION
        // ──────────────────────────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            initEventListeners();
            initializeTimersAndUI();
            initializeBreakTimer();

            // Periodic updates
            setInterval(updateCurrentDateTime, 60000);
            setInterval(checkBreakStatus, 30000);

            // Initial UI setup
            updateCurrentDateTime();
            updateAttendanceUI();
            updateButtonStates();
            handleResize();

            window.addEventListener('resize', handleResize);
        });

        // ──────────────────────────────────────────────────────────────────────────────
        // ATTENDANCE LOG UI MANAGEMENT
        // ──────────────────────────────────────────────────────────────────────────────
        function updateAttendanceUI() {
            const start = (currentPage - 1) * recordsPerPage;
            const end = start + recordsPerPage;
            const paginatedData = currentAttendanceLog.slice(start, end);

            generateEmployeeAttendanceLog(paginatedData);
            generateMobileAttendanceCards(paginatedData);
            renderPagination();
            updatePageDisplay();
        }

        function updatePageDisplay() {
            if (!elements.currentPageDisplay) return;
            const totalPages = Math.ceil(currentAttendanceLog.length / recordsPerPage) || 1;
            elements.currentPageDisplay.textContent = `${currentPage}/${totalPages}`;
        }

        function renderPagination() {
            if (!elements.attendancePagination) return;
            const totalPages = Math.ceil(currentAttendanceLog.length / recordsPerPage);
            
            let html = '';
            
            // Prev Button
            html += `
                <button 
                    onclick="changePage(${currentPage - 1})"
                    ${currentPage === 1 ? 'disabled' : ''}
                    class="touch-button ${currentPage === 1 ? 'bg-gray-100 text-gray-400' : 'bg-gray-200 hover:bg-gray-300 text-gray-700'} font-medium py-1 px-2 md:px-3 rounded text-sm transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;

            // Page Numbers
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                html += `
                    <button 
                        onclick="changePage(${i})"
                        class="touch-button ${currentPage === i ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-700'} font-medium py-1 px-2 md:px-3 rounded text-sm transition-colors">
                        ${i}
                    </button>
                `;
            }

            // Next Button
            html += `
                <button 
                    onclick="changePage(${currentPage + 1})"
                    ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}
                    class="touch-button ${currentPage === totalPages || totalPages === 0 ? 'bg-gray-100 text-gray-400' : 'bg-gray-200 hover:bg-gray-300 text-gray-700'} font-medium py-1 px-2 md:px-3 rounded text-sm transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;

            elements.attendancePagination.innerHTML = html;
        }

        window.changePage = function(page) {
            const totalPages = Math.ceil(currentAttendanceLog.length / recordsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            updateAttendanceUI();
            
            // Scroll to table top on mobile
            if (window.innerWidth < 768) {
                elements.employeeAttendanceLog.closest('.bg-white').scrollIntoView({ behavior: 'smooth' });
            }
        };

        // ──────────────────────────────────────────────────────────────────────────────
        // EVENT LISTENERS
        // ──────────────────────────────────────────────────────────────────────────────
        function initEventListeners() {
            elements.punchInBtn?.addEventListener('click', () => handleAttendanceAction('punchIn', '{{ route("my-attendance.punch-in") }}'));
            elements.punchOutBtn?.addEventListener('click', () => handleAttendanceAction('punchOut', '{{ route("my-attendance.punch-out") }}'));

            elements.breakInBtn?.addEventListener('click', handleBreakIn);
            elements.breakOutBtn?.addEventListener('click', () => handleBreakEndAction('breakOut', '{{ route("my-attendance.break-out") }}'));
            elements.endBreakTimerBtn?.addEventListener('click', () => handleBreakEndAction('breakOut', '{{ route("my-attendance.break-out") }}'));

            document.getElementById('attendance-month-filter')?.addEventListener('change', filterEmployeeAttendance);
        }

        // ──────────────────────────────────────────────────────────────────────────────
        // BREAK TIMER MANAGEMENT
        // ──────────────────────────────────────────────────────────────────────────────
        function initializeBreakTimer() {
            const storedBreakTime = localStorage.getItem(BREAK_STORAGE_KEY);

            if (attendanceData.breakRunning && storedBreakTime) {
                breakStartTime = new Date(storedBreakTime);

                if (!isNaN(breakStartTime.getTime())) {
                    currentBreakSeconds = Math.floor(
                        (Date.now() - breakStartTime.getTime()) / 1000
                    );

                    showActiveBreakTimer();
                    startBreakTimerDisplay();
                }
            }

            checkBreakStatus();
        }





        async function checkBreakStatus() {
            try {
                const response = await fetch('{{ route("my-attendance.break-status") }}');
                if (!response.ok) throw new Error('Break status check failed');

                const data = await response.json();
                if (data.error) {
                    console.error('Break status error:', data.error);
                    return;
                }

                attendanceData.breakRunning = data.break_running;

                if (data.break_running && data.break_data?.break_in) {

                    // 🔒 SET ONLY ONCE
                    if (!breakStartTime) {
                        breakStartTime = new Date(data.break_data.break_in);

                        if (isNaN(breakStartTime.getTime())) return;

                        currentBreakSeconds = Math.floor(
                            data.break_data.break_duration_seconds || 0
                        );
                    }

                    showActiveBreakTimer();

                    if (!breakTimerInterval && breakStartTime) {
                        startBreakTimerDisplay();
                    }

                }




                updateButtonStates();
            } catch (err) {
                console.error('Failed to check break status:', err);
            }
        }

        function showActiveBreakTimer() {
            if (!elements.activeBreakTimer) return;

            elements.activeBreakTimer.classList.remove('hidden');
            elements.noActiveBreak?.classList.add('hidden');
        }



        function hideActiveBreakTimer() {
            if (!elements.activeBreakTimer) return;

            elements.activeBreakTimer.classList.add('hidden');
            elements.noActiveBreak?.classList.remove('hidden');

            if (breakTimerInterval) {
                clearInterval(breakTimerInterval);
                breakTimerInterval = null;
            }
        }


        function startBreakTimerDisplay() {
            if (breakTimerInterval) return;

            breakTimerInterval = setInterval(() => {
                // 🛑 HARD GUARD
                if (!breakStartTime || isNaN(breakStartTime.getTime())) {
                    return;
                }

                currentBreakSeconds = Math.floor(
                    (Date.now() - breakStartTime.getTime()) / 1000
                );

                updateBreakTimerDisplay();

                if (currentBreakSeconds >= MAX_BREAK_SECONDS && !breakAlertShown) {
                    breakAlertShown = true;
                    alert('⚠️ Maximum break time (1 hour) exceeded! Please end your break.');
                }
            }, 1000);
        }




        function updateBreakTimerDisplay() {
            if (
                !elements.breakTimerDisplay ||
                isNaN(currentBreakSeconds)
            ) return;

            const totalSeconds = Math.max(0, Math.floor(currentBreakSeconds));

            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            elements.breakTimerDisplay.textContent =
                `${padZero(minutes)}m ${padZero(seconds)}s`;

            const percent = Math.min(
                (totalSeconds / MAX_BREAK_SECONDS) * 100,
                100
            );

            if (elements.breakProgressBar) {
                elements.breakProgressBar.style.width = `${percent}%`;
            }
        }




        // ──────────────────────────────────────────────────────────────────────────────
        // BREAK ACTIONS
        // ──────────────────────────────────────────────────────────────────────────────
        async function handleBreakIn() {
            if (attendanceData.breakRunning) {
                alert('ℹ️ Break is already in progress!');
                location.reload();
                return;
            }

            try {
                const confirmLocation = await showLocationConfirmation('breakIn');
                if (!confirmLocation) return;

                const locationData = await getLocation();
                const postData = createLocationPostData(locationData);

                const result = await ajaxPost('{{ route("my-attendance.break-in") }}', postData);

                if (result.error) {
                    alert(result.error);
                    return;
                }

                // ✅ SET STATE
                // ✅ SET STATE
                attendanceData.breakRunning = true;

                breakStartTime = new Date(result.break_in ?? Date.now());
                localStorage.setItem(BREAK_STORAGE_KEY, breakStartTime.toISOString());


                currentBreakSeconds = 0;
                breakAlertShown = false;

                showActiveBreakTimer();
                startBreakTimerDisplay();
                updateButtonStates();

                // location.reload();


            } catch (err) {
                console.error('Break in failed:', err);
                alert('Break in failed');
            }
        }


        async function handleBreakEndAction(actionType, route) {
            try {
                const confirmLocation = await showLocationConfirmation(actionType);
                if (!confirmLocation) return;

                const locationData = await getLocation();

                if (!locationData.isWithinRange && !locationData.error) {
                    const proceed = confirm(
                        `📍 You are ${locationData.distance}km away from office (allowed: ${ALLOWED_DISTANCE_KM}km).\n\nDo you want to proceed anyway?`
                    );
                    if (!proceed) return;
                }

                const postData = createLocationPostData(locationData);
                const result = await ajaxPost(route, postData);

                if (result.error) {
                    alert(`❌ Error: ${result.error}`);
                    return;
                }

                // ────────────────────────────────
                // SUCCESS: API call succeeded
                // ────────────────────────────────

                updateLocationDisplay(locationData);

                let message = `✅ Break Ended Successfully!`;
                if (result.break_duration) message += `\nBreak Duration: ${result.break_duration}`;
                if (result.total_break_time) message += `\nTotal Break Today: ${result.total_break_time}`;
                alert(message);

                if (result.total_break_time && elements.breakDurationEl) {
                    elements.breakDurationEl.textContent = result.total_break_time;
                }

                // ────────────────────────────────
                // FINAL CLEANUP & STATE RESET (ONLY ON SUCCESS)
                // ────────────────────────────────

                // Clear persisted break data from localStorage
                localStorage.removeItem(BREAK_STORAGE_KEY);

                // Stop and clear the break timer interval
                if (breakTimerInterval) {
                    clearInterval(breakTimerInterval);
                    breakTimerInterval = null;
                }

                // Reset all break-related variables
                breakStartTime = null;
                currentBreakSeconds = 0;
                breakAlertShown = false;

                // Update attendance state
                attendanceData.breakRunning = false;

                // Update UI
                hideActiveBreakTimer();
                updateButtonStates();

                // Refresh break history and reload page (or update UI dynamically)
                updateBreakHistory();
                location.reload(); // Consider replacing with dynamic UI updates in production


            } catch (error) {
                console.error('Break end error:', error);
                alert(`❌ Error during break out: ${error.message || error}`);
            }
        }

        // ──────────────────────────────────────────────────────────────────────────────
        // GENERAL ATTENDANCE ACTIONS
        // ──────────────────────────────────────────────────────────────────────────────
        async function handleAttendanceAction(actionType, route) {
            const btn = actionType === 'punchIn' ? elements.punchInBtn : elements.punchOutBtn;
            const originalDisabled = btn ? btn.disabled : false;
            
            try {
                const confirmLocation = await showLocationConfirmation(actionType);
                if (!confirmLocation) return;

                if (btn) btn.disabled = true;

                const locationData = await getLocation();

                if (!locationData.isWithinRange && !locationData.error) {
                    const proceed = confirm(`📍 Location Alert\n\nYou are ${locationData.distance}km away from office (allowed: ${ALLOWED_DISTANCE_KM}km).\n\nProceed with ${actionType.replace(/([A-Z])/g, ' $1').trim()} anyway?`);
                    if (!proceed) return;
                }

                const postData = createLocationPostData(locationData);
                const result = await ajaxPost(route, postData);

                if (result.error) {
                    alert(`❌ Error: ${result.error}`);
                    return;
                }

                updateLocationDisplay(locationData);


                const actionNames = {
                    'punchIn': 'Punched In',
                    'punchOut': 'Punched Out',
                    'breakIn': 'Break Started',
                    'breakOut': 'Break Ended'
                };

                // Update local state based on action
                if (actionType === 'punchIn') {
                    attendanceData.punchIn = result.punch_time; // Expecting time string or true
                } else if (actionType === 'punchOut') {
                    attendanceData.punchOut = result.punch_time;
                } else if (actionType === 'breakIn') {
                    attendanceData.breakRunning = true;
                    // handleBreakIn handles its own state/timer, but good to sync
                } else if (actionType === 'breakOut') {
                    attendanceData.breakRunning = false;
                }

                updateButtonStates();

                let successMessage = `✅ ${actionNames[actionType]} Successfully!`;
                if (result.work_hours) successMessage += `\nTotal Work Hours: ${result.work_hours}`;
                if (result.break_duration) successMessage += `\nBreak Duration: ${result.break_duration}`;
                if (result.total_break_time) successMessage += `\nTotal Break Today: ${result.total_break_time}`;
                if (locationData.distance) successMessage += `\nDistance: ${locationData.distance}km`;


                // alert(successMessage); // Optional: removing alert if we want smoother UX, or keep it. Keeping for now.
                // Use a non-blocking notification if possible, but alert is consistent with existing code.

                // Reload to refresh table/logs is good practice if we don't dynamically update the table
                location.reload();

            } catch (error) {
                console.error(`${actionType} error:`, error);
                alert(`❌ Error during ${actionType}: ${error.message}`);
                
                // Re-enable button on error
                if (btn) btn.disabled = originalDisabled;
                updateButtonStates();
            }
        }

        // ──────────────────────────────────────────────────────────────────────────────
        // HELPERS
        // ──────────────────────────────────────────────────────────────────────────────
        function padZero(num) {
            return num.toString().padStart(2, '0');
        }

        function createLocationPostData(locationData) {
            const data = { location: locationData.fullLocation || locationData.message };
            if (locationData.latitude && locationData.longitude) {
                Object.assign(data, {
                    latitude: locationData.latitude,
                    longitude: locationData.longitude,
                    accuracy: locationData.accuracy,
                    distance: locationData.distance,
                    is_within_range: locationData.isWithinRange
                });
            }
            return data;
        }

        function getLocation() {
            return new Promise((resolve) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const { latitude, longitude, accuracy } = position.coords;
                            const distance = calculateDistance(latitude, longitude, OFFICE_LAT, OFFICE_LON);
                            const isWithinRange = distance <= ALLOWED_DISTANCE_KM;

                            resolve({
                                latitude: latitude.toFixed(6),
                                longitude: longitude.toFixed(6),
                                accuracy: accuracy.toFixed(2),
                                distance: distance.toFixed(2),
                                isWithinRange,
                                location: `Lat: ${latitude.toFixed(6)}, Lng: ${longitude.toFixed(6)}`,
                                fullLocation: `Lat: ${latitude.toFixed(6)}, Lng: ${longitude.toFixed(6)}, Accuracy: ${accuracy.toFixed(2)}m, Distance: ${distance.toFixed(2)}km`
                            });
                        },
                        () => {
                            resolve({
                                error: true,
                                message: 'Location access denied or unavailable',
                                isWithinRange: false
                            });
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                } else {
                    resolve({
                        error: true,
                        message: 'Geolocation not supported',
                        isWithinRange: false
                    });
                }
            });
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function updateLocationDisplay(locationData) {
            if (locationData.error) {
                if (elements.locationDisplay) elements.locationDisplay.textContent = locationData.message;
                if (elements.locationStatus) {
                    elements.locationStatus.textContent = '❌ Location Error';
                    elements.locationStatus.className = 'ml-2 text-sm font-medium location-status-invalid';
                }
                if (elements.distanceDisplay) elements.distanceDisplay.textContent = '';
                return false;
            }

            if (elements.locationDisplay) elements.locationDisplay.textContent = locationData.location;
            if (elements.distanceDisplay) elements.distanceDisplay.textContent = `Distance: ${locationData.distance}km | Accuracy: ${locationData.accuracy}m`;

            if (locationData.isWithinRange) {
                if (elements.locationStatus) {
                    elements.locationStatus.textContent = '✅ Within Range';
                    elements.locationStatus.className = 'ml-2 text-sm font-medium location-status-valid';
                }
            } else {
                if (elements.locationStatus) {
                    elements.locationStatus.textContent = '❌ Out of Range';
                    elements.locationStatus.className = 'ml-2 text-sm font-medium location-status-invalid';
                }
            }

            return locationData.isWithinRange;
        }

        function showLocationConfirmation(actionType) {
            return new Promise((resolve) => {
                const actionNames = {
                    punchIn: 'Punch In',
                    punchOut: 'Punch Out',
                    breakIn: 'Break Start',
                    breakOut: 'Break End'
                };

                const modal = document.getElementById('locationConfirmationModal');
                if (!modal) {
                    resolve(true); // fallback if no confirmation modal
                    return;
                }

                const title = document.getElementById('confirmationModalTitle');
                const message = document.getElementById('confirmationModalMessage');
                const confirmBtn = document.getElementById('confirmationModalConfirm');
                const cancelBtn = document.getElementById('confirmationModalCancel');

                title.textContent = `📍 ${actionNames[actionType]} - Location Access`;
                message.textContent = `This action requires access to your GPS location to verify you're within office premises.`;

                modal.style.display = 'block';

                const handleConfirm = () => { cleanup(); resolve(true); };
                const handleCancel = () => { cleanup(); resolve(false); };
                const handleEscape = (e) => { if (e.key === 'Escape') handleCancel(); };
                const handleOutside = (e) => { if (e.target === modal) handleCancel(); };

                const cleanup = () => {
                    modal.style.display = 'none';
                    confirmBtn.removeEventListener('click', handleConfirm);
                    cancelBtn.removeEventListener('click', handleCancel);
                    document.removeEventListener('keydown', handleEscape);
                    modal.removeEventListener('click', handleOutside);
                };

                confirmBtn.addEventListener('click', handleConfirm);
                cancelBtn.addEventListener('click', handleCancel);
                document.addEventListener('keydown', handleEscape);
                modal.addEventListener('click', handleOutside);

                confirmBtn.focus();
            });
        }

       function updateCurrentDateTime() {
    const now = new Date(
        new Date().toLocaleString('en-US', { timeZone: 'Asia/Kolkata' })
    );

    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, '0');
    const dd = String(now.getDate()).padStart(2, '0');

    elements.currentDate.textContent = `${dd}-${mm}-${yyyy}`;
}


        async function ajaxPost(route, data = {}) {
            const response = await fetch(route, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                let errorMessage = `HTTP error! status: ${response.status}`;
                try {
                    const errorData = await response.json();
                    if (errorData.error) {
                        errorMessage = errorData.error;
                    }
                } catch (e) {
                    console.error('Error parsing error response:', e);
                }
                throw new Error(errorMessage);
            }
            return await response.json();
        }

        function updateButtonStates() {
            const isBreakActive = attendanceData.breakRunning === true;

            // Punch In
            if (elements.punchInBtn) {
                elements.punchInBtn.disabled = !!attendanceData.punchIn;
                if (attendanceData.punchIn) {
                    elements.punchInBtn.title = 'You have already punched in today';
                }
            }

            // Punch Out
            if (elements.punchOutBtn) {
                elements.punchOutBtn.disabled = !attendanceData.punchIn || !!attendanceData.punchOut || isBreakActive;
                if (attendanceData.punchOut) {
                    elements.punchOutBtn.title = 'You have already punched out today';
                } else if (isBreakActive) {
                    elements.punchOutBtn.title = 'Cannot punch out during break';
                } else if (!attendanceData.punchIn) {
                    elements.punchOutBtn.title = 'Please punch in first';
                }
            }

            // Break In
            if (elements.breakInBtn) {
                elements.breakInBtn.disabled = !attendanceData.punchIn || isBreakActive || !!attendanceData.punchOut;
                if (isBreakActive) {
                    elements.breakInBtn.title = 'Break already in progress';
                } else if (!attendanceData.punchIn) {
                    elements.breakInBtn.title = 'Please punch in first';
                } else if (attendanceData.punchOut) {
                    elements.breakInBtn.title = 'Cannot start break after punch out';
                }
            }

            // Break Out
            if (elements.breakOutBtn) {
                elements.breakOutBtn.disabled = !isBreakActive || !!attendanceData.punchOut;
                if (!isBreakActive) {
                    elements.breakOutBtn.title = 'No active break to end';
                } else if (attendanceData.punchOut) {
                    elements.breakOutBtn.title = 'Cannot end break after punch out';
                }
            }
        }

        // ──────────────────────────────────────────────────────────────────────────────
        // UI GENERATION
        // ──────────────────────────────────────────────────────────────────────────────
        function generateEmployeeAttendanceLog(data) {
            if (!elements.employeeAttendanceLog) return;
            elements.employeeAttendanceLog.innerHTML = '';

            data.forEach((record) => {
                const row = document.createElement('tr');
                row.className = 'group hover:bg-gray-50/50 transition-colors';
                
                const statusConfig = {
                    'Present': 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'Late': 'bg-amber-50 text-amber-600 border-amber-100',
                    'Half Day': 'bg-blue-50 text-blue-600 border-blue-100',
                    'Absent': 'bg-rose-50 text-rose-600 border-rose-100'
                };
                const statusClass = statusConfig[record.status] || 'bg-gray-50 text-gray-600 border-gray-100';

                row.innerHTML = `
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="text-[13px] font-black text-gray-900">${record.date}</span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="text-[13px] font-bold text-gray-600">${record.punchIn || '--'}</span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="text-[13px] font-bold text-gray-600">${record.punchOut || '--'}</span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="text-[13px] font-black text-gray-900">${record.workHours || '--'}</span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest border rounded-full ${statusClass}">
                            ${record.status}
                        </span>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        ${record.breaks?.length ? `
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 text-[10px] font-black bg-amber-50 text-amber-600 uppercase tracking-widest rounded-lg">
                                    ${record.breaks.length} Breaks
                                </span>
                                <button
                                    class="text-blue-600 text-[11px] font-black uppercase tracking-widest hover:text-blue-800 transition-colors"
                                    onclick="showBreakDetails(${JSON.stringify(record.breaks).replace(/"/g, '&quot;')})">
                                    View
                                </button>
                            </div>
                        ` : '<span class="text-[13px] text-gray-400 font-bold">--</span>'}
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="text-[13px] font-black text-gray-900">${record.totalBreak || '--'}</span>
                    </td>
                `;
                elements.employeeAttendanceLog.appendChild(row);
            });
        }

        function generateMobileAttendanceCards(data) {
            if (!elements.mobileAttendanceCards) return;
            elements.mobileAttendanceCards.innerHTML = '';

            data.forEach((record) => {
                const statusConfig = {
                    'Present': 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'Late': 'bg-amber-50 text-amber-600 border-amber-100',
                    'Half Day': 'bg-blue-50 text-blue-600 border-blue-100',
                    'Absent': 'bg-rose-50 text-rose-600 border-rose-100'
                };
                const statusClass = statusConfig[record.status] || 'bg-gray-50 text-gray-600 border-gray-100';

                const breaksHtml = record.breaks?.length
                    ? record.breaks.map(b => `<div class="px-3 py-2 bg-gray-50 rounded-xl text-[11px] font-bold text-gray-600 border border-gray-100">${b}</div>`).join('')
                    : '<div class="text-[11px] font-bold text-gray-400">No breaks recorded</div>';

                const card = document.createElement('div');
                card.className = 'bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-gray-100 p-6 space-y-4 group transition-all duration-300 hover:shadow-md';

                card.innerHTML = `
                    <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                        <span class="text-sm font-black text-gray-900">${record.date}</span>
                        <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest border rounded-full ${statusClass}">
                            ${record.status}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Punch In</p>
                            <p class="text-sm font-bold text-gray-700">${record.punchIn || '--'}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Punch Out</p>
                            <p class="text-sm font-bold text-gray-700">${record.punchOut || '--'}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Work Hours</p>
                            <p class="text-sm font-black text-gray-900">${record.workHours || '--'}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Break</p>
                            <p class="text-sm font-black text-gray-900">${record.totalBreak || '--'}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-50">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">Breaks Detail</p>
                        <div class="space-y-2">
                            ${breaksHtml}
                        </div>
                    </div>
                `;

                elements.mobileAttendanceCards.appendChild(card);
            });
        }

        function handleResize() {
            const isMobile = window.innerWidth < 768;
            const table = document.querySelector('.responsive-table');
            const cards = elements.mobileAttendanceCards;

            if (isMobile) {
                table?.classList.add('hidden');
                cards?.classList.remove('hidden');
            } else {
                table?.classList.remove('hidden');
                cards?.classList.add('hidden');
            }
        }

        async function filterEmployeeAttendance() {
            const month = parseInt(document.getElementById('attendance-month-filter').value, 10);
            const year = {{ now()->year }};

            try {
                const response = await fetch(`{{ route("my-attendance.log") }}?month=${month}&year=${year}`);
                const logData = await response.json();
                currentAttendanceLog = logData;
                currentPage = 1;
                updateAttendanceUI();
            } catch (error) {
                console.error('Error fetching attendance log:', error);
                alert('Error loading attendance data');
            }
        }

        async function updateBreakHistory() {
            try {
                const today = new Date().toISOString().split('T')[0];
                const response = await fetch(`{{ route("my-attendance.log") }}?month=${new Date().getMonth() + 1}&year=${new Date().getFullYear()}`);
                const logData = await response.json();

                const todayRecord = logData.find(record => {
                    const recordDate = record.date.split('-').reverse().join('-');
                    return recordDate === today;
                });

                const breakHistoryTable = document.getElementById('break-history-table');
                const noBreaksMessage = document.getElementById('no-breaks-message');

                if (todayRecord && todayRecord.breaks?.length > 0) {
                    if (breakHistoryTable) breakHistoryTable.innerHTML = '';
                    if (noBreaksMessage) noBreaksMessage.style.display = 'none';

                    let totalBreakSeconds = 0;
                    let breakCount = 0;

                    todayRecord.breaks.forEach((breakItem) => {
                        const [breakIn, breakOut] = breakItem.split(' - ');
                        const isActive = breakOut === 'Running';

                        let duration = '--';
                        if (!isActive && breakIn && breakOut) {
                            const inTime = parseTime(breakIn);
                            const outTime = parseTime(breakOut);
                            if (inTime && outTime) {
                                const diffMs = outTime - inTime;
                                const diffSec = Math.floor(diffMs / 1000);
                                const hours = Math.floor(diffSec / 3600);
                                const minutes = Math.floor((diffSec % 3600) / 60);
                                duration = `${padZero(hours)}:${padZero(minutes)}`;
                                totalBreakSeconds += diffSec;
                            }
                        }

                        if (breakHistoryTable) {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50';
                            row.innerHTML = `
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${breakIn || '--'}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${breakOut || 'Running'}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium ${isActive ? 'text-yellow-600' : 'text-gray-700'}">
                                                ${duration}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${isActive ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'}">
                                                    ${isActive ? 'Active' : 'Completed'}
                                                </span>
                                            </td>
                                        `;
                            breakHistoryTable.appendChild(row);
                        }
                        breakCount++;
                    });

                    const breakCountEl = document.getElementById('today-break-count');
                    const totalBreakEl = document.getElementById('today-total-break');
                    
                    if (breakCountEl) breakCountEl.textContent = breakCount;
                    
                    const totalH = Math.floor(totalBreakSeconds / 3600);
                    const totalM = Math.floor((totalBreakSeconds % 3600) / 60);
                    if (totalBreakEl) totalBreakEl.textContent = `${padZero(totalH)}:${padZero(totalM)}`;
                } else {
                    if (breakHistoryTable) breakHistoryTable.innerHTML = '';
                    if (noBreaksMessage) noBreaksMessage.style.display = 'block';
                    
                    const breakCountEl = document.getElementById('today-break-count');
                    const totalBreakEl = document.getElementById('today-total-break');
                    
                    if (breakCountEl) breakCountEl.textContent = '0';
                    if (totalBreakEl) totalBreakEl.textContent = '00:00';
                }
            } catch (error) {
                console.error('Error updating break history:', error);
            }
        }

        function parseTime(timeStr) {
            if (!timeStr || timeStr === '--' || timeStr === 'Running') return null;

            try {
                const [time, modifier] = timeStr.split(' ');
                let [hours, minutes] = time.split(':');

                if (modifier === 'PM' && hours !== '12') hours = parseInt(hours) + 12;
                if (modifier === 'AM' && hours === '12') hours = '00';

                const date = new Date();
                date.setHours(parseInt(hours), parseInt(minutes), 0, 0);
                return date;
            } catch (e) {
                console.error('Error parsing time:', e);
                return null;
            }
        }

        // Optional: Keep these if you still use work timer display
        function startWorkTimer() {
            if (workTimer) return;
            workTimer = setInterval(() => {
                workSeconds++;
                // You can update work time display here if needed
            }, 1000);
        }

        function initializeTimersAndUI() {
            if (attendanceData.punchIn) {
                // punchIn is pre-formatted as "h:i A" (e.g. "09:30 AM") by the controller
                elements.currentPunchTime.textContent = attendanceData.punchIn;

                if (!attendanceData.punchOut) {
                    startWorkTimer();
                }
            }
        }




        function showBreakDetails(breaks) {
            const modal = document.getElementById('breakDetailsModal');
            const list = document.getElementById('breakDetailsList');

            list.innerHTML = '';

            breaks.forEach((b, index) => {
                const isRunning = b.includes('Running');

                list.innerHTML += `
                                <div class="flex justify-between items-center p-2 rounded-lg border ${isRunning ? 'bg-yellow-50' : 'bg-gray-50'}">
                                    <span>${index + 1}. ${b}</span>
                                    <span class="text-xs font-medium ${isRunning ? 'text-yellow-600' : 'text-green-600'}">
                                        ${isRunning ? 'Active' : 'Done'}
                                    </span>
                                </div>
                            `;
            });

            modal.classList.remove('hidden');
        }

        function closeBreakDetails() {
            document.getElementById('breakDetailsModal').classList.add('hidden');
        }

        // Company Details Modal Logic
        const companyDetailsForm = document.getElementById('company-details-form');
        const getLocationBtn = document.getElementById('get-location-btn');

        if (companyDetailsForm) {
            getLocationBtn.addEventListener('click', () => {
                if (navigator.geolocation) {
                    getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Fetching...';
                    getLocationBtn.disabled = true;
                    
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            document.getElementById('details_latitude').value = position.coords.latitude.toFixed(6);
                            document.getElementById('details_longitude').value = position.coords.longitude.toFixed(6);
                            getLocationBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Location Set';
                            getLocationBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                            getLocationBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                            document.getElementById('location-error').classList.add('hidden');
                        },
                        (error) => {
                            console.error('Error getting location:', error);
                            document.getElementById('location-error').textContent = 'Could not get location. Please allow location access.';
                            document.getElementById('location-error').classList.remove('hidden');
                            getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Retry Location';
                            getLocationBtn.disabled = false;
                        },
                        { enableHighAccuracy: true }
                    );
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            companyDetailsForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(companyDetailsForm);
                const data = Object.fromEntries(formData.entries());
                
                // Basic validation
                if (!data.latitude || !data.longitude) {
                    alert('Please set your location first.');
                    return;
                }

                try {
                    const response = await fetch('{{ route("my-attendance.update-company-details") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Company details updated successfully!');
                        location.reload();
                    } else {
                        alert(result.error || 'Failed to update details.');
                    }
                } catch (error) {
                    console.error('Error updating details:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        }

    @endif
    </script>
@endsection