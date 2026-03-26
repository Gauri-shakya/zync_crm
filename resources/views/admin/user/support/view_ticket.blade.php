@extends('components.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <!-- Breadcrumbs / Back -->
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('user.support.ticket.index') }}"
                class="group inline-flex items-center text-sm font-bold text-gray-600 hover:text-blue-600 transition-all">
                <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                </div>
                BACK TO SUPPORT CENTER
            </a>
            
            <div class="hidden sm:flex items-center gap-2">
                <span class="text-[11px] font-black text-gray-500 uppercase tracking-widest">Ticket ID:</span>
                <span class="text-[11px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg tracking-wider">#{{ $ticket->ticket_id }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Ticket Conversation (Main Content) -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Header Card -->
                <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
                    <div class="p-6 sm:p-8 border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-4">
                                    @php
                                        $statusClasses = [
                                            'open' => 'bg-blue-500 text-white',
                                            'in-progress' => 'bg-amber-500 text-white',
                                            'completed' => 'bg-emerald-500 text-white',
                                            'closed' => 'bg-slate-500 text-white'
                                        ];
                                        $currentClass = $statusClasses[$ticket->status] ?? 'bg-gray-500 text-white';
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider shadow-sm {{ $currentClass }}">
                                        {{ $ticket->status }}
                                    </span>
                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        Created {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">{{ $ticket->title }}</h1>
                                
                                <!-- Response Time Notice -->
                                <div class="mt-4 flex items-center gap-3 px-4 py-2 bg-amber-50 border border-amber-100 rounded-xl">
                                    <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                                    <p class="text-[11px] font-bold text-amber-700 uppercase tracking-wider">
                                        Expected response time: 24-48 hours from customer care.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="p-6 sm:p-8 bg-[#F9FAFB] min-h-[450px] max-h-[700px] overflow-y-auto space-y-8 custom-scrollbar" id="messages-container">
                        @foreach($ticket->conversations as $message)
                            @if(!$message['is_internal'])
                                @php $isMe = $message['user_id'] == auth()->id(); @endphp
                                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} animate-fade-in">
                                    <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} max-w-[85%] sm:max-w-[75%]">
                                        <div class="flex items-center gap-2 mb-2 px-1">
                                            @if(!$isMe)
                                                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-[10px] text-white font-bold shadow-sm">
                                                    A
                                                </div>
                                            @endif
                                            <span class="text-[11px] font-black text-gray-500 uppercase tracking-widest">
                                                {{ $isMe ? 'You' : 'Support Agent' }}
                                            </span>
                                            <span class="text-[11px] font-bold text-gray-400 local-time" data-time="{{ $message['created_at'] }}">
                                                {{ \Carbon\Carbon::parse($message['created_at'])->format('h:i A') }}
                                            </span>
                                        </div>
                                        
                                        <div class="relative group">
                                            <div class="p-4 sm:p-5 rounded-[1.5rem] shadow-sm {{ $isMe ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none' }}">
                                                <p class="text-sm leading-relaxed font-medium whitespace-pre-wrap">{{ $message['message'] }}</p>
                                            </div>
                                            
                                            @if(isset($message['attachments']) && count($message['attachments']) > 0)
                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    @foreach($message['attachments'] as $file)
                                                        <a href="{{ Storage::url($file['path']) }}" target="_blank"
                                                            class="flex items-center gap-2 px-3 py-1.5 rounded-full text-[11px] font-bold {{ $isMe ? 'bg-blue-700/50 text-blue-50 hover:bg-blue-700' : 'bg-white border border-gray-100 text-gray-500 hover:border-blue-200 hover:text-blue-600' }} transition-all shadow-sm">
                                                            <i class="fas fa-paperclip opacity-60"></i>
                                                            {{ Str::limit($file['name'], 20) }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Reply Area -->
                    @if($ticket->status !== 'closed')
                        <div class="p-6 sm:p-8 bg-white border-t border-gray-50">
                            <form action="{{ route('user.support.ticket.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="relative group">
                                    <textarea name="message" rows="4" placeholder="Write your response..."
                                        class="w-full rounded-[1.5rem] border-gray-100 border-2 p-5 focus:ring-4 focus:ring-blue-50/50 focus:border-blue-400 transition-all outline-none text-sm font-medium placeholder:text-gray-300 bg-gray-50/30 focus:bg-white"
                                        required></textarea>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-2">
                                    <div class="w-full sm:w-auto">
                                        <label class="group cursor-pointer flex items-center gap-3 px-5 py-3 rounded-2xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                                            <div class="w-8 h-8 rounded-xl bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-blue-500 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span id="file-label-text" class="text-[12px] font-black text-gray-500 group-hover:text-blue-600 uppercase tracking-widest">Attach Files</span>
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Max 10MB per file</span>
                                            </div>
                                            <input type="file" name="attachments[]" multiple class="hidden" id="file-upload">
                                        </label>
                                    </div>
                                    
                                    <button type="submit"
                                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-[0_10px_25px_-5px_rgba(37,99,235,0.4)] hover:shadow-[0_15px_30px_-5px_rgba(37,99,235,0.5)] active:scale-95 flex items-center justify-center gap-3">
                                        <span>Send Response</span>
                                        <i class="fas fa-paper-plane text-[10px]"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-10 bg-gray-50/50 border-t border-gray-50 text-center">
                            <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="fas fa-lock text-xl"></i>
                            </div>
                            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">Conversation Locked</h4>
                            <p class="text-xs font-bold text-gray-300 uppercase tracking-tighter">This ticket has been marked as resolved/closed.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar (Details & Metadata) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] border border-gray-50 p-8">
                    <h3 class="text-[12px] font-black text-gray-500 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        Ticket Intel
                    </h3>
                    
                    <div class="space-y-8">
                        <div>
                            <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest block mb-3">Priority Level</span>
                            @php
                                $priorityColors = [
                                    'urgent' => 'text-red-500 bg-red-50',
                                    'high' => 'text-orange-500 bg-orange-50',
                                    'medium' => 'text-blue-500 bg-blue-50',
                                    'low' => 'text-gray-600 bg-gray-50'
                                ];
                                $pColor = $priorityColors[$ticket->priority] ?? 'text-gray-600 bg-gray-50';
                            @endphp
                            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-xl {{ $pColor }} font-black text-[11px] uppercase tracking-wider">
                                <i class="fas fa-shield-alt text-[10px]"></i>
                                {{ $ticket->priority }}
                            </div>
                        </div>

                        @if(is_array($ticket->issue_permissions) && count($ticket->issue_permissions) > 0)
                        <div>
                            <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest block mb-3">Affected Areas</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($ticket->issue_permissions as $perm)
                                    <span class="px-3 py-1.5 text-[10px] font-black rounded-lg bg-gray-50 text-gray-600 border border-gray-100 uppercase tracking-wider">
                                        {{ str_replace(['-', '_'], ' ', $perm) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="pt-8 border-t border-gray-50 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Opened On</span>
                                <span class="text-[11px] font-bold text-gray-700">{{ $ticket->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Last Activity</span>
                                <span class="text-[11px] font-bold text-gray-700">{{ $ticket->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Tip -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-8 text-white shadow-[0_20px_40px_-10px_rgba(37,99,235,0.3)]">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-lightbulb text-sm"></i>
                    </div>
                    <h4 class="text-sm font-black uppercase tracking-widest mb-2">Pro Tip</h4>
                    <p class="text-[12px] font-bold leading-relaxed text-blue-50">Be as descriptive as possible and attach screenshots to help us resolve your issue faster.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File Upload UI
            const fileInput = document.getElementById('file-upload');
            const fileLabelText = document.getElementById('file-label-text');
            const originalText = fileLabelText.innerText;

            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    if (this.files.length === 1) {
                        fileLabelText.innerText = this.files[0].name;
                    } else {
                        fileLabelText.innerText = `${this.files.length} files selected`;
                    }
                    // Add a class to show active state
                    fileLabelText.parentElement.classList.add('text-blue-600', 'font-medium');
                } else {
                    fileLabelText.innerText = originalText;
                    fileLabelText.parentElement.classList.remove('text-blue-600', 'font-medium');
                }
            });

            // Live Chat Polling
            const messagesContainer = document.getElementById('messages-container');
            const ticketId = "{{ $ticket->id }}";
            const currentUserId = {{ auth()->id() }};
            
            // Helper function to format time in user's local timezone
            function formatLocalTime(dateString) {
                if (!dateString) return '';
                // Append UTC if the string doesn't have timezone info (assuming DB stores in UTC)
                let dateStr = dateString;
                if (!dateStr.endsWith('Z') && !dateStr.includes('+')) {
                    dateStr += ' UTC';
                }
                const date = new Date(dateStr);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            // Update initial times
            document.querySelectorAll('.local-time').forEach(el => {
                const rawTime = el.getAttribute('data-time');
                if (rawTime) {
                    el.innerText = formatLocalTime(rawTime);
                }
            });
            
            // Initialize message count from current DOM
            let lastMessageCount = messagesContainer.children.length;
            
            // Scroll to bottom initially
            scrollToBottom();

            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            function fetchMessages() {
                fetch(`{{ route('user.support.ticket.messages', $ticket->id) }}`)
                    .then(response => response.json())
                    .then(data => {
                        const conversations = data.conversations;
                        
                        // Only update if new messages arrived
                        if (conversations.length <= lastMessageCount) return;
                        
                        lastMessageCount = conversations.length;
                        let html = '';
                        
                        conversations.forEach(message => {
                            const isMe = message.user_id == currentUserId;
                            // Internal messages are already filtered by backend, but safe to check
                            if (message.is_internal) return;

                            html += `
                                <div class="flex ${isMe ? 'justify-end' : 'justify-start'} animate-fade-in">
                                    <div class="flex flex-col ${isMe ? 'items-end' : 'items-start'} max-w-[85%] sm:max-w-[75%]">
                                        <div class="flex items-center gap-2 mb-2 px-1">
                                            ${!isMe ? `
                                                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-[10px] text-white font-bold shadow-sm">
                                                    A
                                                </div>
                                            ` : ''}
                                            <span class="text-[11px] font-black text-gray-500 uppercase tracking-widest">
                                                ${isMe ? 'You' : 'Support Agent'}
                                            </span>
                                            <span class="text-[11px] font-bold text-gray-400 local-time" data-time="${message.created_at}">
                                                ${formatLocalTime(message.created_at)}
                                            </span>
                                        </div>
                                        
                                        <div class="relative group">
                                            <div class="p-4 sm:p-5 rounded-[1.5rem] shadow-sm ${isMe ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none'}">
                                                <p class="text-sm leading-relaxed font-medium whitespace-pre-wrap">${message.message}</p>
                                            </div>
                            `;

                            if (message.attachments && message.attachments.length > 0) {
                                html += `<div class="mt-3 flex flex-wrap gap-2">`;
                                message.attachments.forEach(file => {
                                    html += `
                                        <a href="${file.url}" target="_blank" 
                                           class="flex items-center gap-2 px-3 py-1.5 rounded-full text-[11px] font-bold ${isMe ? 'bg-blue-700/50 text-blue-50 hover:bg-blue-700' : 'bg-white border border-gray-100 text-gray-500 hover:border-blue-200 hover:text-blue-600'} transition-all shadow-sm">
                                            <i class="fas fa-paperclip opacity-60"></i>
                                            ${file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name}
                                        </a>
                                    `;
                                });
                                html += `</div>`;
                            }

                            html += `</div></div></div>`;
                        });

                        // Check if we should scroll to bottom (if user was already at bottom)
                        const isAtBottom = messagesContainer.scrollHeight - messagesContainer.scrollTop <= messagesContainer.clientHeight + 100;

                        // Update content
                        // Note: This replaces all content. For a more robust solution, we'd diff or append.
                        // But for this scale, replacing is fine and ensures sync.
                        if (messagesContainer.innerHTML.trim() !== html.trim()) {
                            messagesContainer.innerHTML = html;
                            if (isAtBottom) {
                                scrollToBottom();
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching messages:', error));
            }

            // Poll every 3 seconds
            setInterval(fetchMessages, 3000);
        });
    </script>
@endsection
