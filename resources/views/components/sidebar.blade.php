@php
    $company = auth()->user()->company;
    $crmAccessible = $company && (
        $company->is_paid ||
        now()->lt($company->trial_ends_at)
    );
@endphp



<!-- Desktop Sidebar -->
<div id="desktop-sidebar" class="hidden lg:flex fixed inset-y-0 z-50 h-svh w-64 transition-all duration-300 border-r border-slate-200/60 bg-white/80 backdrop-blur-xl">
    <div class="flex h-full w-full flex-col">
        <!-- Sidebar Header -->
    <div class="hidden lg:flex flex-col gap-2 border-b border-slate-200/60 p-6 sidebar-logo-container relative min-h-[88px]">
    <button id="sidebar-toggle-btn" class="absolute right-2 top-2 z-[60] flex h-7 w-7 items-center justify-center rounded-full border border-slate-200 bg-white shadow-sm text-slate-500 hover:text-slate-800 hover:bg-slate-50 cursor-pointer hidden lg:flex transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <div class="items-center gap-3 sidebar-logo">
        @if(auth()->user()->company && auth()->user()->company->logo)
            <div class="mb-3 mt-2 w-full">
                <img src="{{ asset('storage/' . auth()->user()->company->logo) }}" 
                     alt="{{ auth()->user()->company->name }}" 
                     class="max-h-12 w-auto object-contain rounded-lg">
            </div>
        @else
            <div class="mb-3 mt-2 w-full">
                <img src="{{ asset('images/social-cults-logo.png') }}" 
                     alt="Social Cults" 
                     class="max-h-12 w-auto object-contain">
            </div>
        @endif

        @php
            $company = auth()->user()->company;
        @endphp

        @if($company)
            <div class="status-badge">
                @if(!$company->is_paid && now()->lt($company->trial_ends_at))
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                        Trial
                    </span>
                @elseif($company->is_paid)
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">
                        Active
                    </span>
                @else
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">
                        Expired
                    </span>
                @endif
            </div>
        @endif
    </div>




  {{-- Days + Hours only --}}
@if($company && !$company->is_paid && now()->lt($company->trial_ends_at))
    @php
        $diff = now()->diff($company->trial_ends_at);
    @endphp
    <div class="flex flex-col gap-3 mt-2 trial-block">
        <p class="text-[14px] text-slate-500 font-medium whitespace-nowrap text-center">
            Trial ends in {{ $diff->days }} days {{ $diff->h }} hours
        </p>
        <a href="{{ route('upgrade.index') }}"
            class="w-full justify-center group relative inline-flex items-center gap-x-1.5 overflow-hidden rounded-full bg-sky-500 px-3 py-2 text-xs font-bold text-white shadow-md transition-all hover:bg-sky-600 hover:scale-105 hover:shadow-lg">
            UPGRADE
        </a>
    </div>
@endif
</div>

 <!-- Sidebar Header -->


        <!-- Sidebar Content -->
        <div class="flex min-h-0 flex-1 flex-col gap-2 overflow-y-auto sidebar-scroll-container p-3 pt-20 pb-28 lg:pt-3 lg:pb-3">
            <!-- Navigation Section -->
            <div class="relative flex w-full min-w-0 flex-col p-2">
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 py-2">Navigation</div>
                <div class="w-full text-[8px]">



                  

                    <ul class="flex w-full min-w-0 flex-col gap-1">
                        <!-- Dashboard -->
                        @if($crmAccessible)
                        @can('dashboard')
                        <li class="relative">
                            <a href="{{ route('dashboard') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('dashboard') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="w-4 h-4">
                                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Users -->
                        @can('users')
                        <li class="relative">
                            <a href="{{ route('users') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('users') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                    <path d="m9 14 2 2 4-4"></path>
                                </svg>
                                <span class="font-medium">Users</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Roles -->
                        @can('roles')
                        <li class="relative">
                            <a href="{{ route('roles') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('roles') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="font-medium">Roles</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Besdex -->
                        @can('besdex')
                        <li class="relative">
                            <a href="{{ route('clients.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('clients.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span class="font-medium">Besdex</span>
                            </a>
                        </li>
                        @endcan

                        

                        <!-- My Leads -->
                        @can('my leads')
                        <li class="relative">
                            <a href="{{ route('myleads') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('myleads') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                                <span class="font-medium">My Leads</span>
                            </a>
                        </li>
                        @endcan

                       <!-- Proposal -->
                         @can('proposal')
                        <li class="relative">
                            <a href="{{ route('proposal') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('proposal') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                                <span class="font-medium">Proposal</span>
                            </a>
                        </li>
                        @endcan
                        <!-- HRMS -->
                        @if(auth()->user()->hasRole('admin') || (auth()->user()->can('Attendance Records') || auth()->user()->can('My Attendance') || auth()->user()->can('Leave Apply') || auth()->user()->can('Leave Record') || auth()->user()->can('salary')))
                        @php
                           $hrmsRoute = '#';
                           if(auth()->user()->hasRole('admin') || auth()->user()->can('Attendance Records')) $hrmsRoute = route('attendance-record.index');
                           elseif(auth()->user()->can('Leave Record')) $hrmsRoute = route('adminportal.index');
                           elseif(auth()->user()->can('Leave Apply')) $hrmsRoute = route('employeeportal.index');
                           elseif(auth()->user()->can('My Attendance')) $hrmsRoute = route('my-attendance.index');
                           elseif(auth()->user()->can('salary')) $hrmsRoute = route('salary.index');
                        @endphp
                        <li class="relative">
                            <a href="{{ $hrmsRoute }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ (request()->routeIs('attendance-record.index') || request()->routeIs('my-attendance.index') || request()->routeIs('employeeportal.index') || request()->routeIs('adminportal.index') || request()->routeIs('salary.index')) 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span class="font-medium">HRMS</span>
                            </a>
                        </li>
                        @endif

                        





                          







                        <!-- To-Do -->
                        @can('To-Do')
                        <li class="relative">
                            <a href="{{ route('todo.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('todo.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
                                <span class="font-medium">To-Do</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Task -->
                        @can('task')
                        <li class="relative">
                            <a href="{{ route('tasks.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('tasks.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <path d="M14 2v6h6"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                </svg>
                                <span class="font-medium">Task</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Calendar -->
                        @can('Calendar')
                        <li class="relative">
                            <a href="{{ route('calendar.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('calendar.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                                <span class="font-medium">Calendar</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Links and Remarks -->
                        @can('Links and Remarks')
                        <li class="relative">
                            <a href="{{ route('linksandremark.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('linksandremark.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                </svg>
                                <span class="font-medium">Links and Remarks</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Interaction -->
                        @can('Client Service Interaction')
                        <li class="relative">
                            <a href="{{ route('chat.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('chat.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                                <span class="font-medium">Interaction</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Invoice -->
                        @can('invoice')
                        <li class="relative">
                            <a href="{{ route('invoices.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('invoices.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                                <span class="font-medium">Invoice</span>
                            </a>
                        </li>
                        @endcan

                        

                    <!--help and support-->
                         {{-- @can('help and support')
                        <li class="relative">
                            <a href="{{ route('helpandsupportuser.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('helpandsupportuser.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                                <span class="font-medium">Help and Support</span>
                            </a>
                        </li>
                        @endcan --}}



                        <!--help and support admin-->
                           {{-- @can('helpandsupportadmin')
                        <li class="relative">
                            <a href="{{ route('helpandsupportadmin.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('helpandsupportadmin.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                                <span class="font-medium">Help and Support Admin</span>
                            </a>
                        </li>
                        @endcan --}}


                        




                         































                        <!-- Contact -->
                        @can('contact')
                        <li class="relative">
                            <a href="{{ route('contacts.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('contacts.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                                <span class="font-medium">Contact</span>
                            </a>
                        </li>
                        @endcan



                          <!-- project management -->
                        @can('Project Management')
                        <li class="relative">
                            <a href="{{ route('projectmanagement.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('projectmanagement.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-4 h-4">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                                <span class="font-medium whitespace-nowrap">Project Management</span>
                            </a>
                        </li>
                        @endcan

                        <!-- Report -->
                        @can('report')
                        <li class="relative">
                            <a href="{{ route('rr.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('rr.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    <line x1="9" y1="10" x2="15" y2="10"></line>
                                    <line x1="12" y1="7" x2="12" y2="13"></line>
                                </svg>
                                <span class="font-medium">Report</span>
                            </a>
                        </li>
                        @endcan



                        
                        <!-- Project -->
                        {{-- <li class="relative">
                            <a href="{{ route('project.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('project.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
  <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
</svg>
                                <span class="font-medium">Project</span>
                            </a>
                        </li> --}}


                        <!-- Notepad -->
                        @can('notepad')
                        <li class="relative">
                            <a href="{{ route('notepad.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('notepad.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                                    <path d="M10 7h4"/>
                                    <path d="M10 11h4"/>
                                    <path d="M10 15h2"/>
                                    <path d="M16 3v4"/>
                                    <path d="M8 3v2"/>
                                </svg>
                                <span class="font-medium">Notepad</span>
                            </a>
                        </li>
                        @endcan

                        {{-- yahan --}}



                           {{-- @can('ticket records')
                             <li class="relative">
                            <a href="{{ route('ticket.record.index') }}" class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                                                                        {{ request()->routeIs('ticket.record.*')
    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <i class="fas fa-headset w-4 h-4"></i>
                                <span class="font-medium">Support Desk</span>
                            </a>
                        </li>
                         @endcan --}}


                             @can('Raise Ticket')
                          <li class="relative">
                            <a href="{{ route('user.support.ticket.index') }}" class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                                                                        {{ request()->routeIs('user.support.ticket.*')
    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
    <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
    <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
    <circle cx="12" cy="10" r="1"></circle>
    <circle cx="8" cy="10" r="1"></circle>
    <circle cx="16" cy="10" r="1"></circle>
</svg>
                                <span class="font-medium">My Tickets</span>
                            </a>
                        </li>
                          @endcan


                   


                        <!-- Help and Support -->
                        {{-- <li class="relative">
                            <a href="{{ route('helpandsupport.index') }}"
                               class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
                               {{ request()->routeIs('helpandsupport.index') 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' 
                                    : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4">
                                     <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span class="font-medium">Help and Support</span>
                            </a>
                        </li> --}}

          @endif
                        <!-- Upgrade Plan -->
<li class="relative">
    <a href="{{ route('upgrade.index') }}" class="flex w-full items-center gap-2 overflow-hidden p-2 text-left h-8 text-sm rounded-xl mb-1 flex items-center gap-3 px-4 py-3 
       {{ request()->routeIs('upgrade.index')
        ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
        : 'hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 text-slate-700' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="w-4 h-4">
            <polygon
                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
            </polygon>
        </svg>
        <span class="font-medium">Upgrade Plan</span>
    </a>
</li>



                    </ul>

            


                  
                </div>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="flex flex-col gap-2 border-t border-slate-200/60 p-4 pb-24 lg:pb-4 sidebar-footer">
            <div class="group relative overflow-hidden rounded-xl">
                <div class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-gray-200 flex-shrink-0">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-sm">
                               {{ strtoupper(substr(Auth::user()->username ?? Auth::user()->name, 0, 2)) }}
                            </span>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-900 text-sm truncate">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-slate-500 truncate">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>

                <!-- Slide-up hover layer -->
                <div class="absolute bottom-0 left-0 w-full bg-white/95 flex justify-center gap-3 py-3 translate-y-full group-hover:translate-y-0 transition-all duration-300">
                    <a href="{{ route('profile.view') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 transition">
                        Visit Profile
                    </a>
                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Bottom Navigation -->
<!-- Mobile Bottom Navigation -->

<div class="lg:hidden fixed bottom-0 left-0 right-0 z-[60]">
    <div class="bg-white border-t border-gray-200 shadow-lg px-2 pb-safe">
        <div class="flex justify-between items-center h-16">
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                </svg>
                <span class="text-[10px] font-medium">Dashboard</span>
            </a>

            <!-- HRMS -->
            @php
               $hrmsRoute = '#';
               if(auth()->user()->hasRole('admin') || auth()->user()->can('Attendance Records')) $hrmsRoute = route('attendance-record.index');
               elseif(auth()->user()->can('Leave Apply')) $hrmsRoute = route('employeeportal.index');
               elseif(auth()->user()->can('My Attendance')) $hrmsRoute = route('my-attendance.index');
               elseif(auth()->user()->can('Leave Record')) $hrmsRoute = route('adminportal.index');
               elseif(auth()->user()->can('salary')) $hrmsRoute = route('salary.index');
               
               $isHrms = request()->routeIs('attendance-record.index') || request()->routeIs('my-attendance.index') || request()->routeIs('employeeportal.index') || request()->routeIs('adminportal.index') || request()->routeIs('salary.index');
            @endphp
            @if(auth()->user()->hasRole('admin') || (auth()->user()->can('Attendance Records') || auth()->user()->can('My Attendance') || auth()->user()->can('Leave Apply') || auth()->user()->can('Leave Record') || auth()->user()->can('salary')))
            <a href="{{ $hrmsRoute }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ $isHrms ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-[10px] font-medium">HRMS</span>
            </a>
            @endif

            <!-- My Tickets -->
            @if(auth()->user()->hasRole('admin') || auth()->user()->can('help and support'))
            <a href="{{ route('helpandsupport.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('helpandsupport.index') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                <span class="text-[10px] font-medium">Tickets</span>
            </a>
            @endif

            <!-- All (Sidebar Toggle) -->
            <button onclick="toggleMobileSidebar()" class="flex flex-col items-center justify-center w-full h-full space-y-1 text-gray-500 hover:text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="text-[10px] font-medium">All</span>
            </button>

            <!-- Profile -->
            <a href="{{ route('profile.view') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('profile.view') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-[10px] font-medium">Profile</span>
            </a>
            
        </div>
    </div>
</div>

<!-- Mobile Sidebar Backdrop -->
<div id="mobile-sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-gray-900/50 z-40 hidden lg:hidden transition-opacity"></div>

<script>
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('desktop-sidebar');
        const backdrop = document.getElementById('mobile-sidebar-backdrop');
        
        if (sidebar.classList.contains('hidden')) {
            // Show sidebar
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
            backdrop.classList.remove('hidden');
        } else {
            // Hide sidebar
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
            backdrop.classList.add('hidden');
        }
    }
</script>



<style>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>