@extends('components.layout')

@section('title', 'Clients')

@section('header-title', 'Clients')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="p-4 lg:p-8 pb-24 lg:pb-8">
        <div class="max-w-7xl mx-auto space-y-4 lg:space-y-6">
@php
    $now = \Carbon\Carbon::now();
    $thisMonthStart = $now->copy()->startOfMonth();
    $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
    $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

    $totalLeadsCount = $clients->count();
    $followUpCount = 0;
    $closedCount = 0;
    $notInterestedCount = 0;
    $nonContactableCount = 0;

    $thisMonth = ['total' => 0, 'followUp' => 0, 'closed' => 0, 'notInterested' => 0, 'nonContactable' => 0];
    $lastMonth = ['total' => 0, 'followUp' => 0, 'closed' => 0, 'notInterested' => 0, 'nonContactable' => 0];

    foreach($clients as $c) {
        $cStatus = strtolower($c->status ?? '');
        $aStatus = strtolower($c->leadAction->status ?? '');
        
        $date = $c->created_at ? \Carbon\Carbon::parse($c->created_at) : null;
        $isThisMonth = $date && $date->between($thisMonthStart, $now);
        $isLastMonth = $date && $date->between($lastMonthStart, $lastMonthEnd);

        if ($isThisMonth) $thisMonth['total']++;
        if ($isLastMonth) $lastMonth['total']++;
        
        if (in_array($cStatus, ['client', 'purchased']) || in_array($aStatus, ['client', 'purchased'])) {
            $closedCount++;
            if ($isThisMonth) $thisMonth['closed']++;
            if ($isLastMonth) $lastMonth['closed']++;
        } elseif (in_array($cStatus, ['not interested', 'lost']) || in_array($aStatus, ['not interested', 'lost'])) {
            $notInterestedCount++;
            if ($isThisMonth) $thisMonth['notInterested']++;
            if ($isLastMonth) $lastMonth['notInterested']++;
        } elseif (in_array($cStatus, ['non-contactable', 'not reachable']) || in_array($aStatus, ['non-contactable', 'not reachable'])) {
            $nonContactableCount++;
            if ($isThisMonth) $thisMonth['nonContactable']++;
            if ($isLastMonth) $lastMonth['nonContactable']++;
        } elseif (!empty($c->next_follow_up) || !empty($c->leadAction->next_follow_up) || in_array($aStatus, ['will call back', 'interested', 'missed booked'])) {
            $followUpCount++;
            if ($isThisMonth) $thisMonth['followUp']++;
            if ($isLastMonth) $lastMonth['followUp']++;
        }
    }

    $calcTrend = function($current, $previous) {
        if ($previous == 0) {
            return $current > 0 ? ['value' => 100, 'dir' => 'up'] : ['value' => 0, 'dir' => 'neutral'];
        }
        $change = (($current - $previous) / $previous) * 100;
        return [
            'value' => abs(round($change, 1)),
            'dir' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'neutral')
        ];
    };

    $trends = [
        'total' => $calcTrend($thisMonth['total'], $lastMonth['total']),
        'followUp' => $calcTrend($thisMonth['followUp'], $lastMonth['followUp']),
        'closed' => $calcTrend($thisMonth['closed'], $lastMonth['closed']),
        'notInterested' => $calcTrend($thisMonth['notInterested'], $lastMonth['notInterested']),
        'nonContactable' => $calcTrend($thisMonth['nonContactable'], $lastMonth['nonContactable'])
    ];

    $renderTrend = function($trendData) {
        $html = '';
        if($trendData['dir'] == 'up') {
            $html .= '<span class="flex items-center text-emerald-500"><svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>' . $trendData['value'] . '%</span>';
        } elseif($trendData['dir'] == 'down') {
            $html .= '<span class="flex items-center text-rose-500"><svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>' . $trendData['value'] . '%</span>';
        } else {
            $html .= '<span class="flex items-center text-slate-400"><svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path></svg>0%</span>';
        }
        $html .= '<span class="text-slate-400 ml-1.5 font-normal">vs last month</span>';
        return $html;
    };
@endphp
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div>
        <h2 class="text-2xl lg:text-3xl font-bold text-slate-900">Clients & Leads</h2>
        <p class="text-slate-500 mt-2">Manage your client relationships and pipeline</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
        <button id="import-client-btn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-green-600 hover:bg-green-700 shadow-lg shadow-green-500/30 text-white w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Import from Excel
        </button>
        <button id="add-client-btn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 text-white w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                <path d="M5 12h14"></path>
                <path d="M12 5v14"></path>
            </svg>
            Add New Client
        </button>
    </div>
</div>

<!-- Import Modal -->
<div id="import-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-lg font-semibold text-slate-900">Import Clients from Excel</h3>
            <button id="close-import-modal" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form id="import-form" enctype="multipart/form-data">
            @csrf

            <div class="p-6 space-y-4">

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Excel / CSV File
                    </label>

                    <input type="file"
                           name="excel_file"
                           id="excel_file"
                           accept=".xlsx,.xls,.csv"
                           class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100"
                           required>

                    <div class="flex justify-between items-center mt-2">
                        <p class="text-xs text-slate-500">
                            Supported formats: .xlsx, .xls, .csv
                        </p>

                        <!-- Sample File Download -->
                        <a href="{{ asset('samples/clients_import_sample.csv') }}"
                           download
                           class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                            Download Sample File
                        </a>
                    </div>
                </div>

                <!-- Expected Columns -->
<div class="bg-slate-50 border border-slate-200 p-4 rounded-lg text-xs text-slate-600 space-y-3">

    <div>
        <p class="font-semibold text-slate-800 mb-1">Required Columns</p>
        <div class="flex flex-wrap gap-2">
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">company_name</span>
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">contact_person</span>
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">email</span>
        </div>
    </div>

    <div>
        <p class="font-semibold text-slate-800 mb-1">Optional Columns</p>
        <div class="flex flex-wrap gap-2">
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">phone</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">status</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">priority</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">industry</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">budget</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">source</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">next_follow_up</span>
            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded">notes</span>
        </div>
    </div>

    <div class="flex items-start gap-2 text-slate-500">
        <span>⚠️</span>
        <p>
            Column names must <strong>match exactly</strong> as shown in the sample file.
            Extra or renamed columns may cause rows to be skipped.
        </p>
    </div>

</div>

            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 p-6 border-t">
                <button type="button"
                        id="cancel-import"
                        class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900">
                    Cancel
                </button>

                <button type="submit"
                        id="submit-import"
                        class="inline-flex items-center px-4 py-2
                               bg-green-600 hover:bg-green-700
                               text-white text-sm font-medium
                               rounded-md shadow-lg shadow-green-500/30">

                    <svg id="import-spinner"
                         class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0
                                 C5.373 0 0 5.373 0 12h4
                                 zm2 5.291A7.962 7.962 0 014 12H0
                                 c0 3.042 1.135 5.824 3 7.938
                                 l3-2.647z"></path>
                    </svg>

                    Import Clients
                </button>
            </div>

        </form>
    </div>
</div>

            <!-- Besdesk Dashboard -->
            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <div class="mb-4 mt-2">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 lg:gap-5">
                    
                    <!-- Total Leads -->
                    <div class="filter-dashboard-card active-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('all', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-blue-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-blue-200 text-blue-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-blue-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Total Leads</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-blue-600 transition-colors">{{ $totalLeadsCount }}</span>
                            </div>
                        </div>
                        <div class="relative z-10 mt-5 flex items-center text-[11px] sm:text-xs font-medium">
                            {!! $renderTrend($trends['total']) !!}
                        </div>
                    </div>

                    <!-- Follow Up -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('follow_up', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-indigo-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-indigo-200 text-indigo-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-indigo-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Follow Up</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-indigo-600 transition-colors">{{ $followUpCount }}</span>
                            </div>
                        </div>
                        <div class="relative z-10 mt-5 flex items-center text-[11px] sm:text-xs font-medium">
                            {!! $renderTrend($trends['followUp']) !!}
                        </div>
                    </div>

                    <!-- Closed Leads -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('closed', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-teal-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-teal-200 text-teal-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-teal-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Closed</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-teal-600 transition-colors">{{ $closedCount }}</span>
                            </div>
                        </div>
                        <div class="relative z-10 mt-5 flex items-center text-[11px] sm:text-xs font-medium">
                            {!! $renderTrend($trends['closed']) !!}
                        </div>
                    </div>

                    <!-- Not Interested -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('not_interested', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-rose-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-rose-200 text-rose-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-rose-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Not Interest</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-rose-600 transition-colors">{{ $notInterestedCount }}</span>
                            </div>
                        </div>
                        <div class="relative z-10 mt-5 flex items-center text-[11px] sm:text-xs font-medium">
                            {!! $renderTrend($trends['notInterested']) !!}
                        </div>
                    </div>

                    <!-- Non-contactable -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('non_contactable', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-orange-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-orange-200 text-orange-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-orange-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.122-3.536m-4.243-4.243a8.976 8.976 0 013.536-2.122m3.536-2.122a4.978 4.978 0 012.83-1.414M12 12v.01"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Non-contact</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-orange-600 transition-colors">{{ $nonContactableCount }}</span>
                            </div>
                        </div>
                        <div class="relative z-10 mt-5 flex items-center text-[11px] sm:text-xs font-medium">
                            {!! $renderTrend($trends['nonContactable']) !!}
                        </div>
                    </div>

                </div>
            </div>
            @elseif(auth()->check())
            @php
                $myTotalLeadsCount = 0;
                $myFollowUpCount = 0;
                $myClosedCount = 0;
                $myNotInterestedCount = 0;
                $myNonContactableCount = 0;
                $userId = auth()->id();

                foreach($clients as $c) {
                    if ($c->leadAction && $c->leadAction->user_id == $userId) {
                        $myTotalLeadsCount++;
                        $cStatus = strtolower($c->status ?? '');
                        $aStatus = strtolower($c->leadAction->status ?? '');
                        
                        if (in_array($cStatus, ['client', 'purchased', 'closed']) || in_array($aStatus, ['client', 'purchased', 'closed'])) {
                            $myClosedCount++;
                        } elseif (in_array($cStatus, ['not interested', 'lost']) || in_array($aStatus, ['not interested', 'lost'])) {
                            $myNotInterestedCount++;
                        } elseif (in_array($cStatus, ['non-contactable', 'not reachable']) || in_array($aStatus, ['non-contactable', 'not reachable'])) {
                            $myNonContactableCount++;
                        } elseif (!empty($c->next_follow_up) || !empty($c->leadAction->next_follow_up) || in_array($aStatus, ['will call back', 'interested', 'missed booked', 'follow up', 'lead', 'proposal', 'negotiation'])) {
                            $myFollowUpCount++;
                        }
                    }
                }
            @endphp
            <div class="mb-4 mt-2">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 lg:gap-5">
                    
                    <!-- My Total Leads -->
                    <div class="filter-dashboard-card active-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('my_all', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-blue-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-blue-200 text-blue-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-blue-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Total Leads</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-blue-600 transition-colors">{{ $myTotalLeadsCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- My Follow Up -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('my_follow_up', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-indigo-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-indigo-200 text-indigo-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-indigo-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Follow Up</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-indigo-600 transition-colors">{{ $myFollowUpCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- My Closed -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('my_closed', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-teal-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-teal-200 text-teal-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-teal-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Closed</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-teal-600 transition-colors">{{ $myClosedCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- My Not Interested -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('my_not_interested', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-rose-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-rose-200 text-rose-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-rose-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Not Interest</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-rose-600 transition-colors">{{ $myNotInterestedCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- My Non-contactable -->
                    <div class="filter-dashboard-card relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group" onclick="setDashboardFilter('my_non_contactable', this)">
                        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-orange-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-3 sm:gap-4">
                            <div class="w-11 h-11 flex items-center justify-center rounded-xl rounded-bl-[4px] border border-orange-200 text-orange-500 group-hover:scale-110 group-hover:-rotate-3 group-hover:bg-orange-50 transition-all duration-300 shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.122-3.536m-4.243-4.243a8.976 8.976 0 013.536-2.122m3.536-2.122a4.978 4.978 0 012.83-1.414M12 12v.01"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-medium text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">Non-contact</span>
                                <span class="text-3xl font-semibold text-slate-800 tracking-tight leading-none group-hover:text-orange-600 transition-colors">{{ $myNonContactableCount }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            <style>
                .active-dashboard-card {
                    border-color: #6366f1 !important;
                    box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1), 0 4px 6px -4px rgba(99, 102, 241, 0.05) !important;
                    background-color: #f8fafc !important;
                }
            </style>

            <!-- Search and Filter -->
            <div class="flex flex-col lg:flex-row gap-3 lg:gap-4 items-center mt-2">
                <div class="relative flex-1 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input id="search-input" class="flex h-9 sm:h-10 w-full rounded-md border border-slate-200 px-3 py-2 pl-10 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Search clients..." value="">
                </div>
                
                <!-- View Switcher -->
                <div class="flex items-center bg-white p-1 rounded-md border border-slate-200 shadow-sm">
                    <button id="grid-view-btn" class="p-1 sm:p-1.5 rounded-sm transition-all duration-200 bg-indigo-50 text-indigo-600 shadow-sm" title="Grid View">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </button>
                    <button id="table-view-btn" class="p-1 sm:p-1.5 rounded-sm transition-all duration-200 text-slate-400 hover:text-slate-600" title="Table View">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </button>
                </div>

                <div class="w-full lg:w-auto">
                    <div class="h-auto lg:h-10 items-center justify-center rounded-md p-1 bg-white w-full lg:w-auto grid grid-cols-3 sm:grid-cols-5 lg:flex gap-1 border border-slate-200 shadow-sm">
                        @if(auth()->check() && auth()->user()->hasRole('admin'))
                            <button class="filter-btn active inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm transition-colors" data-status="all">All</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="lead">Leads</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="follow_up">Follow Up</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="closed">Closed</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="not_interested">Not Interested</button>
                        @elseif(auth()->check())
                            <button class="filter-btn active inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm transition-colors" data-status="all">All</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="my_all">Leads</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="my_follow_up">Follow Up</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="my_closed">Closed</button>
                            <button class="filter-btn inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-slate-600 hover:bg-slate-50 transition-colors" data-status="my_not_interested">Not Interest</button>
                        @endif
                    </div>
                </div>
            </div>

           <!-- Client Cards Grid -->
<div id="clients-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
    @foreach($clients as $client)
    @php
        $canSeeFullCompanyName = auth()->user()->hasRole('admin');
        
        $canSeeFullDetails = true;
        if ($client->leadAction) {
            $canSeeFullDetails = false;
            if (auth()->user()->hasRole('admin') || $client->leadAction->user_id == auth()->id()) {
                $canSeeFullDetails = true;
            }
        }

        $cStatus = strtolower($client->status ?? '');
        $aStatus = strtolower($client->leadAction->status ?? '');
        $dashboardCategory = 'other';
        if (in_array($cStatus, ['client', 'purchased']) || in_array($aStatus, ['client', 'purchased'])) {
            $dashboardCategory = 'closed';
        } elseif (in_array($cStatus, ['not interested', 'lost']) || in_array($aStatus, ['not interested', 'lost'])) {
            $dashboardCategory = 'not_interested';
        } elseif (in_array($cStatus, ['non-contactable', 'not reachable']) || in_array($aStatus, ['non-contactable', 'not reachable'])) {
            $dashboardCategory = 'non_contactable';
        } elseif (!empty($client->next_follow_up) || !empty($client->leadAction->next_follow_up) || in_array($aStatus, ['will call back', 'interested', 'missed booked'])) {
            $dashboardCategory = 'follow_up';
        }
    @endphp
    <div class="client-card rounded-lg border border-slate-200/60 bg-white/80 backdrop-blur-sm hover:shadow-xl transition-all duration-300 group" data-status="{{ $client->status }}" data-category="{{ $dashboardCategory }}" data-assigned-user="{{ $client->leadAction->user_id ?? '' }}">
        <div class="flex flex-col space-y-1.5 p-6 pb-3">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3 flex-1 min-w-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-xl flex items-center justify-center shadow-lg shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                            <path d="M10 6h4"></path>
                            <path d="M10 10h4"></path>
                            <path d="M10 14h4"></path>
                            <path d="M10 18h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-slate-900 text-lg truncate" @if($canSeeFullCompanyName) title="{{ $client->company_name }}" @endif>
                            @if($canSeeFullCompanyName)
                                {{ $client->company_name }}
                            @else
                                {{ explode(' ', trim($client->company_name))[0] }} ****
                            @endif
                        </h3>
                        <p class="text-sm text-slate-500 truncate" title="{{ $client->contact_person }}">{{ $client->contact_person }}</p>
                    
                    
                    </div>
                </div>
                <div class="flex items-center gap-1">
                   

                    <!-- Edit Button -->
                    @can('Edit Lead')
                    {{-- <div class="relative group inline-block">
                        <button
                            class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 hover:bg-gray-200 transition edit-client-btn"
                            data-client-id="{{ $client->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24"
                                viewBox="0 0 24 24"
                                fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="w-4 h-4 text-gray-700">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </button>
                        <span class="absolute left-1/2 -translate-x-1/2 -bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                            Edit
                        </span>
                    </div>     --}}


                    
<div class="relative inline-block text-left">
    <!-- Toggle Button -->
    <button
        id="toggle-grid-client-options-{{ $client->id }}"
        aria-expanded="false"
        aria-haspopup="true"
        onclick="toggleDropdown('grid-client-options-menu-{{ $client->id }}')"
        class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 hover:bg-gray-200 transition"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
            width="24" height="24"
            viewBox="0 0 24 24"
            fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="w-4 h-4 text-gray-700">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="12" cy="5" r="1"></circle>
            <circle cx="12" cy="19" r="1"></circle>
        </svg>
    </button>

<!-- Dropdown Menu -->
<div
    id="grid-client-options-menu-{{ $client->id }}"
    class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 hidden"
    role="menu"
    aria-orientation="vertical"
    aria-labelledby="toggle-grid-client-options-{{ $client->id }}"
>
    <div class="py-1" role="none">
        <a href="{{ route('clients.edit', $client->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
            Edit Lead
        </a>
        @if($client->leadAction)
        <a href="{{ route('myleads.edit', $client->leadAction->id) }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
           role="menuitem">
            Edit Taken Action
        </a>
        @endif
        
        <!-- Delete Option - Only for Admin -->
        @if(auth()->user()->hasRole('admin'))
        <button type="button" onclick="openDeleteModal('{{ $client->id }}', '{{ addslashes($client->company_name) }}', '{{ route('clients.destroy', $client->id) }}')"
                class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700" role="menuitem">
            Delete Client
        </button>
        @endif
    </div>
</div>


</div>



                    @endcan
                </div>
            </div>
        </div>
        <div class="p-6 pt-0 space-y-3">
            <div class="flex flex-wrap gap-2">
                <div class="status-badge inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize 
                    @if($client->status == 'lead') bg-gray-100 text-gray-700 border-gray-300 border
                    @elseif($client->status == 'qualified') bg-blue-100 text-blue-700 border-blue-300 border
                    @elseif($client->status == 'proposal') bg-purple-100 text-purple-700 border-purple-300 border
                    @elseif($client->status == 'negotiation') bg-yellow-100 text-yellow-700 border-yellow-300 border
                    @elseif($client->status == 'client') bg-green-100 text-green-700 border-green-300 border
                    @else bg-red-100 text-red-700 border-red-300 border @endif">
                    {{ $client->status }}
                </div>
                <div class="priority-badge inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold 
                    @if($client->priority == 'low') bg-green-100 text-green-700
                    @elseif($client->priority == 'medium') bg-yellow-100 text-yellow-700
                    @else bg-orange-100 text-orange-700 @endif">
                    {{ $client->priority }} priority
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0">
                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                    </svg>
                    <span class="truncate">{{ $client->email }}</span>
                </div>
                @if($client->phone)
                <div class="flex items-center gap-2 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span>
                        @if($canSeeFullDetails)
                            {{ $client->phone }}
                        @else
                            {{ str_repeat('*', max(0, strlen($client->phone) - 3)) . substr($client->phone, -3) }}
                        @endif
                    </span>
                </div>
                @endif
                @if($client->next_follow_up)
                <div class="flex items-center gap-2 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                    <span>Follow-up: {{ \Carbon\Carbon::parse($client->next_follow_up)->format('M j, Y') }}</span>
                </div>
                @endif
            </div>
             <!-- Communication Options -->
                    <div class="flex items-center gap-1 mr-4">
                        @if($client->phone)
                        <!-- WhatsApp -->
                        <div class="relative group inline-block">
                            <a href="{{ $canSeeFullDetails ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $client->phone) : 'javascript:void(0)' }}" 
                               target="{{ $canSeeFullDetails ? '_blank' : '' }}"
                               class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-50 hover:bg-green-100 transition-all duration-200 {{ $canSeeFullDetails ? 'hover:scale-110' : 'opacity-50 cursor-not-allowed' }}">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485"/>
                                </svg>
                            </a>
                            {{-- <span class="absolute left-1/2 -translate-x-1/2 -bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                WhatsApp
                            </span> --}}
                        </div>

                        <!-- Call -->
                        <div class="relative group inline-block">
                            <a href="{{ $canSeeFullDetails ? 'tel:' . $client->phone : 'javascript:void(0)' }}" 
                               class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-50 hover:bg-blue-100 transition-all duration-200 {{ $canSeeFullDetails ? 'hover:scale-110' : 'opacity-50 cursor-not-allowed' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-blue-600">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </a>
                            {{-- <span class="absolute left-1/2 -translate-x-1/2 -bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                Call
                            </span> --}}
                        </div>
                        @endif

                        @if($client->email)
                        <!-- Email -->
                        <div class="relative group inline-block">
                            <a href="{{ $canSeeFullDetails ? 'mailto:' . $client->email : 'javascript:void(0)' }}" 
                               class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-50 hover:bg-red-100 transition-all duration-200 {{ $canSeeFullDetails ? 'hover:scale-110' : 'opacity-50 cursor-not-allowed' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-red-600">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </a>
                            {{-- <span class="absolute left-1/2 -translate-x-1/2 -bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                Email
                            </span> --}}
                        </div>
                        @endif

                        <!-- SMS -->
                        @if($client->phone)
                        <div class="relative group inline-block">
                            <a href="{{ $canSeeFullDetails ? 'sms:' . $client->phone : 'javascript:void(0)' }}" 
                               class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-50 hover:bg-purple-100 transition-all duration-200 {{ $canSeeFullDetails ? 'hover:scale-110' : 'opacity-50 cursor-not-allowed' }}">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </a>
                            {{-- <span class="absolute left-1/2 -translate-x-1/2 -bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                Message
                            </span> --}}
                        </div>
                        @endif
                    </div>
            <div class="pt-3 border-t border-slate-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-slate-500">Lead Source</p>
                        <p class="text-lg font-semibold text-slate-900">{{ $client->source }}</p>
                        <p class="text-xs text-slate-500"> <strong>Notes:</strong> {{ $client->notes }}</p>
                    </div>
                    <div class="mt-1">
                        <button onclick="openNotesModal({{ $client->id }}, '{{ addslashes($client->company_name) }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-md transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Edit Comments
                        </button>
                    </div>
                </div>
            </div>



        <!-- Take Action Button -->
        <!-- Take Action Button -->
@php
    $isClaimed = $client->leadAction && $client->leadAction->status !== 'unlocked';
@endphp

@if($isClaimed)
  <!-- Button disabled if already actioned -->
  <button
    class="block w-full text-center px-4 py-2 text-sm font-medium border border-gray-400 text-gray-400 rounded-lg cursor-not-allowed bg-gray-100"
    disabled>
    Action Taken
  </button>

  <div class="mt-2 px-3 py-1 bg-green-50 border border-green-300 rounded-md text-green-700 text-sm">
    ✅ Action taken by <strong>{{ $client->leadAction->user->name ?? 'Unknown User' }} , &nbsp; {{ \Carbon\Carbon::parse($client->leadAction->created_at)
    ->setTimezone('Asia/Kolkata')
    ->diffForHumans() }}
</strong>
  </div>
  
  @if(auth()->user()->hasRole('admin'))
  <div class="mt-2 text-center">
      <button onclick="unlockLead({{ $client->id }})" class="text-xs text-red-600 hover:text-red-800 font-medium underline decoration-red-300 hover:decoration-red-600 transition-colors">
          Unlock Lead (Re-open for all)
      </button>
  </div>
  @endif

@else
  <!-- Button active if no action yet or if unlocked -->
  <button
    onclick="openActionModal({{ $client->id }})"
    class="block w-full text-center px-4 py-2 text-sm font-medium border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
    Take Action
  </button>

  <div class="mt-2 px-3 py-1 bg-gray-50 border border-gray-300 rounded-md text-gray-600 text-sm">
    @if($client->leadAction && $client->leadAction->status === 'unlocked')
      🔓 Lead unlocked by Admin. Ready to pick up!
    @else
      ⏳ No action taken yet
    @endif
  </div>
@endif




        </div>
    </div>
    @endforeach
</div>

<!-- Client Table View -->
<div id="clients-table-container" class="hidden overflow-x-auto bg-white rounded-lg border border-slate-200 shadow-sm w-full max-w-full relative pb-32">
    <table class="w-full text-sm text-left text-slate-500 min-w-max table-auto">
        <thead class="text-xs text-white uppercase bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 shadow-md">
            <tr>
                <th scope="col" class="px-5 py-4 font-bold tracking-wider whitespace-nowrap rounded-tl-lg">Company</th>
                <th scope="col" class="px-4 py-4 font-bold tracking-wider hidden md:table-cell whitespace-nowrap">Contact</th>
                <!-- <th scope="col" class="px-4 py-4 font-bold tracking-wider whitespace-nowrap">Status</th> -->
                <th scope="col" class="px-4 py-4 font-bold tracking-wider hidden lg:table-cell whitespace-nowrap">Priority</th>
                <th scope="col" class="px-4 py-4 font-bold tracking-wider text-right whitespace-nowrap sticky right-0 bg-indigo-700/90 backdrop-blur-sm z-10 rounded-tr-lg">Actions</th>
            </tr>
        </thead>
        <tbody id="clients-table-body">
            @foreach($clients as $client)
            @php
                $canSeeFullCompanyName = auth()->user()->hasRole('admin');
                
                $canSeeFullDetails = true;
                $isClaimed = false;
                if ($client->leadAction && $client->leadAction->status !== 'unlocked') {
                    $isClaimed = true;
                    $canSeeFullDetails = false;
                    if (auth()->user()->hasRole('admin') || $client->leadAction->user_id == auth()->id()) {
                        $canSeeFullDetails = true;
                    }
                }

                $avatarColors = 'from-blue-100 to-indigo-200 text-blue-700 ring-blue-100';
                if(strtolower($client->priority) == 'high') $avatarColors = 'from-rose-100 to-red-200 text-rose-700 ring-rose-100';
                elseif(strtolower($client->priority) == 'medium') $avatarColors = 'from-amber-100 to-orange-200 text-amber-700 ring-amber-100';
                elseif(strtolower($client->priority) == 'low') $avatarColors = 'from-emerald-100 to-teal-200 text-emerald-700 ring-emerald-100';

                $cStatus = strtolower($client->status ?? '');
                $aStatus = strtolower($client->leadAction->status ?? '');
                $dashboardCategory = 'other';
                if (in_array($cStatus, ['client', 'purchased']) || in_array($aStatus, ['client', 'purchased'])) {
                    $dashboardCategory = 'closed';
                } elseif (in_array($cStatus, ['not interested', 'lost']) || in_array($aStatus, ['not interested', 'lost'])) {
                    $dashboardCategory = 'not_interested';
                } elseif (in_array($cStatus, ['non-contactable', 'not reachable']) || in_array($aStatus, ['non-contactable', 'not reachable'])) {
                    $dashboardCategory = 'non_contactable';
                } elseif (!empty($client->next_follow_up) || !empty($client->leadAction->next_follow_up) || in_array($aStatus, ['will call back', 'interested', 'missed booked'])) {
                    $dashboardCategory = 'follow_up';
                }
            @endphp
            <tr class="client-table-row border-b border-slate-100 hover:bg-slate-50/80 transition-all duration-200 group" data-status="{{ $client->status }}" data-category="{{ $dashboardCategory }}" data-assigned-user="{{ $client->leadAction->user_id ?? '' }}">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3.5">
                        <div class="hidden sm:flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br {{ $avatarColors }} font-bold shadow-sm ring-4">
                            {{ strtoupper(substr(trim($client->company_name), 0, 1)) }}
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="font-semibold text-slate-900 truncate text-xs sm:text-sm uppercase tracking-tight" @if($canSeeFullCompanyName) title="{{ $client->company_name }}" @endif>
                                @if($canSeeFullCompanyName)
                                    {{ $client->company_name }}
                                @else
                                    {{ explode(' ', trim($client->company_name))[0] }} ****
                                @endif
                            </span>
                            <span class="text-[10px] text-slate-500 md:hidden truncate max-w-[120px] mt-0.5">{{ $client->contact_person }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 hidden md:table-cell">
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-medium text-slate-800 truncate flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $client->contact_person }}
                        </span>
                        <span class="text-xs text-slate-500 truncate flex items-center gap-1.5 mt-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $client->email }}
                        </span>
                    </div>
                </td>
                <!-- <td class="px-4 py-4">
                    <span class="status-badge px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold capitalize whitespace-nowrap
                        @if($client->status == 'lead') bg-gray-100 text-gray-700 border-gray-300 border
                        @elseif($client->status == 'qualified') bg-blue-100 text-blue-700 border-blue-300 border
                        @elseif($client->status == 'proposal') bg-purple-100 text-purple-700 border-purple-300 border
                        @elseif($client->status == 'negotiation') bg-yellow-100 text-yellow-700 border-yellow-300 border
                        @elseif($client->status == 'client') bg-green-100 text-green-700 border-green-300 border
                        @else bg-red-100 text-red-700 border-red-300 border @endif">
                        {{ $client->status }}
                    </span>
                </td> -->
                <td class="px-4 py-4 hidden lg:table-cell">
                    <span class="priority-badge px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize
                        @if($client->priority == 'low') bg-green-100 text-green-700
                        @elseif($client->priority == 'medium') bg-yellow-100 text-yellow-700
                        @else bg-orange-100 text-orange-700 @endif">
                        {{ $client->priority }}
                    </span>
                </td>
                <td class="px-4 py-4 text-right sticky right-0 bg-white group-hover:bg-slate-50 transition-colors duration-200 z-10">
                    <div class="flex items-center justify-end gap-2 sm:gap-3">
                        @if(!$isClaimed)
                            <button onclick="openActionModal({{ $client->id }})" class="px-3 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg hover:from-blue-600 hover:to-indigo-600 transition-all shadow-sm hover:shadow hover:-translate-y-0.5 whitespace-nowrap"
                                    data-client-id="{{ $client->id }}"
                                    data-company-name="{{ addslashes($client->company_name) }}">
                                Take Action
                            </button>
                        @else
                            <button class="px-3 py-1.5 text-xs font-medium text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed border border-slate-200 whitespace-nowrap" disabled>
                                Action Taken
                            </button>
                        @endif
                        <a href="{{ $canSeeFullDetails ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $client->phone) : 'javascript:void(0)' }}" target="{{ $canSeeFullDetails ? '_blank' : '' }}" class="p-2 text-white bg-green-500 rounded-full transition-all sm:inline-flex {{ $canSeeFullDetails ? 'hover:bg-green-600 hover:shadow-md hover:scale-110' : 'opacity-50 cursor-not-allowed' }}" title="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485"/></svg>
                        </a>
                        <button onclick="openNotesModal({{ $client->id }}, '{{ addslashes($client->company_name) }}')" class="p-2 text-white bg-indigo-500 rounded-full transition-all sm:inline-flex hover:bg-indigo-600 hover:shadow-md hover:scale-110" title="Edit Comments">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </button>
                        <div class="relative inline-block text-left ">
                            <button 
                                id="toggle-table-client-options-{{ $client->id }}"
                                onclick="toggleDropdown('table-client-options-menu-{{ $client->id }}')" 
                                class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-full transition-all"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </button>
                            <div 
                                id="table-client-options-menu-{{ $client->id }}" 
                                class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 hidden"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="toggle-table-client-options-{{ $client->id }}"
                            >
                                <div class="py-1">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Lead</a>
                                    @if($client->leadAction)
                                    <a href="{{ route('myleads.edit', $client->leadAction->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Taken Action</a>
                                    @endif
                                    @if(auth()->user()->hasRole('admin'))
                                    <button type="button" onclick="openDeleteModal('{{ $client->id }}', '{{ addslashes($client->company_name) }}', '{{ route('clients.destroy', $client->id) }}')" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Delete Client</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </div>
    </div>


    

    <!-- ====================== NOTES / TIMELINE MODAL ====================== -->
    <div id="notesModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full z-50 hidden flex items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        Lead Notes
                    </h3>
                    <p id="notesModalClientName" class="text-xs text-gray-500 mt-0.5 font-medium uppercase"></p>
                </div>
                <button type="button" onclick="closeNotesModal()" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-full p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Timeline Body (Scrollable) -->
            <div id="notesTimelineContainer" class="p-5 overflow-y-auto flex-1 bg-white space-y-4">
                <!-- Notes will be injected here via JS -->
                <div class="flex justify-center py-8">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                </div>
            </div>
            
            <!-- Add Note Form -->
            <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                <form id="addNoteForm" onsubmit="submitNewNote(event)" class="flex gap-2">
                    <input type="hidden" id="noteClientId" value="">
                    <div class="relative flex-1">
                        <input type="text" id="newNoteText" placeholder="Add a comment..." required
                            class="w-full pl-4 pr-12 py-2.5 bg-white border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                        <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 p-1.5 px-3 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 translate-x-px translate-y-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ====================== END NOTES MODAL ====================== -->

            <!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-4 w-full max-w-md">
        <div class="relative bg-white rounded-lg shadow-xl">
            <!-- Modal Header -->
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900">
                    Confirm Delete
                </h3>
                <button type="button" onclick="closeDeleteModal()"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm sm:text-base font-medium text-gray-900">Delete Client/Lead</p>
                        <p class="text-sm text-gray-500 mt-1">This action cannot be undone.</p>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-2">You are about to delete: <span id="clientToDeleteName" class="font-semibold text-gray-900"></span></p>
                <p class="text-xs text-gray-500">All client data will be permanently removed from the system.</p>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-end p-6 border-t border-gray-200 space-y-3 sm:space-y-0 sm:space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="w-full sm:w-auto px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        Delete Client
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



    {{-- take action form --}}
    <!-- Take Action Modal -->
<!-- ====================== MODAL ====================== -->
  <div id="actionModal" style="z-index: 9999;"
       class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-[100] p-4 sm:p-6 transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.5)] w-full max-w-lg relative flex flex-col max-h-[90vh] border border-white/40 ring-1 ring-slate-900/5">
      
      <!-- Premium Header -->
      <div class="px-8 py-6 border-b border-slate-100/80 flex justify-between items-center bg-white/90 backdrop-blur-md rounded-t-3xl sticky top-0 z-10">
          <div class="flex items-center gap-3.5">
              <div class="w-11 h-11 rounded-2xl bg-indigo-50/80 flex items-center justify-center border border-indigo-100/50 text-indigo-600 shadow-sm">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
              </div>
              <div>
                  <h3 class="text-lg font-bold text-slate-900 tracking-tight">Submit Response</h3>
                  <p class="text-xs text-slate-500 mt-0.5 font-medium">Record feedback & plan next steps</p>
              </div>
          </div>
          <button id="closeModal" class="text-slate-400 hover:text-slate-700 hover:bg-slate-100 p-2.5 rounded-full transition-all duration-200">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
      </div>

      <!-- Form Body -->
      <div class="px-8 py-7 overflow-y-auto custom-scrollbar">
          <form id="actionForm" method="POST" action="{{ route('myleads.store') }}" class="space-y-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="client_id" id="client_id">

            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Response / Feedback</label>
                <textarea name="response" rows="3"
                          class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-3.5 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all duration-200 outline-none resize-none placeholder-slate-400"
                          placeholder="What did you discuss? What are the next steps?"
                          required></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Next Follow-Up</label>
                    <div class="relative">
                        <input type="date" name="next_follow_up"
                               class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-3.5 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all duration-200 outline-none">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Time</label>
                    <div class="relative">
                        <input type="time" name="follow_up_time"
                               class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-3.5 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all duration-200 outline-none">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Project Type</label>
                    <div class="relative group">
                        <select name="project_type" id="project_type_select" onchange="toggleOtherProjectInput(this)" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-3.5 pr-10 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all duration-200 outline-none appearance-none cursor-pointer">
                            <option value="">-- Select Type --</option>
                            <option value="web_development">Web Development</option>
                            <option value="mobile_app">Mobile App</option>
                            <option value="ecommerce">E-commerce</option>
                            <option value="ui_ux_design">UI/UX Design</option>
                            <option value="digital_marketing">Digital Marketing</option>
                            <option value="seo">SEO</option>
                            <option value="custom_software">Custom Software</option>
                            <option value="other">Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Lead Status</label>
                    <div class="relative group">
                        <select name="status" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-3.5 pr-10 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all duration-200 outline-none appearance-none cursor-pointer">
                            <option value="">-- Select Status --</option>
                            <option value="lead">Lead</option>
                            <option value="follow up">Follow Up</option>
                            <option value="closed">Closed</option>
                            <option value="not interested">Not Interested</option>
                            <option value="non-contactable">Non-contactable</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-1.5 hidden" id="other_project_type_container">
                <label for="other_project_type" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Specify Project Type</label>
                <input type="text" name="other_project_type" id="other_project_type" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-3.5 text-sm text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all duration-200 outline-none" placeholder="Please specify details...">
            </div>

            <div class="pt-4 pb-2">
                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 bg-[length:200%_auto] hover:bg-right text-white font-semibold py-4 rounded-xl shadow-[0_8px_20px_-6px_rgba(79,70,229,0.5)] hover:shadow-[0_12px_25px_-8px_rgba(79,70,229,0.6)] hover:-translate-y-0.5 transition-all duration-500 flex items-center justify-center gap-2">
                    <span class="tracking-wide">Save Response</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- ====================== END MODAL ====================== -->
  {{-- take action form --}}
  
  
  
  <!-- ====================== EDIT LEAD MODAL ====================== -->
  <!-- Edit Action Modal -->
<div id="editActionModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 relative">
        <button id="closeEditModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl">
            &times;
        </button>

        <h3 class="text-lg font-semibold mb-4 text-gray-800">Edit Lead Response</h3>

        <form id="editActionForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="action_id" id="edit_action_id">

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Response / Feedback</label>
                <textarea name="response" id="edit_response" rows="3"
                          class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200"
                          required></textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Next Follow-Up Date</label>
                <input type="date" name="next_follow_up" id="edit_next_follow_up"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lead Status</label>
                <select name="status" id="edit_status" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                    <option value="lead">Lead</option>
                    <option value="follow up">Follow Up</option>
                    <option value="closed">Closed</option>
                    <option value="not interested">Not Interested</option>
                    <option value="non-contactable">Non-contactable</option>
                </select>
            </div>

            <button type="submit"
                    class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition-all">
                Update Response
            </button>
        </form>
    </div>
</div>
  <!-- ====================== END EDIT LEAD MODAL ====================== -->





    <!-- Edit Client Modal -->
    <div id="client-modal" class="fixed inset-0 flex items-center justify-center z-50 bg-black/40 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
            
            <!-- Close Button -->
            <button type="button" id="close-modal" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Header -->
            <div class="mb-6 text-center sm:text-left">
                <h2 id="modal-title" class="text-2xl font-bold text-gray-800">Edit Client</h2>
            </div>

            <!-- Form -->
            <form id="client-form" class="space-y-6">
                @csrf
                <input type="hidden" id="client_id" name="client_id">
                
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Company Name -->
                    <div class="space-y-2">
                        <label for="company_name" class="text-sm font-medium text-gray-700">Company Name *</label>
                        <input id="company_name" name="company_name" type="text" required
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <!-- Contact Person -->
                    <div class="space-y-2">
                        <label for="contact_person" class="text-sm font-medium text-gray-700">
                            Contact Person *
                        </label>
                        <input
                            id="contact_person"
                            name="contact_person"
                            type="text"
                            required
                            minlength="3"
                            pattern="[A-Za-z ]+"
                            placeholder="Enter full name"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        />
                    </div>


                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-gray-700">Email *</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                            placeholder="example@gmail.com"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        />
                    </div>


                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-medium text-gray-700">Phone</label>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            minlength="10"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            required
                            placeholder="Enter 10-digit number"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        />
                    </div>


                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="lead">Lead</option>
                            <option value="follow up">Follow Up</option>
                            <option value="closed">Closed</option>
                            <option value="not interested">Not Interested</option>
                            <option value="non-contactable">Non-contactable</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div class="space-y-2">
                        <label for="priority" class="text-sm font-medium text-gray-700">Priority</label>
                        <select id="priority" name="priority"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <!-- Industry -->
                    <div class="space-y-2">
                        <label for="industry" class="text-sm font-medium text-gray-700">Industry</label>
                        <input id="industry" name="industry" type="text"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <!-- Budget -->
                    {{-- <div class="space-y-2">
                        <label for="budget" class="text-sm font-medium text-gray-700">Monthly Budget (₹)</label>
                        <input id="budget" name="budget" type="number" step="0.01"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div> --}}

                    <!-- Lead Source -->
                    <div class="space-y-2">
                        <label for="source" class="text-sm font-medium text-gray-700">Lead Source</label>
                        <select id="source" name="source"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="website">Website</option>
                            <option value="referral">Referral</option>
                            <option value="cold_outreach">Cold Outreach</option>
                            <option value="social_media">Social Media</option>
                            <option value="event">Event</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Next Follow-up -->
                    {{-- <div class="space-y-2">
                        <label for="next_follow_up" class="text-sm font-medium text-gray-700">Next Follow-up</label>
                        <input id="next_follow_up" name="next_follow_up" type="date"
                            class="w-full h-10 px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div> --}}
                </div>

                <!-- Notes -->
                <div class="space-y-2">
                    <label for="notes" class="text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full min-h-[80px] px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" id="cancel-btn"
                        class="px-4 py-2 border rounded-md text-sm font-medium hover:bg-gray-100 focus:ring-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" id="submit-btn"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                        Update Client
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Toast -->
    <div id="success-toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50 hidden">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            <span id="toast-message">Operation completed successfully!</span>
        </div>
    </div>

    


{{-- @section('scripts') --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('client-modal');
    const closeModalBtn = document.getElementById('close-modal');
    const cancelBtn = document.getElementById('cancel-btn');
    const addClientBtn = document.getElementById('add-client-btn');
    const modalTitle = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');
    const clientForm = document.getElementById('client-form');
    const searchInput = document.getElementById('search-input');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const clientsContainer = document.getElementById('clients-container');
    const clientsTableContainer = document.getElementById('clients-table-container');
    const gridViewBtn = document.getElementById('grid-view-btn');
    const tableViewBtn = document.getElementById('table-view-btn');
    const successToast = document.getElementById('success-toast');
    const toastMessage = document.getElementById('toast-message');

    let currentFilter = 'all';
    let currentSearch = '';
    let currentView = 'grid';

    // View switching functionality
    function switchView(view) {
        currentView = view;
        if (view === 'grid') {
            if (clientsContainer) clientsContainer.classList.remove('hidden');
            if (clientsTableContainer) clientsTableContainer.classList.add('hidden');
            if (gridViewBtn) gridViewBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'shadow-sm');
            if (tableViewBtn) {
                tableViewBtn.classList.remove('bg-indigo-50', 'text-indigo-600', 'shadow-sm');
                tableViewBtn.classList.add('text-slate-400');
            }
        } else {
            if (clientsContainer) clientsContainer.classList.add('hidden');
            if (clientsTableContainer) clientsTableContainer.classList.remove('hidden');
            if (tableViewBtn) tableViewBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'shadow-sm');
            if (gridViewBtn) {
                gridViewBtn.classList.remove('bg-indigo-50', 'text-indigo-600', 'shadow-sm');
                gridViewBtn.classList.add('text-slate-400');
            }
        }
        filterClients(); // Re-apply filter to new view
    }

    if (gridViewBtn) gridViewBtn.addEventListener('click', () => switchView('grid'));
    if (tableViewBtn) tableViewBtn.addEventListener('click', () => switchView('table'));

    // Show toast notification
    function showToast(message) {
        toastMessage.textContent = message;
        successToast.classList.remove('hidden');
        successToast.classList.remove('translate-x-full');
        
        setTimeout(() => {
            hideToast();
        }, 3000);
    }

    function hideToast() {
        successToast.classList.add('translate-x-full');
        setTimeout(() => {
            successToast.classList.add('hidden');
        }, 300);
    }

    // Filter and search clients
    function filterClients() {
        const searchTerm = currentSearch.toLowerCase();
        const currentUserId = "{{ auth()->id() }}";
        const isUserDashboard = currentFilter.startsWith('my_');
        const actualFilter = isUserDashboard ? currentFilter.replace('my_', '') : currentFilter;
        
        // Filter Grid View
        const clientCards = document.querySelectorAll('.client-card');
        clientCards.forEach(card => {
            const clientText = card.textContent.toLowerCase();
            const clientStatus = card.getAttribute('data-status');
            const clientCategory = card.getAttribute('data-category');
            const assignedUserId = card.getAttribute('data-assigned-user');

            const matchesSearch = clientText.includes(searchTerm);
            const matchesFilter = actualFilter === 'all' || clientStatus === actualFilter || clientCategory === actualFilter;
            const matchesUser = !isUserDashboard || (assignedUserId === currentUserId);

            card.style.display = (matchesSearch && matchesFilter && matchesUser) ? 'block' : 'none';
        });

        // Filter Table View
        const clientTableRows = document.querySelectorAll('.client-table-row');
        clientTableRows.forEach(row => {
            const clientText = row.textContent.toLowerCase();
            const clientStatus = row.getAttribute('data-status');
            const clientCategory = row.getAttribute('data-category');
            const assignedUserId = row.getAttribute('data-assigned-user');

            const matchesSearch = clientText.includes(searchTerm);
            const matchesFilter = actualFilter === 'all' || clientStatus === actualFilter || clientCategory === actualFilter;
            const matchesUser = !isUserDashboard || (assignedUserId === currentUserId);

            row.style.display = (matchesSearch && matchesFilter && matchesUser) ? 'table-row' : 'none';
        });
    }

    window.setDashboardFilter = function(filterValue, element) {
        // Update active state of dashboard cards
        document.querySelectorAll('.filter-dashboard-card').forEach(card => {
            card.classList.remove('active-dashboard-card');
        });
        if(element) element.classList.add('active-dashboard-card');
        
        // Clear standard filters visually
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active', 'bg-indigo-600', 'text-white', 'shadow-sm', 'hover:bg-indigo-700');
            b.classList.add('bg-white', 'text-slate-600', 'hover:bg-slate-50');
        });

        currentFilter = filterValue;
        filterClients();
    };

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value;
            filterClients();
        });
    }

    // Filter functionality
    if (filterBtns) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-indigo-600', 'text-white', 'shadow-sm', 'hover:bg-indigo-700');
                    b.classList.add('bg-white', 'text-slate-600', 'hover:bg-slate-50');
                });
                
                this.classList.remove('bg-white', 'text-slate-600', 'hover:bg-slate-50');
                this.classList.add('active', 'bg-indigo-600', 'text-white', 'shadow-sm', 'hover:bg-indigo-700');
                
                currentFilter = this.getAttribute('data-status');
                filterClients();
            });
        });
    }

    // Open modal for editing client
    // Use event delegation on document (works for dynamic elements)


    // Open modal for adding new client
    if (addClientBtn) {
        addClientBtn.addEventListener('click', function() {
            // Clear form
            if (clientForm) clientForm.reset();
            const clientIdField = document.getElementById('client_id');
            if (clientIdField) clientIdField.value = '';
            
            // Update modal title and submit button
            if (modalTitle) modalTitle.textContent = 'Add New Client';
            if (submitBtn) submitBtn.textContent = 'Add Client';
            
            // Show modal
            if (modal) modal.classList.remove('hidden');
        });
    }

    // Close modal
    function closeModal() {
        if (modal) modal.classList.add('hidden');
    }

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    // Form submission
    if (clientForm) {
        clientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const clientId = formData.get('client_id');
            const isEditing = clientId !== '';
            
            const url = isEditing ? `/clients/${clientId}` : '/clients';
            
            // Always send as POST, spoof PUT if editing
            if (isEditing) {
                formData.append('_method', 'PUT');
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    closeModal();
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let msg = 'Operation failed';
                if (error.errors) {
                    msg = Object.values(error.errors).flat().join(', ');
                } else if (error.message) {
                    msg = error.message;
                }
                showToast('Error: ' + msg);
            });
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const importBtn = document.getElementById('import-client-btn');
    const importModal = document.getElementById('import-modal');
    const closeImportModal = document.getElementById('close-import-modal');
    const cancelImport = document.getElementById('cancel-import');
    const importForm = document.getElementById('import-form');
    const submitImport = document.getElementById('submit-import');
    const importSpinner = document.getElementById('import-spinner');

    // Open import modal
    importBtn.addEventListener('click', function() {
        importModal.classList.remove('hidden');
    });

    // Close import modal
    [closeImportModal, cancelImport].forEach(btn => {
        btn.addEventListener('click', function() {
            importModal.classList.add('hidden');
            importForm.reset();
        });
    });

    // Handle form submission
    importForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const fileInput = document.getElementById('excel_file');
        
        if (!fileInput.files[0]) {
            alert('Please select a file to import.');
            return;
        }

        // Show loading state
        submitImport.disabled = true;
        importSpinner.classList.remove('hidden');
        submitImport.innerHTML = 'Importing...';

        fetch('{{ route("clients.import") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let message = `Successfully imported ${data.imported_count} clients.`;
                if (data.skipped_count > 0) {
                    message += ` ${data.skipped_count} rows were skipped.`;
                    if (data.skipped_rows.length > 0) {
                        message += '\n\nSkipped rows:\n' + data.skipped_rows.join('\n');
                    }
                }
                alert(message);
                importModal.classList.add('hidden');
                importForm.reset();
                location.reload(); // Refresh to show new data
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while importing the file.');
        })
        .finally(() => {
            // Reset button state
            submitImport.disabled = false;
            importSpinner.classList.add('hidden');
            submitImport.innerHTML = 'Import Clients';
        });
    });
});
</script>




<!-- ====================== SCRIPT ====================== -->
  <script>
    const modal   = document.getElementById('actionModal');
    const closeBtn = document.getElementById('closeModal');

    // Public function – call it from any "Take Action" button
    window.openActionModal = function (clientId) {
      document.getElementById('client_id').value = clientId;
      modal.classList.remove('hidden');
      modal.classList.add('flex');           // makes the overlay visible & centered
    };

    // Close button
    closeBtn.addEventListener('click', () => closeModal());

    // Click outside the white box
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal();
    });

    // ESC key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    function closeModal() {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      // optional: reset form
      document.getElementById('actionForm').reset();
      document.getElementById('client_id').value = '';
      
      // Reset project type field
      const otherInputContainer = document.getElementById('other_project_type_container');
      if(otherInputContainer) {
          otherInputContainer.classList.add('hidden');
      }
    }

    // Toggle Other Project Type Input
    window.toggleOtherProjectInput = function(selectElement) {
        const otherInputContainer = document.getElementById('other_project_type_container');
        if (selectElement.value === 'other') {
            otherInputContainer.classList.remove('hidden');
        } else {
            otherInputContainer.classList.add('hidden');
            document.getElementById('other_project_type').value = ''; // Clear input
        }
    };
  </script>
  <!-- ====================== END SCRIPT ====================== -->



  <script>
    // Toggle dropdown for specific client (handles both grid and table views)
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        
        // Close all other menus and reset their z-indexes
        document.querySelectorAll('[id*="client-options-menu-"]').forEach(m => {
            if (m.id !== menuId) {
                m.classList.add('hidden');
                // Reset z-index of the parent container (td for table, .client-card for grid)
                const container = m.closest('td') || m.closest('.client-card');
                if (container) {
                    container.style.zIndex = '';
                    container.style.position = '';
                }
            }
        });

        // Toggle this one
        if (menu) {
            const isHidden = menu.classList.toggle('hidden');
            const container = menu.closest('td') || menu.closest('.client-card');
            
            if (container) {
                if (!isHidden) {
                    // When opening, bring this row/card to front
                    container.style.zIndex = '60';
                    // Ensure it has relative positioning if not already sticky
                    if (window.getComputedStyle(container).position === 'static') {
                        container.style.position = 'relative';
                    }
                } else {
                    // When closing, reset z-index
                    container.style.zIndex = '';
                    container.style.position = '';
                }
            }
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        document.querySelectorAll('[id*="client-options-menu-"]').forEach(menu => {
            const buttonId = menu.getAttribute('aria-labelledby');
            const button = document.getElementById(buttonId);
            
            if (button && !button.contains(event.target) && !menu.contains(event.target)) {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    const container = menu.closest('td') || menu.closest('.client-card');
                    if (container) {
                        container.style.zIndex = '';
                        container.style.position = '';
                    }
                }
            }
        });
    });
</script>



<script>
    // Edit Action Functionality
document.addEventListener('DOMContentLoaded', function() {
    const editActionModal = document.getElementById('editActionModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const editActionForm = document.getElementById('editActionForm');

    // Event delegation for edit action buttons
    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-action-btn');
        if (!editBtn) return;

        e.preventDefault();
        const actionId = editBtn.getAttribute('data-action-id');
        openEditActionModal(actionId);
    });

    // Open edit action modal
    window.openEditActionModal = function(actionId) {
        fetch(`/myleads/${actionId}/edit`)
            .then(response => {
                if (!response.ok) throw new Error('Action not found');
                return response.json();
            })
            .then(action => {
                // Populate form with existing data
                document.getElementById('edit_action_id').value = action.id;
                document.getElementById('edit_response').value = action.response || '';
                document.getElementById('edit_next_follow_up').value = action.next_follow_up || '';
                document.getElementById('edit_status').value = action.status || 'interested';

                // Set form action
                editActionForm.action = `/myleads/${action.id}`;

                // Show modal
                editActionModal.classList.remove('hidden');
                editActionModal.classList.add('flex');
            })
            .catch(err => {
                console.error('Error:', err);
                showToast('Failed to load action data');
            });
    };

    // Close edit modal
    if (closeEditModal) {
        closeEditModal.addEventListener('click', closeEditActionModal);
    }

    // Click outside to close
    if (editActionModal) {
        editActionModal.addEventListener('click', (e) => {
            if (e.target === editActionModal) closeEditActionModal();
        });
    }

    // ESC key to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && editActionModal && !editActionModal.classList.contains('hidden')) {
            closeEditActionModal();
        }
    });

    function closeEditActionModal() {
        if (editActionModal) {
            editActionModal.classList.add('hidden');
            editActionModal.classList.remove('flex');
        }
        if (editActionForm) {
            editActionForm.reset();
        }
    }

    // Handle edit form submission
    if (editActionForm) {
        editActionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const actionId = document.getElementById('edit_action_id').value;

            fetch(this.action, {
                method: 'POST', // Laravel will handle PUT via _method
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    closeEditActionModal();
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let msg = 'Update failed';
                if (error.errors) {
                    msg = Object.values(error.errors).flat().join(', ');
                } else if (error.message) {
                    msg = error.message;
                }
                showToast('Error: ' + msg);
            });
        });
    }
});
</script>


<script>
    // Delete Modal Functions
function openDeleteModal(clientId, clientName, deleteUrl) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const clientNameSpan = document.getElementById('clientToDeleteName');
    
    // Set the client name in the modal
    clientNameSpan.textContent = clientName;
    
    // Update the form action with the correct URL
    form.action = deleteUrl;
    
    // Show the modal
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    
    // Hide the modal
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Handle delete form submission
// Update your delete form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const deleteUrl = form.action;
            const clientId = deleteUrl.split('/').pop(); // Extract ID from URL
            
            console.log('Delete URL:', deleteUrl);
            console.log('Extracted Client ID:', clientId);
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Deleting...';
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Create FormData
            const formData = new FormData(form);
            
            fetch(deleteUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    return response.json().then(err => { 
                        console.error('Server error response:', err);
                        throw new Error(err.message || `Server error: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Delete success response:', data);
                
                if (data.success) {
                    // Show success message
                    showToast('Client deleted successfully!');
                    closeDeleteModal();
                    
                    // Remove the deleted card from DOM
                    setTimeout(() => {
                        const clientCard = document.querySelector(`.client-card[data-client-id="${clientId}"]`);
                        if (clientCard) {
                            clientCard.style.transition = 'all 0.3s ease';
                            clientCard.style.opacity = '0';
                            clientCard.style.transform = 'translateX(-100%)';
                            clientCard.style.height = '0';
                            clientCard.style.margin = '0';
                            clientCard.style.padding = '0';
                            clientCard.style.border = '0';
                            clientCard.style.overflow = 'hidden';
                            
                            setTimeout(() => {
                                clientCard.remove();
                                // Check if no clients left
                                const remainingCards = document.querySelectorAll('.client-card');
                                if (remainingCards.length === 0) {
                                    console.log('No clients left, reloading page...');
                                    location.reload();
                                }
                            }, 300);
                        } else {
                            console.log('Client card not found in DOM, reloading page...');
                            location.reload();
                        }
                    }, 500);
                } else {
                    throw new Error(data.message || 'Delete failed');
                }
            })
            .catch(error => {
                console.error('Delete error details:', error);
                
                // Check if it's a 404 error (client not found)
                if (error.message.includes('No query results') || error.message.includes('not found')) {
                    // showToast('Client not found or already deleted.', 'error');
                    // Remove the card anyway since it doesn't exist
                    const clientCard = document.querySelector(`.client-card[data-client-id="${clientId}"]`);
                    if (clientCard) {
                        clientCard.remove();
                    }
                } else {
                    showToast('Error: ' + error.message, 'error');
                }
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.textContent = 'Delete Client';
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        });
    }
});

// Close delete modal when clicking outside
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target.id === 'deleteModal') {
        closeDeleteModal();
    }
});

// Close delete modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const deleteModal = document.getElementById('deleteModal');
        if (!deleteModal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});

// Updated showToast function that works for both success and error
function showToast(message, type = 'success') {
    // Create or get toast element
    let toast = document.getElementById('global-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'global-toast';
        toast.className = 'fixed top-4 right-4 z-[100] px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300';
        document.body.appendChild(toast);
    }
    
    // Set color based on type
    toast.className = toast.className.replace('bg-red-500', '').replace('bg-green-500', '');
    toast.className += type === 'success' ? ' bg-green-500 text-white' : ' bg-red-500 text-white';
    
    // Set message with icon
    const icon = type === 'success' ? 
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>' :
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
    
    toast.innerHTML = `<div class="flex items-center">${icon}${message}</div>`;
    
    // Show toast
    toast.classList.remove('translate-x-full');
    
    // Auto-hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
    }, 3000);
}
</script>


<style>
    /* Delete Modal Styles */
#deleteModal {
    transition: opacity 0.3s ease;
}

#deleteModal > div {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Prevent body scrolling when modal is open */
body.overflow-hidden {
    overflow: hidden;
}
</style>

<script>
    // Handle delete form submission
document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Deleting...';
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast(data.message);
            closeDeleteModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            throw new Error(data.message || 'Delete failed');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        let errorMsg = 'Error deleting client';
        if (error.message) {
            errorMsg = error.message;
        } else if (error.errors) {
            errorMsg = Object.values(error.errors).flat().join(', ');
        }
        showToast('Error: ' + errorMsg);
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<style>
.word-break {
    word-break: break-word;
}
@keyframes fade-in-up {
    0% {
        opacity: 0;
        transform: translateY(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-up {
    animation: fade-in-up 0.3s ease-out forwards;
}
</style>

<script>
    // Notes Modal Logic
    const notesModal = document.getElementById('notesModal');
    const notesTimelineContainer = document.getElementById('notesTimelineContainer');
    const addNoteForm = document.getElementById('addNoteForm');
    const noteClientId = document.getElementById('noteClientId');
    const newNoteText = document.getElementById('newNoteText');
    const notesModalClientName = document.getElementById('notesModalClientName');

    function openNotesModal(clientId, clientName) {
        notesModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        noteClientId.value = clientId;
        notesModalClientName.textContent = clientName;
        newNoteText.value = '';
        
        // Show loader
        notesTimelineContainer.innerHTML = '<div class="flex justify-center py-8"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div></div>';
        
        // Fetch notes via AJAX
        fetch(`/clients/${clientId}/notes`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderNotes(data.notes);
                } else {
                    notesTimelineContainer.innerHTML = '<p class="text-center text-red-500 text-sm">Failed to load notes.</p>';
                }
            })
            .catch(err => {
                console.error(err);
                notesTimelineContainer.innerHTML = '<p class="text-center text-red-500 text-sm">Error loading notes.</p>';
            });
    }

    function closeNotesModal() {
        notesModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function renderNotes(notes) {
        if (!notes || notes.length === 0) {
            notesTimelineContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mb-3 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
                    <p class="text-sm font-medium">No notes yet</p>
                    <p class="text-xs mt-1">Be the first to add a comment.</p>
                </div>`;
            return;
        }

        let html = '';
        notes.forEach(note => {
            const isMe = note.user_name === '{{ auth()->user()->name }}'; // simplistic check
            
            html += `
            <div class="flex gap-3 ${isMe ? 'flex-row-reverse' : ''} mb-4">
                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-sm">
                    ${note.user_name.charAt(0).toUpperCase()}
                </div>
                <div class="flex flex-col ${isMe ? 'items-end' : 'items-start'} max-w-[80%]">
                    <div class="flex items-baseline gap-2 mb-1 ${isMe ? 'flex-row-reverse' : ''}">
                        <span class="text-xs font-semibold text-gray-700">${note.user_name}</span>
                        <span class="text-[10px] text-gray-400">${note.created_at}</span>
                    </div>
                    <div class="px-3 py-2 rounded-2xl text-sm ${isMe ? 'bg-indigo-600 text-white rounded-tr-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm'} shadow-sm whitespace-pre-wrap word-break">${note.response}</div>
                </div>
            </div>`;
        });
        
        notesTimelineContainer.innerHTML = html;
        // Scroll to bottom
        setTimeout(() => {
            notesTimelineContainer.scrollTop = notesTimelineContainer.scrollHeight;
        }, 10);
    }

    function submitNewNote(e) {
        e.preventDefault();
        const clientId = noteClientId.value;
        const note = newNoteText.value.trim();
        if (!note) return;
        
        const submitBtn = addNoteForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        
        fetch(`/clients/${clientId}/notes`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ note: note })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove empty state if present
                if (notesTimelineContainer.querySelector('.text-gray-400')) {
                    notesTimelineContainer.innerHTML = '';
                }
                
                // Append new note
                const noteHtml = `
                <div class="flex gap-3 flex-row-reverse mb-4 animate-fade-in-up">
                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-sm">
                        ${data.note.user_name.charAt(0).toUpperCase()}
                    </div>
                    <div class="flex flex-col items-end max-w-[80%]">
                        <div class="flex items-baseline gap-2 mb-1 flex-row-reverse">
                            <span class="text-xs font-semibold text-gray-700">${data.note.user_name}</span>
                            <span class="text-[10px] text-gray-400">${data.note.created_at}</span>
                        </div>
                        <div class="px-3 py-2 rounded-2xl text-sm bg-indigo-600 text-white rounded-tr-sm shadow-sm whitespace-pre-wrap word-break">${data.note.response}</div>
                    </div>
                </div>`;
                
                notesTimelineContainer.insertAdjacentHTML('beforeend', noteHtml);
                setTimeout(() => {
                    notesTimelineContainer.scrollTop = notesTimelineContainer.scrollHeight;
                }, 10);
                
                newNoteText.value = '';
                showToast('Note added successfully');
            } else {
                showToast('Failed to add note', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Error adding note', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-4 h-4 translate-x-px translate-y-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
        });
    }

    function unlockLead(clientId) {
        if (!confirm('Are you sure you want to unlock this lead? It will become available for anyone to pick up again.')) {
            return;
        }

        fetch(`/clients/${clientId}/unlock`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Lead unlocked successfully!');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'Failed to unlock lead', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Error unlocking lead', 'error');
        });
    }
</script>
@endsection