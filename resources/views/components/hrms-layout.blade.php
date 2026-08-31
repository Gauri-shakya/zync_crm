@extends('components.layout')

@section('content')
<div class="mb-6">
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-2 overflow-x-auto overflow-y-hidden scrollbar-hide">
        <div class="flex items-center space-x-2 min-w-max">
            
            @if(auth()->user()->hasRole('admin') || auth()->user()->can('Attendance Records'))
                <a href="{{ route('attendance-record.index') }}" 
                   class="relative flex items-center px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 ease-out group {{ request()->routeIs('attendance-record.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <div class="icon-wrapper w-8 h-8 rounded-full flex items-center justify-center {{ request()->routeIs('attendance-record.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-blue-100 text-blue-500' }} group-hover:scale-110 transition-transform duration-300 mr-2 shadow-sm">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <span>Attendance Records</span>
                    @if(request()->routeIs('attendance-record.*'))
                        <span class="absolute inset-x-0 -bottom-2 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-lg mx-2"></span>
                    @endif
                </a>
            @endif

            @if(auth()->user()->hasRole('admin') || auth()->user()->can('My Attendance'))
                <a href="{{ route('my-attendance.index') }}" 
                   class="relative flex items-center px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 ease-out group {{ request()->routeIs('my-attendance.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <div class="icon-wrapper w-8 h-8 rounded-full flex items-center justify-center {{ request()->routeIs('my-attendance.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-emerald-100 text-emerald-500' }} group-hover:scale-110 transition-transform duration-300 mr-2 shadow-sm">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span>My Attendance</span>
                    @if(request()->routeIs('my-attendance.*'))
                        <span class="absolute inset-x-0 -bottom-2 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-lg mx-2"></span>
                    @endif
                </a>
            @endif

            @if(auth()->user()->hasRole('admin') || auth()->user()->can('Leave Apply'))
                <a href="{{ route('employeeportal.index') }}" 
                   class="relative flex items-center px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 ease-out group {{ request()->routeIs('employeeportal.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <div class="icon-wrapper w-8 h-8 rounded-full flex items-center justify-center {{ request()->routeIs('employeeportal.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-amber-100 text-amber-500' }} group-hover:scale-110 transition-transform duration-300 mr-2 shadow-sm">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <span>Leave Apply</span>
                    @if(request()->routeIs('employeeportal.*'))
                        <span class="absolute inset-x-0 -bottom-2 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-lg mx-2"></span>
                    @endif
                </a>
            @endif

            @if(auth()->user()->hasRole('admin') || auth()->user()->can('Leave Record'))
                <a href="{{ route('adminportal.index') }}" 
                   class="relative flex items-center px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 ease-out group {{ request()->routeIs('adminportal.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <div class="icon-wrapper w-8 h-8 rounded-full flex items-center justify-center {{ request()->routeIs('adminportal.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-rose-100 text-rose-500' }} group-hover:scale-110 transition-transform duration-300 mr-2 shadow-sm">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <span>Leave Record</span>
                    @if(request()->routeIs('adminportal.*'))
                        <span class="absolute inset-x-0 -bottom-2 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-lg mx-2"></span>
                    @endif
                </a>
            @endif

            @if(auth()->user()->hasRole('admin') || auth()->user()->can('salary'))
                <a href="{{ route('salary.index') }}" 
                   class="relative flex items-center px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 ease-out group {{ request()->routeIs('salary.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <div class="icon-wrapper w-8 h-8 rounded-full flex items-center justify-center {{ request()->routeIs('salary.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-teal-100 text-teal-500' }} group-hover:scale-110 transition-transform duration-300 mr-2 shadow-sm">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <span>Salary</span>
                    @if(request()->routeIs('salary.*'))
                        <span class="absolute inset-x-0 -bottom-2 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-lg mx-2"></span>
                    @endif
                </a>
            @endif

        </div>
    </div>
</div>

<div class="hrms-content-wrapper fade-in-up">
    @yield('hrms-content')
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .icon-wrapper {
        animation: pulse-soft 2s infinite ease-in-out alternate;
    }
    .icon-wrapper:hover {
        animation: none;
        transform: scale(1.15) translateY(-2px);
    }
    @keyframes pulse-soft {
        0% { transform: scale(1); }
        100% { transform: scale(1.05); }
    }
</style>
@endsection
