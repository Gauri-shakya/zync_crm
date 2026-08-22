@extends('components.layout')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Closed Deals (Won) ✨</h1>
            <p class="text-slate-500 text-sm mt-1">All converted leads and their financial details.</p>
        </div>
    </div>

    <!-- Filter Options -->
    <div class="bg-white shadow-sm rounded-sm border border-slate-200 mb-6 p-4 md:p-5">
        <form method="GET" action="{{ route('myleads.closed') }}" class="flex flex-col lg:flex-row gap-4">
            <!-- Search Client (Searchable) -->
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Search Client</label>
                <div class="relative custom-dropdown" data-name="search">
                    <input type="hidden" name="search" id="search-hidden" value="{{ request('search') }}">
                    <div class="relative">
                        <input type="text" value="{{ request('search') }}" autocomplete="off" placeholder="Type or select client..." class="dropdown-input w-full form-input text-sm rounded-md border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 pl-9 pr-8 cursor-text shadow-sm transition-shadow">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-transform duration-200 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-md shadow-lg hidden dropdown-menu" style="max-height: 250px; overflow-y: auto;">
                        <ul class="py-1 text-sm text-slate-700 options-list">
                            @foreach($clientsList as $c)
                                <li data-value="{{ $c->company_name }}" class="px-3 py-2 cursor-pointer hover:bg-indigo-50 hover:text-indigo-600 transition-colors dropdown-item border-b border-slate-50 last:border-0">
                                    <div class="font-medium truncate">{{ $c->company_name }}</div>
                                    @if($c->contact_person)
                                    <div class="text-[10px] text-slate-400 truncate">{{ $c->contact_person }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <div class="px-3 py-2 text-sm text-slate-400 hidden no-results text-center">No matches found</div>
                    </div>
                </div>
            </div>

            <!-- Service Filter (Searchable) -->
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Service</label>
                <div class="relative custom-dropdown" data-name="service_name">
                    <input type="hidden" name="service_name" id="service-hidden" value="{{ request('service_name') }}">
                    <div class="relative">
                        <input type="text" value="{{ request('service_name') }}" autocomplete="off" placeholder="Type or select service..." class="dropdown-input w-full form-input text-sm rounded-md border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 pl-9 pr-8 cursor-text shadow-sm transition-shadow">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-transform duration-200 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-md shadow-lg hidden dropdown-menu" style="max-height: 250px; overflow-y: auto;">
                        <ul class="py-1 text-sm text-slate-700 options-list">
                            @foreach($servicesList as $s)
                                <li data-value="{{ $s }}" class="px-3 py-2 cursor-pointer hover:bg-indigo-50 hover:text-indigo-600 transition-colors dropdown-item">
                                    <div class="font-medium truncate">{{ $s }}</div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="px-3 py-2 text-sm text-slate-400 hidden no-results text-center">No matches found</div>
                    </div>
                </div>
            </div>

            <!-- Date Range -->
            <div class="flex-[1.5]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Date Range</label>
                <div class="flex flex-col sm:flex-row items-center gap-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full sm:w-1/2 form-input text-sm rounded-md border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="text-slate-400 hidden sm:block">-</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full sm:w-1/2 form-input text-sm rounded-md border-slate-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2 lg:w-48 shrink-0">
                <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full py-2 px-3 rounded-md text-sm font-medium transition-colors shadow-sm">
                    Filter
                </button>
                <a href="{{ route('myleads.closed') }}" class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-600 w-full py-2 px-3 rounded-md text-sm font-medium text-center transition-colors shadow-sm">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-semibold text-slate-800">Sales Records <span class="text-slate-400 font-medium">({{ $closedLeads->total() }})</span></h2>
        </header>
        <div class="p-3">
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Client</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Service</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Closed By</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Date</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right">Total Amount</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right">Paid</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right">Due</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Status</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Actions</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200">
                        @forelse($closedLeads as $sale)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-800">{{ $sale->lead->client->company_name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">{{ $sale->lead->client->email ?? '' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left font-medium text-indigo-500">{{ $sale->service_name }}</div>
                                <div class="text-xs text-slate-500 capitalize">{{ str_replace('_', ' ', $sale->payment_type) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left text-slate-700">{{ $sale->user->name ?? 'Unknown' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $sale->closed_date->format('d M, Y') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right font-medium text-emerald-600">₹{{ number_format($sale->total_amount, 2) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right text-slate-700">₹{{ number_format($sale->paid_amount, 2) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right text-rose-500 font-medium">₹{{ number_format($sale->due_amount, 2) }}</div>
                                @if($sale->due_amount > 0 && $sale->next_payment_date)
                                    <div class="text-[10px] text-slate-400">Due: {{ $sale->next_payment_date->format('d M') }}</div>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center">
                                                @if($sale->due_amount <= 0)
                                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                                        Fully Paid
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                                        Due Pending
                                                    </span>
                                                @endif
                                                @if($sale->updated_by)
                                                    <div class="mt-1 text-[10px] text-slate-500 italic">
                                                        Updated by {{ $sale->updater->name ?? 'Admin' }}
                                                    </div>
                                                @endif
                                            </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center flex items-center justify-center gap-2">
                                    <a href="{{ route('myleads.show', $sale->lead_id) }}" class="text-emerald-500 hover:text-emerald-600 bg-emerald-50 hover:bg-emerald-100 p-1.5 rounded-full transition-colors" title="Open Lead">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin') || $sale->user_id == Auth::id())
                                        <button onclick="document.getElementById('edit-modal-{{ $sale->id }}').classList.remove('hidden')" class="text-indigo-500 hover:text-indigo-600 bg-indigo-50 hover:bg-indigo-100 p-1.5 rounded-full transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for this sale -->
                        <div id="edit-modal-{{ $sale->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('edit-modal-{{ $sale->id }}').classList.add('hidden')"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                                    Edit Closed Lead
                                                </h3>
                                                <form method="POST" action="{{ route('myleads.closed.update', $sale->id) }}" id="edit-form-{{ $sale->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Service Name</label>
                                                            <select name="service_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                                <option value="">-- Select Type --</option>
                                                                @foreach($servicesList as $s)
                                                                    <option value="{{ $s }}" {{ $sale->service_name == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Closed Date</label>
                                                            <input type="date" name="closed_date" value="{{ $sale->closed_date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Payment Type</label>
                                                            <select name="payment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                                <option value="one_time" {{ $sale->payment_type == 'one_time' ? 'selected' : '' }}>One Time</option>
                                                                <option value="recurring" {{ $sale->payment_type == 'recurring' ? 'selected' : '' }}>Recurring</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                                                            <input type="number" step="0.01" name="total_amount" value="{{ $sale->total_amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Paid Amount</label>
                                                            <input type="number" step="0.01" name="paid_amount" value="{{ $sale->paid_amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Due Amount</label>
                                                            <input type="number" step="0.01" name="due_amount" value="{{ $sale->due_amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <label class="block text-sm font-medium text-gray-700">Next Payment Date (If Due)</label>
                                                            <input type="date" name="next_payment_date" value="{{ $sale->next_payment_date ? $sale->next_payment_date->format('Y-m-d') : '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" form="edit-form-{{ $sale->id }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Save Changes
                                        </button>
                                        <button type="button" onclick="document.getElementById('edit-modal-{{ $sale->id }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-8 text-center text-slate-500">
                                No closed deals found yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $closedLeads->links() }}
    </div>
</div>

<style>
    /* Custom scrollbar for dropdowns */
    .dropdown-menu::-webkit-scrollbar {
        width: 6px;
    }
    .dropdown-menu::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .dropdown-menu::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .dropdown-menu::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.custom-dropdown');

    dropdowns.forEach(dropdown => {
        const input = dropdown.querySelector('.dropdown-input');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        const menu = dropdown.querySelector('.dropdown-menu');
        const items = dropdown.querySelectorAll('.dropdown-item');
        const noResults = dropdown.querySelector('.no-results');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        
        // Show menu when focusing input
        input.addEventListener('focus', () => {
            menu.classList.remove('hidden');
            arrow.style.transform = 'translateY(-50%) rotate(180deg)';
        });

        // Hide menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                menu.classList.add('hidden');
                arrow.style.transform = 'translateY(-50%) rotate(0deg)';
                
                // If input text doesn't match a selection perfectly, reset to hidden value
                let isMatch = false;
                items.forEach(item => {
                    if(item.getAttribute('data-value').toLowerCase() === input.value.trim().toLowerCase()) {
                        isMatch = true;
                    }
                });
                
                if(!isMatch && input.value.trim() !== '') {
                    // Optional: could clear it or leave it as a free-text search.
                    // For now, we allow free-text search.
                    hiddenInput.value = input.value;
                } else if (input.value.trim() === '') {
                    hiddenInput.value = '';
                }
            }
        });

        // Filter items on type
        input.addEventListener('input', (e) => {
            const filter = e.target.value.toLowerCase();
            let hasVisible = false;
            
            // Also update hidden input for free-text search
            hiddenInput.value = e.target.value;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(filter)) {
                    item.style.display = 'block';
                    hasVisible = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (hasVisible) {
                noResults.classList.add('hidden');
            } else {
                noResults.classList.remove('hidden');
            }
        });

        // Select item
        items.forEach(item => {
            item.addEventListener('click', () => {
                const value = item.getAttribute('data-value');
                input.value = value;
                hiddenInput.value = value;
                menu.classList.add('hidden');
                arrow.style.transform = 'translateY(-50%) rotate(0deg)';
                
                // Optional: Automatically submit form on select
                // dropdown.closest('form').submit();
            });
        });
    });
});
</script>

@endsection
