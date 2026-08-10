@extends('components.layout')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Upgrade Your Experience
                </h2>
                <p class="mt-4 text-xl text-gray-500">
                    Compare plans and choose the best fit for your business growth.
                </p>
            </div>

           

            @if($isTrial)
                <div class="mb-8 bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-amber-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-amber-700">
                                <span class="font-bold">Trial Active:</span> Your {{ $company->selected_plan === 'plan_pro' ? 'Pro' : 'Basic' }} trial ends in <span class="font-mono font-bold">{{ $trialRemaining }}</span>.
                                <br>
                                <span class="text-xs uppercase tracking-wider">Expires on: {{ $company->trial_ends_at->format('d M, Y H:i:s') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Comparison Table (Hidden on Mobile) -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th scope="col" class="px-6 py-8 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/3">
                                Features
                            </th>
                            <th scope="col" class="px-6 py-8 text-center w-1/3 bg-sky-50/50">
                                <div class="flex flex-col items-center">
                                    <span class="text-xl font-black text-sky-900">BASIC PLAN</span>
                                    <div class="mt-2 flex items-baseline">
                                        <span class="text-3xl font-bold text-sky-600">₹1999</span>
                                        <span class="ml-1 text-gray-500 text-sm">/month</span>
                                    </div>
                                    @if($company->selected_plan === 'plan_basic' && $company->is_paid)
                                        <span class="mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-tighter">Active Plan</span>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-8 text-center w-1/3 bg-indigo-50/50">
                                <div class="flex flex-col items-center">
                                    <span class="text-xl font-black text-indigo-900">PRO PLAN</span>
                                    <div class="mt-2 flex items-baseline">
                                        <span class="text-3xl font-bold text-indigo-600">₹4999</span>
                                        <span class="ml-1 text-gray-500 text-sm">/month</span>
                                    </div>
                                    @if($company->selected_plan === 'plan_pro' && $company->is_paid)
                                        <span class="mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-tighter">Active Plan</span>
                                    @endif
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">Team Members</td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-center text-gray-600 bg-sky-50/20">Up to 10 Users</td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-center text-gray-600 bg-indigo-50/20 font-bold">Up to 30 Users</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">Full CRM Suite</td>
                            <td class="px-6 py-5 whitespace-nowrap text-center bg-sky-50/20"><i class="fas fa-check-circle text-green-500 text-xl"></i></td>
                            <td class="px-6 py-5 whitespace-nowrap text-center bg-indigo-50/20"><i class="fas fa-check-circle text-green-500 text-xl"></i></td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">Support Type</td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-center text-gray-600 bg-sky-50/20">Standard Support</td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-center text-indigo-600 bg-indigo-50/20 font-bold">Priority 24/7</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-8 bg-gray-50"></td>
                            <td class="px-6 py-8 text-center bg-sky-50/50">
                                @if($company->is_paid && $company->selected_plan === 'plan_basic')
                                    <button disabled class="w-full py-4 px-6 rounded-xl font-bold text-gray-400 bg-white border border-gray-200 cursor-not-allowed">
                                        Current Plan
                                    </button>
                                @else
                                    <button onclick="payNow('plan_basic', 1999)" class="w-full py-4 px-6 rounded-xl font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-lg shadow-sky-100 transition-all transform hover:-translate-y-1">
                                        Activate Basic
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-8 text-center bg-indigo-50/50">
                                @if($company->is_paid && $company->selected_plan === 'plan_pro')
                                    <button disabled class="w-full py-4 px-6 rounded-xl font-bold text-gray-400 bg-white border border-gray-200 cursor-not-allowed">
                                        Current Plan
                                    </button>
                                @else
                                    <button onclick="payNow('plan_pro', 4999)" class="w-full py-4 px-6 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
                                        Activate Pro
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden space-y-6">
                <!-- Basic Plan -->
                 <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                     <div class="p-6 bg-sky-50 text-center">
                         <h3 class="text-xl font-black text-sky-900">BASIC PLAN</h3>
                         <p class="text-3xl font-bold text-sky-600 mt-2">₹1999<span class="text-sm text-gray-500 font-normal">/mo</span></p>
                     </div>
                     <div class="p-6 space-y-4">
                         <div class="flex justify-between text-sm"><span class="text-gray-500">Users</span><span class="font-bold">Up to 10</span></div>
                         <div class="flex justify-between text-sm"><span class="text-gray-500">Support</span><span class="font-bold">Standard</span></div>
                         @if($company->is_paid && $company->selected_plan === 'plan_basic')
                             <button disabled class="w-full py-3 rounded-xl font-bold bg-gray-100 text-gray-400">Current Plan</button>
                         @else
                             <button onclick="payNow('plan_basic', 1999)" class="w-full py-3 rounded-xl font-bold bg-sky-600 text-white shadow-md">Activate Basic</button>
                         @endif
                     </div>
                 </div>

                 <!-- Pro Plan -->
                 <div class="bg-white rounded-2xl shadow-lg border-2 border-indigo-500 overflow-hidden">
                     <div class="p-6 bg-indigo-50 text-center">
                         <h3 class="text-xl font-black text-indigo-900">PRO PLAN</h3>
                         <p class="text-3xl font-bold text-indigo-600 mt-2">₹4999<span class="text-sm text-gray-500 font-normal">/mo</span></p>
                     </div>
                     <div class="p-6 space-y-4">
                         <div class="flex justify-between text-sm"><span class="text-gray-500">Users</span><span class="font-bold">Up to 30</span></div>
                         <div class="flex justify-between text-sm"><span class="text-gray-500">Support</span><span class="font-bold">Priority 24/7</span></div>
                         @if($company->is_paid && $company->selected_plan === 'plan_pro')
                             <button disabled class="w-full py-3 rounded-xl font-bold bg-gray-100 text-gray-400">Current Plan</button>
                         @else
                             <button onclick="payNow('plan_pro', 4999)" class="w-full py-3 rounded-xl font-bold bg-indigo-600 text-white shadow-md">Activate Pro</button>
                         @endif
                     </div>
                 </div>
            </div>

            {{-- Include the Razorpay Script Logic from the pricing partial --}}
            <div class="hidden">
                @include('admin.partials.pricing')
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mt-12">
                <div class="px-4 sm:px-6 py-5 border-b border-gray-200 bg-sky-50">
                    <h3 class="text-lg font-bold leading-6 text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-sky-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        My Active Plan
                    </h3>
                </div>
                <div class="px-4 sm:px-6 py-5">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-4 text-sm font-medium text-gray-500 w-1/2 sm:w-1/3">Current Plan</td>
                                <td class="py-4 text-sm text-gray-900 font-bold">
                                    @if($isTrial)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Trial Plan
                                        </span>
                                    @elseif($company->is_paid)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Premium Plan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Free / Expired
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm font-medium text-gray-500">Account Status</td>
                                <td class="py-4 text-sm text-gray-900">
                                    @if($isTrial)
                                        <span class="text-amber-600 font-semibold">Active (Trial)</span>
                                    @elseif($company->is_paid)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive / Expired</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 text-sm font-medium text-gray-500">Valid Until</td>
                                <td class="py-4 text-sm text-gray-900">
                                    @if($isTrial)
                                        <div class="flex flex-col sm:flex-row sm:items-center">
                                            <span>{{ \Carbon\Carbon::parse($company->trial_ends_at)->format('M d, Y') }}</span>
                                            <span class="text-gray-400 text-[10px] sm:text-xs mt-1 sm:mt-0 sm:ml-2">({{ $trialRemaining }} left)</span>
                                        </div>
                                    @elseif($company->is_paid)
                                        <span class="text-gray-600">Auto-renewal enabled</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Trust Badges / Extra Info -->
            <div class="mt-12 grid grid-cols-1 gap-6 sm:gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="pt-6">
                    <div class="flow-root bg-gray-50 rounded-xl px-6 pb-8">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-sky-500 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-bold text-gray-900 tracking-tight">Secure Payment</h3>
                            <p class="mt-4 text-sm sm:text-base text-gray-500 leading-relaxed">
                                All transactions are secured with industry-standard encryption.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="flow-root bg-gray-50 rounded-xl px-6 pb-8">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-sky-500 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-bold text-gray-900 tracking-tight">Instant Activation</h3>
                            <p class="mt-4 text-sm sm:text-base text-gray-500 leading-relaxed">
                                Get access to premium features immediately after upgrading.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="flow-root bg-gray-50 rounded-xl px-6 pb-8 sm:col-span-2 lg:col-span-1">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-sky-500 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-bold text-gray-900 tracking-tight">24/7 Support</h3>
                            <p class="mt-4 text-sm sm:text-base text-gray-500 leading-relaxed">
                                Our dedicated support team is here to help you succeed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
