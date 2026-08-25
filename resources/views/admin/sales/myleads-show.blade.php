@extends('components.layout')

@section('content')
@php
    if (!function_exists('formatHistoryValue')) {
        function formatHistoryValue($field, $value)
        {
            if ($value === 'N/A' || $value === null || $value === '') {
                return 'N/A';
            }
            try {
                if ($field === 'next_follow_up') {
                    return \Carbon\Carbon::parse($value)->format('d M Y');
                }
                if ($field === 'follow_up_time') {
                    return \Carbon\Carbon::parse($value)->format('h:i A');
                }
            } catch (\Exception $e) {}
            return $value;
        }
    }

    $leadStatuses = [
        'follow up' => 'Follow Up',
        'closed' => 'Closed',
        'not interested' => 'Not Interested',
        'non-contactable' => 'Non-contactable'
    ];
    $currentStatus = strtolower($lead->status ?? '');
@endphp

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Back Navigation -->
        <div class="flex items-center justify-between mb-6">
            <div class="inline-flex items-center text-sm font-bold text-slate-600">
                <svg class="w-5 h-5 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Leads Detail
            </div>
            <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-all font-extrabold text-sm shadow-sm hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Leads
            </a>
        </div>

        @if($lead)
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white overflow-hidden ring-1 ring-slate-100">
                <!-- TOP HEADER SECTION -->
                <div class="p-6 md:p-10 relative overflow-hidden">
                    <!-- Decorative Background elements -->
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-gradient-to-br from-blue-50 to-indigo-50 opacity-70 blur-3xl -z-10 animate-pulse"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                        <div class="flex items-center gap-5 sm:gap-6">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center text-3xl font-extrabold shadow-lg shadow-indigo-200 transform hover:scale-105 transition-transform duration-300">
                                {{ strtoupper(substr($lead->client->company_name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight mb-1">{{ $lead->client->company_name ?? 'N/A' }}</h2>
                                <div class="flex items-center gap-2 text-sm font-semibold text-slate-500">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $lead->client->contact_person ?? 'No Contact Person' }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            @if($lead->client->email)
                                <a href="mailto:{{ $lead->client->email }}" onclick="logContactAction('Sent Email')" class="w-11 h-11 rounded-xl bg-white border-2 border-slate-100 flex items-center justify-center text-indigo-500 hover:bg-indigo-50 hover:border-indigo-200 transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </a>
                            @endif
                            @if($lead->client->phone)
                                <a href="tel:{{ $lead->client->phone }}" onclick="logContactAction('Initiated Phone Call')" class="w-11 h-11 rounded-xl bg-white border-2 border-slate-100 flex items-center justify-center text-indigo-500 hover:bg-indigo-50 hover:border-indigo-200 transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->client->phone) }}" target="_blank" onclick="logContactAction('Initiated WhatsApp Conversation')" class="w-11 h-11 rounded-xl bg-emerald-50 border-2 border-emerald-100 flex items-center justify-center text-emerald-600 hover:bg-emerald-100 hover:border-emerald-200 transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- METADATA GRID -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mt-10">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Project Type</span>
                            <span class="inline-block px-3 py-1 bg-slate-100 text-slate-700 text-sm font-bold rounded-lg">{{ $lead->project_type ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Industry</span>
                            <span class="text-sm font-bold text-slate-800">{{ $lead->client->industry ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email</span>
                            <span class="text-sm font-bold text-slate-800 break-all">{{ $lead->client->email ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Phone</span>
                            <span class="text-sm font-bold text-slate-800">{{ $lead->client->phone ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Created At</span>
                            <span class="text-sm font-bold text-slate-800">{{ $lead->created_at ? $lead->created_at->format('d M, Y') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Next Follow-Up</span>
                            <span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">{{ $lead->next_follow_up ? $lead->next_follow_up->format('d M, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- LEAD STATUS ROW -->
                <div class="px-6 md:px-10 pb-8 border-b border-slate-100">
                    <h4 class="text-sm font-extrabold text-slate-800 mb-4 uppercase tracking-wider">Lead Status</h4>
                    <div class="flex flex-col md:flex-row gap-2">
                        @foreach($leadStatuses as $value => $label)
                            @if($currentStatus === $value || 
                               ($value === 'follow up' && in_array($currentStatus, ['connected', 'interested', 'proposal', 'negotiating', 'missed booked', 'will call back'])) || 
                               ($value === 'closed' && in_array($currentStatus, ['purchased', 'closed'])) || 
                               ($value === 'not interested' && in_array($currentStatus, ['lost', 'not interested'])) ||
                               ($value === 'non-contactable' && in_array($currentStatus, ['not reachable', 'missed', 'non-contactable'])) )
                                
                                <div class="flex-1 min-w-[140px] px-4 py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md transform hover:-translate-y-0.5 transition-all
                                    @if($value === 'follow up') bg-gradient-to-r from-blue-500 to-indigo-600 text-white border-none
                                    @elseif($value === 'closed') bg-gradient-to-r from-emerald-400 to-emerald-600 text-white border-none
                                    @elseif($value === 'not interested') bg-gradient-to-r from-rose-400 to-rose-600 text-white border-none
                                    @elseif($value === 'non-contactable') bg-gradient-to-r from-amber-400 to-orange-500 text-white border-none
                                    @else bg-gradient-to-r from-indigo-500 to-purple-600 text-white border-none @endif">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="truncate">{{ $label }}</span>
                                </div>
                            @else
                                <div class="flex-1 min-w-[140px] bg-slate-50 text-slate-400 text-center py-3 px-4 rounded-xl font-bold text-sm items-center justify-center border-2 border-slate-100 border-dashed hover:bg-slate-100 transition-colors">
                                    {{ $label }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- BOTTOM SPLIT SECTION -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 bg-slate-50/30">
                    
                    <!-- Left: Activity Timeline & Edit Form -->
                    <div class="lg:col-span-2 p-6 md:p-10 lg:border-r border-slate-100">
                        
                        <!-- Header -->
                        <div class="border-b border-slate-200 mb-8 pb-3">
                            <h3 class="text-indigo-600 font-extrabold text-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Activity Timeline
                            </h3>
                        </div>

                        <!-- ADD NEW UPDATE FORM -->
                        @if(Auth::id() === $lead->user_id || Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                            <div class="mb-10 relative group">
                                
                                @if(session('success'))
                                    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="font-bold text-sm">{{ session('success') }}</span>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl">
                                        <div class="flex items-center gap-2 mb-1">
                                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="font-bold text-sm">Please fix the following errors:</span>
                                        </div>
                                        <ul class="list-disc pl-7 text-xs font-medium space-y-1 mt-2">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                                <div class="relative bg-white rounded-xl shadow-sm border border-indigo-100 p-5">
                                    <form action="{{ route('myleads.update', $lead->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="redirect_to" value="show">
                                        <div class="mb-3">
                                            <label class="sr-only">Type your notes here...</label>
                                            <textarea name="response" rows="3" placeholder="Type new update, client response, or notes here..." class="w-full bg-slate-50/50 border border-slate-200 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 font-medium resize-none transition-all outline-none" required></textarea>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-center gap-4 justify-between">
                                            <div class="flex gap-4 w-full sm:w-auto">
                                                <div class="flex-1 sm:flex-none">
                                                    <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg focus:ring-2 focus:ring-indigo-500 p-2.5 outline-none cursor-pointer">
                                                        @foreach($leadStatuses as $val => $label)
                                                            <option value="{{ $val }}" {{ $currentStatus === $val ? 'selected' : '' }}>Mark as: {{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-1 sm:flex-none">
                                                    <input type="date" name="next_follow_up" value="{{ $lead->next_follow_up ? $lead->next_follow_up->format('Y-m-d') : '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg focus:ring-2 focus:ring-indigo-500 p-2.5 outline-none cursor-pointer">
                                                </div>
                                                <!-- Hidden fields to preserve other required data -->
                                                <input type="hidden" name="project_type" value="{{ $lead->project_type }}">
                                                <input type="hidden" name="follow_up_time" value="{{ $lead->follow_up_time }}">
                                            </div>
                                            <button type="button" id="btn-save-update" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md shadow-indigo-200 hover:-translate-y-0.5 transition-all text-sm">
                                                Save Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="mb-10 relative group">
                                <div class="relative bg-slate-50 rounded-xl shadow-sm border border-slate-200 p-6 text-center">
                                    <svg class="w-10 h-10 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <h4 class="text-base font-bold text-slate-700 mb-1">View Only Mode</h4>
                                    <p class="text-slate-500 text-sm max-w-md mx-auto">This lead is currently assigned to someone else. You can view its details and history, but you cannot log new updates.</p>
                                </div>
                            </div>
                        @endif

                        <!-- Lead Closed Modal -->
                        <div id="lead-closed-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity bg-slate-900/75 backdrop-blur-sm" aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
                                    <div class="px-6 py-5 bg-gradient-to-r from-emerald-500 to-teal-500">
                                        <h3 class="text-xl font-bold leading-6 text-white flex items-center gap-2" id="modal-title">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Lead Closed Form (Deal Won)
                                        </h3>
                                    </div>
                                    <div class="px-6 py-6 bg-slate-50">
                                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                            <!-- Read Only Info -->
                                            <div class="col-span-2 bg-white p-4 rounded-xl border border-slate-200 grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-400 uppercase">Client Name</p>
                                                    <p class="font-semibold text-slate-800">{{ $lead->client->name ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-400 uppercase">Phone</p>
                                                    <p class="font-semibold text-slate-800">{{ $lead->client->phone ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-span-2">
                                                    <p class="text-xs font-bold text-slate-400 uppercase">Email</p>
                                                    <p class="font-semibold text-slate-800">{{ $lead->client->email ?? 'N/A' }}</p>
                                                </div>
                                            </div>

                                            <!-- Form Fields -->
                                            <div class="col-span-2 sm:col-span-1">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Closed For (Service) <span class="text-red-500">*</span></label>
                                                <select id="modal_service_name" class="w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500 p-2.5 outline-none">
                                                    <option value="Mobile App">Mobile App</option>
                                                    <option value="Website Development">Website Development</option>
                                                    <option value="SEO & Marketing">SEO & Marketing</option>
                                                    <option value="CRM/ERP System">CRM/ERP System</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Closed Date <span class="text-red-500">*</span></label>
                                                <input type="date" id="modal_closed_date" value="{{ date('Y-m-d') }}" class="w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500 p-2.5 outline-none">
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Payment Type <span class="text-red-500">*</span></label>
                                                <select id="modal_payment_type" class="w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500 p-2.5 outline-none">
                                                    <option value="one_time">One Time Payment</option>
                                                    <option value="recurring">Recurring / Milestone</option>
                                                </select>
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Total Amount <span class="text-red-500">*</span></label>
                                                <input type="number" id="modal_total_amount" step="0.01" placeholder="e.g. 50000" class="w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500 p-2.5 outline-none">
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Paid Amount (Advance)</label>
                                                <input type="number" id="modal_paid_amount" step="0.01" value="0" class="w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500 p-2.5 outline-none">
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Due Amount</label>
                                                <input type="number" id="modal_due_amount" step="0.01" value="0" class="w-full bg-slate-100 border border-slate-300 text-slate-800 text-sm rounded-lg p-2.5 outline-none cursor-not-allowed" readonly>
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font-bold text-slate-700 mb-1">Next Payment Date (If Due)</label>
                                                <input type="date" id="modal_next_payment_date" class="w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500 p-2.5 outline-none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 bg-white border-t border-slate-200 sm:flex sm:flex-row-reverse rounded-b-2xl">
                                        <button type="button" id="btn-submit-modal" class="inline-flex justify-center w-full px-6 py-2.5 text-base font-bold text-white bg-emerald-600 border border-transparent rounded-lg shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Confirm & Close Lead
                                        </button>
                                        <button type="button" id="btn-cancel-modal" class="inline-flex justify-center w-full px-6 py-2.5 mt-3 text-base font-bold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Timeline Content -->
                        <div class="mt-8 ml-0 sm:ml-2">
                            @if($lead->histories->count())
                                <div class="relative before:absolute before:inset-0 before:ml-[50px] sm:before:ml-[5.5rem] before:-translate-x-px before:h-full before:w-[2px] before:bg-indigo-100">
                                    
                                    @php $lastDate = null; @endphp
                                    @foreach($lead->histories()->latest()->get() as $index => $history)
                                        @php
                                            $currentDate = $history->created_at->format('Y-m-d');
                                            $showDate = ($lastDate !== $currentDate);
                                            $lastDate = $currentDate;
                                        @endphp
                                        
                                        <div class="relative flex items-start gap-1.5 sm:gap-6 group mb-6">
                                            <!-- Time on the left -->
                                            <div class="w-[38px] sm:w-16 shrink-0 text-right mt-1 relative z-10 bg-slate-50/50 py-1 rounded-l-lg">
                                                <div class="text-[9px] sm:text-[11px] font-bold text-slate-500 flex items-center justify-end gap-0.5 sm:gap-1 leading-tight sm:leading-normal tracking-tight">
                                                    {{ $history->created_at->format('h:i') }}<br class="sm:hidden">{{ $history->created_at->format('A') }}
                                                </div>
                                                @if($showDate)
                                                    <div class="text-[8px] sm:text-[9px] font-extrabold text-indigo-400 mt-0.5 sm:mt-0.5 uppercase tracking-tighter">{{ $history->created_at->format('d M') }}</div>
                                                @endif
                                            </div>
                                            
                                            <!-- Timeline Dot -->
                                            <div class="flex flex-col items-center shrink-0">
                                                <div class="w-3 h-3 rounded-full bg-indigo-400 border-2 border-white mt-1.5 relative z-10 shadow-sm group-hover:bg-indigo-600 transition-colors duration-300"></div>
                                            </div>
                                            
                                            <!-- Content Card -->
                                            <div class="flex-1 relative">
                                                <!-- Display Mode -->
                                                <div id="history-display-{{ $history->id }}" class="bg-white border border-slate-200 shadow-sm p-4 sm:p-5 rounded-xl group/card relative">
                                                    <div class="flex justify-between items-start mb-2 gap-4">
                                                         <div class="flex items-center flex-wrap gap-3">
                                                             <h4 class="font-bold text-slate-800 text-[13px] flex items-center gap-1.5">
                                                                @if(isset(json_decode($history->changes, true)['action_taken']))
                                                                    <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                                    </span>
                                                                    Initial Action
                                                                @elseif(str_contains(strtolower($history->response), 'whatsapp'))
                                                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                                                                    </span>
                                                                    WhatsApp Log
                                                                @elseif(str_contains(strtolower($history->response), 'phone') || str_contains(strtolower($history->response), 'call'))
                                                                    <span class="w-4 h-4 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                                    </span>
                                                                    Call Log
                                                                @elseif(str_contains(strtolower($history->response), 'email') || str_contains(strtolower($history->response), 'mail'))
                                                                    <span class="w-4 h-4 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                                                                         <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                                    </span>
                                                                    Email Log
                                                                @else
                                                                    <span class="w-4 h-4 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                                    </span>
                                                                    Activity Update
                                                                @endif
                                                             </h4>
                                                             @php $changes = json_decode($history->changes, true); @endphp
                                                             @if(isset($changes['status']))
                                                                 <span class="text-[9px] font-extrabold uppercase tracking-widest bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded border border-slate-200">
                                                                     {{ str_replace('_', ' ', $changes['status']['new']) }}
                                                                 </span>
                                                             @endif
                                                         </div>

                                                         <!-- User Label & Edit Button -->
                                                         <div class="flex items-center gap-2 shrink-0">
                                                             <span class="text-[10px] font-bold text-slate-500 bg-slate-50 border border-slate-100 px-2 py-1 rounded-md flex items-center gap-1 shadow-sm">
                                                                 <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                                 {{ $history->user->name ?? 'System' }}
                                                             </span>
                                                             
                                                             @if($history->user_id === auth()->id())
                                                             <button onclick="document.getElementById('history-display-{{ $history->id }}').classList.add('hidden'); document.getElementById('history-edit-{{ $history->id }}').classList.remove('hidden');" class="text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none p-1 rounded-md hover:bg-indigo-50 border border-transparent hover:border-indigo-100" title="Edit this update">
                                                                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                             </button>
                                                             @endif
                                                         </div>
                                                    </div>
                                                    
                                                    @if($history->response)
                                                        <div class="mt-2 text-[13px] text-slate-700 leading-relaxed font-medium whitespace-pre-wrap pl-6 border-l-2 border-indigo-100 ml-1 py-1">{!! preg_replace('/(Initiated WhatsApp|Initiated Phone Call|Sent Email)/i', '<strong class="text-slate-800">$1</strong>', $history->response) !!}</div>
                                                    @endif
                                                    
                                                    <!-- Fields Changed -->
                                                    @php
                                                        $validChanges = [];
                                                        if ($history->changes && !isset($changes['action_taken'])) {
                                                            foreach($changes as $field => $change) {
                                                                if($field !== 'status' && $field !== 'response') {
                                                                    $oldFormatted = formatHistoryValue($field, $change['old'] ?? 'N/A');
                                                                    $newFormatted = formatHistoryValue($field, $change['new'] ?? 'N/A');
                                                                    if ($oldFormatted !== $newFormatted) {
                                                                        $validChanges[$field] = [
                                                                            'old' => $oldFormatted,
                                                                            'new' => $newFormatted
                                                                        ];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    
                                                    @if(count($validChanges) > 0)
                                                        <div class="flex flex-col gap-1.5 pl-6 mt-3 pt-3 border-t border-slate-50">
                                                            @foreach($validChanges as $field => $changeData)
                                                                <div class="text-[11px] text-slate-500 flex flex-wrap items-center gap-1.5">
                                                                    <span class="font-bold uppercase text-slate-400">{{ str_replace('_', ' ', $field) }}:</span>
                                                                    <span class="text-slate-600">{{ $changeData['old'] }}</span>
                                                                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                                    <span class="font-bold text-indigo-600">{{ $changeData['new'] }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Edit Mode (Hidden by default) -->
                                                <div id="history-edit-{{ $history->id }}" class="hidden bg-white border border-indigo-200 p-5 sm:p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] ring-4 ring-indigo-50 transition-all duration-300 relative">
                                                    <div class="flex items-center gap-2 mb-4">
                                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        <h4 class="font-extrabold text-slate-800 text-[15px]">Edit Response</h4>
                                                    </div>
                                                    <form action="{{ route('myleads.history.update', $history->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-4">
                                                            <textarea name="response" rows="3" class="w-full bg-slate-50/50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 font-medium resize-none transition-all outline-none" required>{{ $history->response }}</textarea>
                                                        </div>
                                                        <div class="flex items-center justify-end gap-3">
                                                            <button type="button" onclick="document.getElementById('history-edit-{{ $history->id }}').classList.add('hidden'); document.getElementById('history-display-{{ $history->id }}').classList.remove('hidden');" class="text-xs font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-100 px-4 py-2.5 rounded-lg transition-colors focus:outline-none">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="text-xs font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 rounded-lg shadow-md shadow-indigo-200 hover:-translate-y-0.5 transition-all focus:outline-none">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 px-4 bg-white rounded-2xl border border-dashed border-slate-200">
                                    <h3 class="text-base font-bold text-slate-800 mb-1">No Activity Yet</h3>
                                    <p class="text-slate-500 text-sm">Use the form above to log the first update.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Quick Side Info -->
                    <div class="lg:col-span-1 p-6 md:p-10 bg-gradient-to-b from-transparent to-slate-50/50">
                        <h4 class="font-extrabold text-slate-800 mb-6 flex items-center gap-2 text-lg">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Recent Details
                        </h4>
                        
                        <div class="space-y-4">
                            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm transition-all hover:shadow-md hover:border-indigo-100 group">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Follow-Up Date</p>
                                <p class="font-extrabold text-slate-800 flex items-center gap-2 text-base">
                                    <span class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </span>
                                    {{ $lead->next_follow_up ? $lead->next_follow_up->format('d M Y') : 'Not Scheduled' }}
                                </p>
                            </div>
                            
                            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm transition-all hover:shadow-md hover:border-emerald-100 group">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Follow-Up Time</p>
                                <p class="font-extrabold text-slate-800 flex items-center gap-2 text-base">
                                    <span class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </span>
                                    {{ $lead->follow_up_time ? \Carbon\Carbon::parse($lead->follow_up_time)->format('h:i A') : '--:--' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm p-16 text-center border border-slate-200">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-50 mb-6">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-slate-800 text-2xl font-bold mb-3">Lead Not Found</p>
                <p class="text-slate-500 max-w-md mx-auto">The lead you are looking for does not exist or you don't have access to view its details.</p>
                <a href="javascript:history.back()" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm hover:shadow mt-8 transition-all">
                    Return to Dashboard
                </a>
            </div>
        @endif
    </div>
</div>

@if($lead)
<script>
    function logContactAction(actionType) {
        // Find existing CSRF token
        let token = document.querySelector('input[name="_token"]');
        token = token ? token.value : '';

        // Simple form post to log it without needing complex fetch headers
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('myleads.update', $lead->id) }}";
        form.style.display = 'none';

        const fields = {
            _token: token,
            _method: 'PUT',
            redirect_to: 'show',
            response: actionType,
            status: "{{ $lead->status }}",
            project_type: "{{ $lead->project_type }}",
            next_follow_up: "{{ $lead->next_follow_up ? $lead->next_follow_up->format('Y-m-d') : '' }}",
            follow_up_time: "{{ $lead->follow_up_time }}"
        };

        for (const key in fields) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = fields[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        // Add a slight delay so the link (href) opens the native app first
        setTimeout(() => form.submit(), 1000);
    }
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const mainForm = document.querySelector('form[action="{{ route('myleads.update', $lead->id) }}"]');
        const btnSaveUpdate = document.getElementById('btn-save-update');
        const modal = document.getElementById('lead-closed-modal');
        const btnCancelModal = document.getElementById('btn-cancel-modal');
        const btnSubmitModal = document.getElementById('btn-submit-modal');

        // Due amount calculation
        const totalInput = document.getElementById('modal_total_amount');
        const paidInput = document.getElementById('modal_paid_amount');
        const dueInput = document.getElementById('modal_due_amount');

        function calculateDue() {
            const total = parseFloat(totalInput.value) || 0;
            const paid = parseFloat(paidInput.value) || 0;
            dueInput.value = (total - paid).toFixed(2);
        }

        totalInput.addEventListener('input', calculateDue);
        paidInput.addEventListener('input', calculateDue);

        // Intercept form submission
        btnSaveUpdate.addEventListener('click', function(e) {
            e.preventDefault();
            // Validate main form first (required textarea)
            if(!mainForm.reportValidity()) {
                return;
            }

            if (statusSelect.value.toLowerCase() === 'closed') {
                modal.classList.remove('hidden');
            } else {
                mainForm.submit();
            }
        });

        // Cancel Modal
        btnCancelModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Submit from Modal
        btnSubmitModal.addEventListener('click', function() {
            // Validate modal required fields
            const service = document.getElementById('modal_service_name').value;
            const total = document.getElementById('modal_total_amount').value;
            
            if(!total || total <= 0) {
                alert('Please enter a valid Total Amount.');
                return;
            }

            // Append modal data to main form as hidden inputs
            const fields = ['service_name', 'closed_date', 'payment_type', 'total_amount', 'paid_amount', 'due_amount', 'next_payment_date'];
            
            fields.forEach(field => {
                // Remove existing if any
                let existing = mainForm.querySelector(`input[name="${field}"]`);
                if(existing) existing.remove();

                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = field;
                input.value = document.getElementById(`modal_${field}`).value;
                mainForm.appendChild(input);
            });

            // Add a flag to indicate it's a modal close submission
            let flag = document.createElement('input');
            flag.type = 'hidden';
            flag.name = 'is_closed_deal';
            flag.value = '1';
            mainForm.appendChild(flag);

            // Finally submit the main form
            mainForm.submit();
        });
    });
</script>
@endsection