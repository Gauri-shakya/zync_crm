@extends('components.layout')

@section('content')

<main class="min-h-screen bg-[#f8fafc] py-8 sm:py-12 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto space-y-8">
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="animate-fade-in">
                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="bg-emerald-500 rounded-full p-1">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Main Profile Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: User Card -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden group">
                    <!-- Decorative Header -->
                    <div class="h-32 bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 relative overflow-hidden">
                        <div class="absolute inset-0 opacity-40">
                            <div class="absolute top-[-50%] left-[-20%] w-64 h-64 bg-white rounded-full blur-3xl"></div>
                            <div class="absolute bottom-[-50%] right-[-20%] w-64 h-64 bg-blue-200 rounded-full blur-3xl"></div>
                        </div>
                    </div>
                    
                    <div class="px-8 pb-10 text-center relative">
                        <!-- Avatar -->
                        <div class="relative inline-block -mt-16 mb-6">
                            <div class="w-32 h-32 bg-white rounded-full shadow-xl p-1 transition-transform duration-500 group-hover:scale-105 border border-gray-100">
                                <div class="w-full h-full bg-white rounded-full flex items-center justify-center border border-gray-50 overflow-hidden relative group/avatar">
                                    @if(Auth::user()->company && Auth::user()->company->logo)
                                        <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Company Logo" class="w-full h-full object-contain">
                                    @else
                                        <span class="text-gray-700 font-black text-4xl tracking-tighter relative z-10">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    @endif
                                    <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover/avatar:opacity-100 transition-opacity"></div>
                                </div>
                            </div>
                            <!-- Active Status -->
                            <div class="absolute bottom-2 right-2 w-6 h-6 bg-white rounded-full p-1 shadow-lg border border-gray-50">
                                <div class="w-full h-full bg-emerald-400 rounded-full"></div>
                            </div>
                        </div>

                        <!-- Basic Info -->
                        <div class="space-y-1">
                            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">{{ Auth::user()->name }}</h1>
                            @if(Auth::user()->company)
                                <p class="text-sm font-semibold text-gray-500">{{ Auth::user()->company->name }}</p>
                            @endif
                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">{{ Auth::user()->status }} member</p>
                        </div>

                        <div class="mt-8 pt-8 border-t border-gray-50 grid grid-cols-2 gap-4">
                            <div class="text-center p-3 rounded-2xl bg-gray-50/50 border border-gray-100/50">
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Since</p>
                                <p class="text-sm font-bold text-gray-700 mt-1">{{ Auth::user()->created_at->format('M Y') }}</p>
                            </div>
                            <div class="text-center p-3 rounded-2xl bg-gray-50/50 border border-gray-100/50">
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Identity</p>
                                <p class="text-sm font-bold text-gray-700 mt-1">#{{ Auth::user()->id }}</p>
                            </div>
                        </div>

                        <!-- Primary Actions -->
                        <div class="mt-8 space-y-3">
                            <a href="/profile/edit" 
                               class="w-full flex items-center justify-center gap-2 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95 group/btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Profile
                            </a>
                            
                            <form method="GET" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 py-4 bg-white border border-gray-100 text-gray-400 font-bold rounded-2xl hover:bg-gray-50 hover:text-gray-600 transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Detailed Info -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Information Cards -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 p-8 sm:p-10 relative overflow-hidden group">
                   

                    <div class="relative space-y-12">
                        <!-- Personal Details Section -->
                        <section>
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100/50">
                                    <i class="fas fa-id-card text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-700 tracking-tight">Personal Identity</h3>
                                    <p class="text-sm font-medium text-gray-400 mt-0.5">Your core account identity and contact details</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                <div class="group/item">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2 group-hover/item:text-blue-500 transition-colors">Full Username</label>
                                    <div class="flex items-center gap-3">
                                        <p class="text-lg font-bold text-gray-800 tracking-tight">{{ Auth::user()->name }}</p>
                                        <div class="h-1.5 w-1.5 rounded-full bg-blue-200"></div>
                                    </div>
                                </div>
                                
                                <div class="group/item">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2 group-hover/item:text-blue-500 transition-colors">Email Address</label>
                                    <div class="flex items-center gap-3">
                                        <p class="text-lg font-bold text-gray-800 tracking-tight">{{ Auth::user()->email }}</p>
                                        <div class="h-1.5 w-1.5 rounded-full bg-blue-200"></div>
                                    </div>
                                </div>

                                <div class="group/item sm:col-span-2">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2 group-hover/item:text-blue-500 transition-colors">Security Status</label>
                                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-emerald-50 rounded-xl border border-emerald-100 shadow-sm shadow-emerald-900/5">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                        <span class="text-sm font-black text-emerald-700 uppercase tracking-wider">{{ Auth::user()->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Activity Tracking Section -->
                        <section class="pt-12 border-t border-gray-100">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100/50">
                                    <i class="fas fa-history text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-700 tracking-tight">Activity & Timeline</h3>
                                    <p class="text-sm font-medium text-gray-400 mt-0.5">Tracking your history within our ecosystem</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                                <div class="relative pl-6 border-l-2 border-indigo-50">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white border-4 border-indigo-500 shadow-sm"></div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Member Since</label>
                                    <p class="text-lg font-bold text-gray-800 tracking-tight">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs font-bold text-indigo-500 mt-1 uppercase tracking-wider">{{ Auth::user()->created_at->diffForHumans() }}</p>
                                </div>
                                
                                <div class="relative pl-6 border-l-2 border-gray-100">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white border-4 border-gray-200 shadow-sm"></div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Last Activity</label>
                                    <p class="text-lg font-bold text-gray-800 tracking-tight">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                                    <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-wider">Profile Updated</p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-lg shadow-blue-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-check text-sm"></i>
                        </div>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ (int) Auth::user()->created_at->diffInDays(now()) }}</p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Days Active</p>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-lg shadow-indigo-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-rocket text-sm"></i>
                        </div>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ Auth::user()->created_at->format('Y') }}</p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Launch Year</p>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-lg shadow-violet-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-tag text-sm"></i>
                        </div>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ Auth::user()->id }}</p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Global ID</p>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-lg shadow-emerald-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-shield-alt text-sm"></i>
                        </div>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">100%</p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Verified</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    main {
        font-family: 'Plus+Jakarta+Sans', sans-serif;
    }

    .animate-fade-in {
        animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection