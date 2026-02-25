@extends('components.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div class="space-y-1">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Support Center</h1>
                <p class="text-sm font-medium text-gray-500">Track and manage your inquiries with our expert team</p>
            </div>
            <button onclick="document.getElementById('createTicketModal').classList.remove('hidden')"
                class="group flex items-center justify-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-2xl hover:bg-blue-600 font-bold transition-all shadow-xl shadow-gray-900/10 active:scale-95 whitespace-nowrap">
                <i class="fas fa-plus text-xs group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Open New Ticket</span>
            </button>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mb-8 flex items-center gap-3 animate-slide-up">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Tickets Dashboard -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-blue-900/5 overflow-hidden transition-all">
            <!-- Desktop View -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Ticket Identity</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Subject & Category</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Last Activity</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Management</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($tickets as $ticket)
                            <tr class="group hover:bg-blue-50/30 transition-all duration-300">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-50 text-blue-600 text-xs font-black tracking-tight">
                                        #{{ $ticket->ticket_id }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ Str::limit($ticket->title, 50) }}</div>
                                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $ticket->category }}</div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'open' => 'bg-blue-100 text-blue-700 shadow-blue-100/50',
                                            'in-progress' => 'bg-amber-100 text-amber-700 shadow-amber-100/50',
                                            'completed' => 'bg-emerald-100 text-emerald-700 shadow-emerald-100/50',
                                            'closed' => 'bg-gray-100 text-gray-600 shadow-gray-100/50'
                                        ];
                                        $currentClass = $statusClasses[$ticket->status] ?? $statusClasses['closed'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm {{ $currentClass }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                                        <i class="far fa-clock text-[10px]"></i>
                                        {{ $ticket->updated_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    <a href="{{ route('user.support.ticket.show', $ticket->id) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all active:scale-95 shadow-lg shadow-gray-900/10">
                                        Focus Details
                                        <i class="fas fa-arrow-right text-[8px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-3xl bg-gray-50 flex items-center justify-center text-gray-300">
                                            <i class="fas fa-inbox text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">No Tickets Detected</p>
                                            <p class="text-xs text-gray-500 mt-1">Your support history is currently empty.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden divide-y divide-gray-50">
                @forelse($tickets as $ticket)
                    <div class="p-6 space-y-4 hover:bg-blue-50/30 transition-colors">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-blue-600 tracking-widest bg-blue-50 px-2 py-1 rounded-lg">#{{ $ticket->ticket_id }}</span>
                            <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider
                                {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-700' :
                                ($ticket->status === 'in-progress' ? 'bg-amber-100 text-amber-700' :
                                ($ticket->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600')) }}">
                                {{ $ticket->status }}
                            </span>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-sm font-bold text-gray-900 break-words">{{ $ticket->title }}</h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $ticket->category }}</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1.5">
                                <i class="far fa-clock"></i>{{ $ticket->updated_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('user.support.ticket.show', $ticket->id) }}" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-gray-900/10">
                                View
                                <i class="fas fa-chevron-right text-[8px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">No active inquiries</p>
                    </div>
                @endforelse
            </div>

            @if($tickets->hasPages())
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create Ticket Modal -->
    <div id="createTicketModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50 animate-fade-in">
        <div class="relative top-10 mx-auto p-0 border-0 w-full max-w-2xl shadow-2xl rounded-[2.5rem] bg-white overflow-hidden mb-10">
            <!-- Modal Header -->
            <div class="px-10 py-8 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight">Initiate Support</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">Our technical experts are standing by to assist</p>
                </div>
                <button onclick="document.getElementById('createTicketModal').classList.add('hidden')"
                    class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-900 transition-all shadow-sm hover:rotate-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('user.support.ticket.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf
                <div class="space-y-6">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Inquiry Subject</label>
                        <input type="text" name="title" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                            placeholder="Briefly describe the challenge...">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Priority Level</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach(['low' => 'Standard', 'medium' => 'Elevated', 'high' => 'Critical', 'urgent' => 'Emergency'] as $value => $label)
                                <label class="relative flex flex-col items-center p-4 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-blue-200 transition-all group has-[:checked]:bg-white has-[:checked]:border-blue-500 has-[:checked]:ring-4 has-[:checked]:ring-blue-500/10">
                                    <input type="radio" name="priority" value="{{ $value }}" {{ $value === 'low' ? 'checked' : '' }} class="sr-only">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-blue-600 transition-colors">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Related Domains <span class="normal-case font-medium text-gray-400">(Optional)</span></label>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach(($permissions ?? []) as $perm)
                                <label class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-white hover:border-blue-200 transition-all cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="w-5 h-5 text-blue-600 border-gray-200 rounded-lg focus:ring-blue-500/20">
                                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900 transition-colors">{{ ucwords(str_replace(['-', '_'], ' ', $perm)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Detailed Description</label>
                        <textarea name="description" rows="5" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none"
                            placeholder="Provide comprehensive details to help our team resolve this faster..."></textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Supporting Documentation</label>
                        <div class="group relative mt-1 flex justify-center px-8 pt-8 pb-10 border-2 border-gray-100 border-dashed rounded-[2rem] bg-gray-50 hover:bg-white hover:border-blue-300 transition-all">
                            <div class="space-y-2 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-white border border-gray-100 flex items-center justify-center text-blue-500 mx-auto shadow-sm group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                </div>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md font-black text-blue-600 hover:text-blue-700">
                                        <span>Click to Upload</span>
                                        <input id="file-upload" name="attachments[]" type="file" multiple class="sr-only">
                                    </label>
                                    <p class="pl-1 font-bold">or drag and drop</p>
                                </div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">PNG, JPG, PDF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row justify-end gap-4">
                    <button type="button" onclick="document.getElementById('createTicketModal').classList.add('hidden')"
                        class="w-full sm:w-auto px-8 py-4 text-sm font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Discard</button>
                    <button type="submit"
                        class="w-full sm:w-auto bg-gray-900 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-gray-900/10 active:scale-95">
                        Launch Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
