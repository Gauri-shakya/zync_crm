@extends('components.layout')

@section('content')
<div class="min-h-screen bg-gray-50 py-2 xs:py-3 sm:py-4 md:py-6 lg:py-8 overflow-x-hidden">
    <div class="max-w-full xs:max-w-full sm:max-w-full md:max-w-6xl mx-auto px-2 xs:px-3 sm:px-4 md:px-6 lg:px-8">
        <!-- Title moved to container header -->
        
        @php
            $myTotalLeadsCount = 0;
            $myFollowUpCount = 0;
            $myClosedCount = 0;
            $myNotInterestedCount = 0;
            $myNonContactableCount = 0;
            
            $myClosedCount = \App\Models\ClosedLead::where('user_id', auth()->id())->count();
            
            // Get all leads for the current user to show accurate overall stats
            $allMyLeads = \App\Models\Mylead::where('user_id', auth()->id())->get();

            foreach($allMyLeads as $c) {
                $myTotalLeadsCount++;
                $cStatus = strtolower($c->status ?? '');
                
                if (in_array($cStatus, ['not interested', 'lost'])) {
                    $myNotInterestedCount++;
                } elseif (in_array($cStatus, ['non-contactable', 'not reachable'])) {
                    $myNonContactableCount++;
                } elseif (!empty($c->next_follow_up) || in_array($cStatus, ['will call back', 'interested', 'missed booked', 'proposal', 'negotiating'])) {
                    $myFollowUpCount++;
                }
            }
        @endphp

        <!-- Dashboard Overview & Filters Container -->
        <div class="mb-6 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            
            <!-- Header -->
            <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg sm:text-xl font-bold text-slate-800 flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    My Leads Overview
                </h3>
            </div>

            <div class="p-5">
                <!-- Dashboard Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                    
                    <!-- My Total Leads -->
                    <a href="{{ route('myleads') }}" class="block h-full">
                        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-[0_2px_12px_-3px_rgba(0,0,0,0.08)] hover:border-blue-300 hover:shadow-[0_4px_16px_-4px_rgba(0,0,0,0.12)] transition-all group relative overflow-hidden h-full">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider group-hover:text-blue-600 transition-colors">My Total Leads</span>
                                <div class="w-8 h-8 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight truncate" title="{{ $myTotalLeadsCount }}">
                                {{ $myTotalLeadsCount >= 1000 ? number_format($myTotalLeadsCount) : $myTotalLeadsCount }}
                            </div>
                        </div>
                    </a>

                    <!-- My Follow Up -->
                    <a href="{{ route('myleads', ['status' => 'follow up']) }}" class="block h-full">
                        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-[0_2px_12px_-3px_rgba(0,0,0,0.08)] hover:border-indigo-300 hover:shadow-[0_4px_16px_-4px_rgba(0,0,0,0.12)] transition-all group relative overflow-hidden h-full">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-indigo-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider group-hover:text-indigo-600 transition-colors">My Follow Up</span>
                                <div class="w-8 h-8 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight truncate" title="{{ $myFollowUpCount }}">
                                {{ $myFollowUpCount >= 1000 ? number_format($myFollowUpCount) : $myFollowUpCount }}
                            </div>
                        </div>
                    </a>

                    <!-- My Closed -->
                    <a href="{{ route('myleads.closed') }}" class="block">
                        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-[0_2px_12px_-3px_rgba(0,0,0,0.08)] hover:border-teal-300 hover:shadow-[0_4px_16px_-4px_rgba(0,0,0,0.12)] transition-all group relative overflow-hidden h-full">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-teal-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider group-hover:text-teal-600 transition-colors">My Closed</span>
                                <div class="w-8 h-8 rounded-md bg-teal-100 text-teal-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight truncate" title="{{ $myClosedCount }}">
                                {{ $myClosedCount >= 1000 ? number_format($myClosedCount) : $myClosedCount }}
                            </div>
                        </div>
                    </a>


                    <a href="{{ route('myleads', ['status' => 'not interested']) }}" class="block h-full">
                        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-[0_2px_12px_-3px_rgba(0,0,0,0.08)] hover:border-rose-300 hover:shadow-[0_4px_16px_-4px_rgba(0,0,0,0.12)] transition-all group relative overflow-hidden h-full">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-rose-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider group-hover:text-rose-600 transition-colors">Not Interest</span>
                                <div class="w-8 h-8 rounded-md bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight truncate" title="{{ $myNotInterestedCount }}">
                                {{ $myNotInterestedCount >= 1000 ? number_format($myNotInterestedCount) : $myNotInterestedCount }}
                            </div>
                        </div>
                    </a>

                    <!-- Non-Contactable -->
                    <a href="{{ route('myleads', ['status' => 'non-contactable']) }}" class="block h-full">
                        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-[0_2px_12px_-3px_rgba(0,0,0,0.08)] hover:border-orange-300 hover:shadow-[0_4px_16px_-4px_rgba(0,0,0,0.12)] transition-all group relative overflow-hidden h-full">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-orange-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider group-hover:text-orange-600 transition-colors">Non-Contact</span>
                                <div class="w-8 h-8 rounded-md bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight truncate" title="{{ $myNonContactableCount }}">
                                {{ $myNonContactableCount >= 1000 ? number_format($myNonContactableCount) : $myNonContactableCount }}
                            </div>
                        </div>
                    </a>

                </div>

                <!-- Filter Section -->
                <form action="{{ route('myleads') }}" method="GET" class="border-t border-slate-100 pt-5">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <h4 class="text-sm font-semibold text-slate-600">Filter Leads</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                        <!-- Client Name Search -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <input type="text" name="client_name" id="client_name" value="{{ request('client_name') }}" 
                                       placeholder="Company / Contact"
                                       class="block w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 hover:bg-white transition-all placeholder-slate-400 outline-none">
                            </div>
                        </div>

                        <!-- Response Search -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                                <input type="text" name="response" id="response" value="{{ request('response') }}" 
                                       placeholder="Search Response"
                                       class="block w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 hover:bg-white transition-all placeholder-slate-400 outline-none">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <div class="relative">
                                <select name="status" id="status" class="block w-full pl-3 pr-8 py-2 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 hover:bg-white transition-all appearance-none outline-none font-medium cursor-pointer">
                                    <option value="">Lead (All)</option>
                                    <option value="follow up" {{ request('status') == 'follow up' ? 'selected' : '' }}>Follow Up</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="not interested" {{ request('status') == 'not interested' ? 'selected' : '' }}>Not Interested</option>
                                    <option value="non-contactable" {{ request('status') == 'non-contactable' ? 'selected' : '' }}>Non-contactable</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Project Type Filter -->
                        <div>
                            <div class="relative">
                                <select name="project_type" id="project_type" class="block w-full pl-3 pr-8 py-2 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 hover:bg-white transition-all appearance-none outline-none font-medium cursor-pointer">
                                    <option value="">All Project Types</option>
                                    <option value="web_development" {{ request('project_type') == 'web_development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="mobile_app" {{ request('project_type') == 'mobile_app' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="ecommerce" {{ request('project_type') == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="ui_ux_design" {{ request('project_type') == 'ui_ux_design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="digital_marketing" {{ request('project_type') == 'digital_marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                    <option value="seo" {{ request('project_type') == 'seo' ? 'selected' : '' }}>SEO</option>
                                    <option value="custom_software" {{ request('project_type') == 'custom_software' ? 'selected' : '' }}>Custom Software</option>
                                    <option value="other" {{ request('project_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Next Follow Up Date -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <input type="date" name="next_follow_up_date" id="next_follow_up_date" value="{{ request('next_follow_up_date') }}" 
                                       class="block w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 hover:bg-white transition-all outline-none cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-center gap-2 mt-4 justify-end">
                        <a href="{{ route('myleads') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-slate-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors focus:ring-2 focus:ring-slate-200 outline-none">
                            Reset
                        </a>
                        <button type="submit" class="px-5 py-2 text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm hover:shadow transition-all focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500 outline-none flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($myleads->count())
            <!-- Mobile Cards View (Hidden on md and above) -->
            <div class="block md:hidden space-y-4">
                @foreach($myleads as $index => $lead)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 relative overflow-hidden transition-all hover:shadow-md">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($lead->client->company_name ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-[15px] leading-tight mb-1">
                                        {{ $lead->client->company_name ?? 'N/A' }}
                                    </h3>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 uppercase tracking-wider bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                        Lead #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                            
                            @php
                                $statusColors = [
                                    'connected' => 'bg-emerald-100 text-emerald-800',
                                    'missed' => 'bg-rose-100 text-rose-800',
                                    'follow_up' => 'bg-blue-100 text-blue-800',
                                    'closed' => 'bg-gray-100 text-gray-800',
                                ];
                                $defaultColor = 'bg-amber-100 text-amber-800';
                                $statusColor = $statusColors[strtolower($lead->status)] ?? $defaultColor;
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded {{ $statusColor }} font-bold text-[10px] uppercase tracking-wider whitespace-nowrap ml-2">
                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                            </span>
                        </div>
                        
                        <div class="space-y-2 bg-slate-50 p-3 rounded border border-slate-100 mb-4">
                            <div class="flex justify-between items-start gap-4">
                                <span class="text-[12px] font-semibold text-slate-500">Response</span>
                                <span class="text-[13px] font-medium text-slate-700 text-right line-clamp-2">{{ $lead->response }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[12px] font-semibold text-slate-500">Follow-Up Time</span>
                                <span class="text-[13px] font-medium text-slate-700">{{ $lead->follow_up_time ? \Carbon\Carbon::parse($lead->follow_up_time)->format('h:i A') : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[12px] font-semibold text-slate-500">Next Date</span>
                                <span class="text-[13px] font-bold text-slate-800">
                                    {{ $lead->next_follow_up ? $lead->next_follow_up->format('d M, Y') : '—' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons for Mobile -->
                        <div class="flex flex-col gap-2 pt-1">
                            <!-- Open Lead Button -->
                            <a href="{{ route('myleads.show', $lead->id) }}"
                               class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-bold transition-colors duration-200 uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Open Lead Details</span>
                            </a>
                            
                            <!-- Communication Buttons -->
                            @if(($lead->client->phone ?? null) || ($lead->client->email ?? null))
                            <div class="flex gap-2 w-full mt-1">
                                @if($lead->client->phone ?? 'N/A')
                                <!-- WhatsApp -->
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->client->phone ?? 'N/A') }}"
                                   target="_blank"
                                   class="flex-1 flex items-center justify-center gap-1.5 px-2 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-[12px] font-bold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                                    </svg>
                                    <span class="hidden xs:inline">WhatsApp</span>
                                </a>
                                
                                <!-- Call -->
                                <a href="tel:{{ $lead->client->phone ?? 'N/A' }}"
                                   class="flex-1 flex items-center justify-center gap-1.5 px-2 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-[12px] font-bold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <span class="hidden xs:inline">Call</span>
                                </a>
                                @endif
                                
                                @if($lead->client->email ?? 'N/A')
                                <!-- Email -->
                                <a href="mailto:{{ $lead->client->email ?? 'N/A' }}"
                                   class="flex-1 flex items-center justify-center gap-1.5 px-2 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-[12px] font-bold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                                    <span class="hidden xs:inline">Email</span>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Desktop Table View (Hidden on mobile) -->
            <div class="hidden md:block overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200 ring-1 ring-black ring-opacity-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">#</th>
                                <th scope="col" class="px-4 py-4 text-xs font-bold text-white uppercase tracking-wider min-w-[200px]">Client Name</th>
                                <th scope="col" class="px-4 py-4 text-xs font-bold text-white uppercase tracking-wider min-w-[150px]">Response</th>
                                <th scope="col" class="px-4 py-4 text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">Follow-Up</th>
                                <th scope="col" class="px-4 py-4 text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">Next Date</th>
                                <th scope="col" class="px-4 py-4 text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-white uppercase tracking-wider whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($myleads as $index => $lead)
                                <tr class="hover:bg-indigo-50/60 transition-colors duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-slate-50' }}">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 align-top">
                                        <div class="flex items-start gap-3">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200 flex items-center justify-center flex-shrink-0 shadow-sm mt-0.5">
                                                <span class="text-sm font-bold text-indigo-700">{{ strtoupper(substr($lead->client->company_name ?? 'C', 0, 1)) }}</span>
                                            </div>
                                            <div class="flex flex-col pt-1">
                                                <span class="text-sm font-bold text-gray-900 break-words line-clamp-2" title="{{ $lead->client->company_name ?? 'N/A' }}">
                                                    {{ $lead->client->company_name ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 align-top pt-5">
                                        <div class="text-sm text-gray-700 break-words whitespace-normal leading-relaxed line-clamp-3" title="{{ $lead->response }}">
                                            {{ $lead->response }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 align-top pt-5">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $lead->follow_up_time ? \Carbon\Carbon::parse($lead->follow_up_time)->format('h:i A') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap align-top pt-5">
                                        @if($lead->next_follow_up)
                                            <div class="flex items-center gap-1.5 text-sm font-medium text-gray-700">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ $lead->next_follow_up->format('d M, Y') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 font-medium">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap align-top pt-5">
                                        @php
                                            $statusColors = [
                                                'connected' => 'bg-green-50 text-green-700 border-green-200',
                                                'missed' => 'bg-red-50 text-red-700 border-red-200',
                                                'follow_up' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'closed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            ];
                                            $defaultColor = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                                            $statusColor = $statusColors[strtolower($lead->status)] ?? $defaultColor;
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $statusColor }} border shadow-sm">
                                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center align-top pt-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Open Button -->
                                            <a href="{{ route('myleads.show', $lead->id) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors duration-200 text-xs font-semibold shadow-sm"
                                               title="Open Lead">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Open
                                            </a>
                                            
                                            @if($lead->client->phone ?? 'N/A')
                                            <!-- WhatsApp -->
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->client->phone ?? 'N/A') }}"
                                               target="_blank"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-white border border-gray-300 text-gray-500 hover:text-green-600 hover:border-green-300 hover:bg-green-50 transition-colors duration-200 shadow-sm"
                                               title="WhatsApp">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485"/></svg>
                                            </a>
                                            
                                            <!-- Call -->
                                            <a href="tel:{{ $lead->client->phone ?? 'N/A' }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-white border border-gray-300 text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200 shadow-sm"
                                               title="Call">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                            </a>
                                            
                                            <!-- SMS -->
                                            <a href="sms:{{ $lead->client->phone ?? 'N/A' }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-white border border-gray-300 text-gray-500 hover:text-purple-600 hover:border-purple-300 hover:bg-purple-50 transition-colors duration-200 shadow-sm"
                                               title="SMS">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                            </a>
                                            @endif
                                            
                                            @if($lead->client->email ?? 'N/A')
                                            <!-- Email -->
                                            <a href="mailto:{{ $lead->client->email ?? 'N/A' }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-white border border-gray-300 text-gray-500 hover:text-red-600 hover:border-red-300 hover:bg-red-50 transition-colors duration-200 shadow-sm"
                                               title="Email">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Tablet Optimized View (Hidden on mobile and desktop) -->
            <div class="hidden sm:block md:hidden overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200 ring-1 ring-black ring-opacity-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-[12px] font-bold text-white uppercase tracking-wider whitespace-nowrap">#</th>
                                <th scope="col" class="px-4 py-3.5 text-[12px] font-bold text-white uppercase tracking-wider whitespace-nowrap">Client Name</th>
                                <th scope="col" class="px-4 py-3.5 text-[12px] font-bold text-white uppercase tracking-wider whitespace-nowrap">Response</th>
                                <th scope="col" class="px-4 py-3.5 text-[12px] font-bold text-white uppercase tracking-wider whitespace-nowrap">Next Date</th>
                                <th scope="col" class="px-4 py-3.5 text-[12px] font-bold text-white uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th scope="col" class="px-4 py-3.5 text-center text-[12px] font-bold text-white uppercase tracking-wider whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($myleads as $index => $lead)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-medium text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="h-7 w-7 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-xs font-bold text-indigo-600">{{ strtoupper(substr($lead->client->company_name ?? 'C', 0, 1)) }}</span>
                                            </div>
                                            <span class="text-sm font-bold text-gray-900 truncate max-w-[150px]" title="{{ $lead->client->company_name ?? 'N/A' }}">
                                                {{ $lead->client->company_name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-xs text-gray-600 max-w-[120px] truncate" title="{{ $lead->response }}">{{ $lead->response }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($lead->next_follow_up)
                                            <div class="flex items-center gap-1.5 text-xs font-medium text-gray-700">
                                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ $lead->next_follow_up->format('d M') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 font-medium text-xs">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'connected' => 'bg-green-50 text-green-700 border-green-200',
                                                'missed' => 'bg-red-50 text-red-700 border-red-200',
                                                'follow_up' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'closed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            ];
                                            $defaultColor = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                                            $statusColor = $statusColors[strtolower($lead->status)] ?? $defaultColor;
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusColor }} border">
                                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Open Button -->
                                            <a href="{{ route('myleads.show', $lead->id) }}"
                                               class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors duration-200 shadow-sm"
                                               title="Open Lead">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            
                                            @if($lead->client->phone ?? 'N/A')
                                            <!-- WhatsApp -->
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->client->phone ?? 'N/A') }}"
                                               target="_blank"
                                               class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-white border border-gray-300 text-gray-500 hover:text-green-600 hover:border-green-300 hover:bg-green-50 transition-colors duration-200 shadow-sm"
                                               title="WhatsApp">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485"/></svg>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6 px-4">
                {{ $myleads->links() }}
            </div>
            
        @else
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-600 text-lg font-medium mb-2">No Leads Found</p>
                <p class="text-gray-500 text-sm">You haven't taken action on any leads yet.</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Mobile-first responsive styles */
    @media (max-width: 639px) {
        /* Card view for mobile */
        .mobile-card {
            transition: transform 0.2s ease;
        }
        
        .mobile-card:hover {
            transform: translateY(-2px);
        }
    }
    
    /* Tablet styles */
    @media (min-width: 640px) and (max-width: 767px) {
        /* Tablet optimized table */
        .table-scroll-container {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        
        .table-scroll-container::-webkit-scrollbar {
            display: none;
        }
    }
    
    /* Desktop styles */
    @media (min-width: 768px) {
        /* Desktop table */
        .table-responsive-wrapper {
            position: relative;
            overflow: hidden;
        }
        
        .table-scroll-container {
            overflow-x: auto;
            max-width: 100%;
        }
        
        .sticky-mobile {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    }
    
    /* Very small screens (≤375px) */
    @media (max-width: 375px) {
        .text-xs {
            font-size: 0.7rem !important;
        }
        
        .px-2 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        .py-1\.5 {
            padding-top: 0.375rem !important;
            padding-bottom: 0.375rem !important;
        }
    }
    
    /* Button hover effects */
    .hover-scale {
        transition: transform 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: scale(1.05);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Card shadow */
    .shadow-sm {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    
    /* Better scrolling on mobile */
    html, body {
        -webkit-overflow-scrolling: touch;
    }
    
    /* Prevent content shift */
    .content-stable {
        overflow-anchor: none;
    }
    
    /* Responsive table fixes */
    @media (max-width: 767px) {
        table {
            min-width: 100%;
            table-layout: fixed;
        }
        
        td, th {
            padding: 0.5rem 0.25rem !important;
            vertical-align: middle;
        }
    }
</style>

<script>
    // Mobile optimization script
    document.addEventListener('DOMContentLoaded', function() {
        // Handle touch events for better mobile UX
        const buttons = document.querySelectorAll('a');
        buttons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.classList.add('active:scale-95');
            });
            
            button.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.classList.remove('active:scale-95');
                }, 150);
            });
        });
        
        // Fix for iOS scroll issues
        if (/iPhone|iPad|iPod/.test(navigator.userAgent)) {
            // Prevent elastic scroll
            document.body.style.overscrollBehavior = 'contain';
            
            // Fix 100vh issue
            function setFullHeight() {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }
            
            setFullHeight();
            window.addEventListener('resize', setFullHeight);
            window.addEventListener('orientationchange', setFullHeight);
        }
        
        // Handle tablet view
        function checkScreenSize() {
            const screenWidth = window.innerWidth;
            const isTablet = screenWidth >= 640 && screenWidth <= 767;
            
            if (isTablet) {
                // Add specific tablet optimizations
                document.body.classList.add('tablet-view');
            } else {
                document.body.classList.remove('tablet-view');
            }
        }
        
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add loading state for buttons
        const actionButtons = document.querySelectorAll('a[href*="myleads"]');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Add loading indicator
                const originalHTML = this.innerHTML;
                this.innerHTML = `
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
                this.classList.add('pointer-events-none', 'opacity-75');
                
                // Restore original after 2 seconds (in case page doesn't load)
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('pointer-events-none', 'opacity-75');
                }, 2000);
            });
        });
    });
    
    // Handle back button and page state
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Page was restored from bfcache
            window.scrollTo(0, 0);
        }
    });
</script>
@endsection