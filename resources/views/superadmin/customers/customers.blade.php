@extends('superadmin.layout.app')

@section('title', 'Customers')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Customer Management</h1>
        <p class="text-gray-600">View and manage all your CRM customers</p>
    </div>
   
</div>

<!-- Customer Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($customers as $customer)
                <tr>
                    <td class="py-3 px-6">
                        <div class="flex items-center">
                            @if($customer->logo)
                                <img src="{{ asset('storage/' . $customer->logo) }}" class="w-8 h-8 rounded-full mr-3 object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 mr-3 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-800">{{ $customer->name }}</p>
                                <p class="text-sm text-gray-500">{{ $customer->user->name ?? 'No Admin' }}</p> 
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        <span class="text-gray-800">{{ $customer->user->email ?? $customer->email }}</span>
                    </td>
                    <td class="py-3 px-6">
                        <span class="text-gray-800">{{ $customer->phone ?? 'N/A' }}</span>
                    </td>
                    <td class="py-3 px-6">
                        @if($customer->is_paid)
                            <span class="text-green-600 font-medium">Paid Plan</span>
                        @elseif($customer->trial_ends_at && $customer->trial_ends_at->isFuture())
                            <span class="text-blue-600">Trial (Ends {{ $customer->trial_ends_at->format('M d') }})</span>
                        @else
                            <span class="text-red-600">Expired/Free</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        <span class="status-badge status-{{ $customer->status }}">{{ ucfirst($customer->status) }}</span>
                    </td>
                    <td class="py-3 px-6">
                        <span class="font-medium text-gray-800">₹{{ number_format($customer->payments->sum('amount')) }}</span>
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('superadmin.customers.show', encrypt($customer->id)) }}" class="p-1 text-blue-600 hover:text-blue-800" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('superadmin.customers.edit', encrypt($customer->id)) }}" class="p-1 text-green-600 hover:text-green-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('superadmin.customers.destroy', encrypt($customer->id)) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure? This will delete the Company and all data.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="block md:hidden">
        <div class="divide-y divide-gray-100">
            @foreach($customers as $customer)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        @if($customer->logo)
                            <img src="{{ asset('storage/' . $customer->logo) }}" class="w-10 h-10 rounded-full mr-3 object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 mr-3 flex items-center justify-center text-white font-bold">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-gray-900">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-500">{{ $customer->user->name ?? 'No Admin' }}</p>
                        </div>
                    </div>
                    <span class="status-badge status-{{ $customer->status }} scale-90 origin-right">{{ ucfirst($customer->status) }}</span>
                </div>
                
                <div class="grid grid-cols-2 gap-y-3 mb-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Email</p>
                        <p class="text-gray-700 truncate pr-2">{{ $customer->user->email ?? $customer->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Phone</p>
                        <p class="text-gray-700">{{ $customer->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Plan</p>
                        @if($customer->is_paid)
                            <span class="text-green-600 font-medium">Paid Plan</span>
                        @elseif($customer->trial_ends_at && $customer->trial_ends_at->isFuture())
                            <span class="text-blue-600">Trial (Ends {{ $customer->trial_ends_at->format('M d') }})</span>
                        @else
                            <span class="text-red-600">Expired/Free</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Paid</p>
                        <p class="font-bold text-gray-900">₹{{ number_format($customer->payments->sum('amount')) }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex space-x-3">
                        <a href="{{ route('superadmin.customers.show', encrypt($customer->id)) }}" class="flex items-center text-blue-600 font-bold text-xs uppercase tracking-widest">
                            <i class="fas fa-eye mr-1.5"></i> View
                        </a>
                        <a href="{{ route('superadmin.customers.edit', encrypt($customer->id)) }}" class="flex items-center text-green-600 font-bold text-xs uppercase tracking-widest">
                            <i class="fas fa-edit mr-1.5"></i> Edit
                        </a>
                    </div>
                    <form action="{{ route('superadmin.customers.destroy', encrypt($customer->id)) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center text-red-600 font-bold text-xs uppercase tracking-widest" onclick="return confirm('Are you sure? This will delete the Company and all data.')">
                            <i class="fas fa-trash mr-1.5"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="px-6 py-4 border-t border-gray-200">
        {{ $customers->links() }}
    </div>
</div>


@endsection