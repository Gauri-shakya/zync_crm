{{-- resources/views/admin/task-show.blade.php --}}
@extends('components.layout')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Task | Digital Marketing CRM</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .priority-badge {
                padding: 0.35rem 0.85rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.375rem;
            }

            .priority-low {
                background-color: #ecfdf5;
                color: #047857;
                border: 1px solid #a7f3d0;
            }

            .priority-medium {
                background-color: #fffbeb;
                color: #b45309;
                border: 1px solid #fde68a;
            }

            .priority-high {
                background-color: #fef2f2;
                color: #b91c1c;
                border: 1px solid #fecaca;
            }

            .status-badge {
                padding: 0.35rem 0.85rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.375rem;
            }

            .status-pending {
                background-color: #fff7ed;
                color: #c2410c;
                border: 1px solid #fed7aa;
            }

            .status-in-progress {
                background-color: #eff6ff;
                color: #1d4ed8;
                border: 1px solid #bfdbfe;
            }

            .status-completed {
                background-color: #f0fdf4;
                color: #15803d;
                border: 1px solid #bbf7d0;
            }

            .fade-in {
                animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Breadcrumb & Actions -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 pt-6 pb-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                                <i class="fas fa-tasks mr-2"></i>
                                Tasks
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                                <span class="text-sm font-medium text-gray-500">Task Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                    @if(auth()->user()->hasRole('admin') || $task->users->contains(auth()->user()->id) || ($task->role && auth()->user()->hasRole($task->role->name)))
                    <a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-edit mr-2"></i> Edit Task
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 pb-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Content -->
                <div class="lg:col-span-2 space-y-6 fade-in">
                    <!-- Main Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                                <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $task->title }}</h1>
                                <div class="flex items-center space-x-2">
                                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $task->status)) }}">
                                        <i class="fas fa-circle text-[0.5rem]"></i>
                                        {{ $task->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="prose max-w-none text-gray-600 mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-align-left text-indigo-500 mr-2"></i> Description
                                </h3>
                                <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                    @if($task->description)
                                        <p class="whitespace-pre-wrap leading-relaxed">{{ $task->description }}</p>
                                    @else
                                        <p class="text-gray-400 italic">No description provided.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-paperclip text-indigo-500 mr-2"></i> Attachments
                                </h3>
                                @if($task->attachments && count($task->attachments) > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach($task->attachments as $attachment)
                                            <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-300 hover:shadow-sm transition group">
                                                <div class="flex items-center overflow-hidden">
                                                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 mr-3 group-hover:bg-indigo-100 transition">
                                                        <i class="fas fa-file-alt"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">{{ basename($attachment) }}</p>
                                                        <p class="text-xs text-gray-500">Document</p>
                                                    </div>
                                                </div>
                                                <a href="{{ Storage::url($attachment) }}" target="_blank" class="text-gray-400 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100 transition" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                        <i class="fas fa-folder-open text-gray-300 text-3xl mb-2"></i>
                                        <p class="text-gray-500">No attachments found</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Comments / Activity could go here in future -->
                </div>

                <!-- Right Column: Sidebar -->
                <div class="space-y-6 fade-in" style="animation-delay: 0.1s;">
                    
                    <!-- Update Status Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                        <div class="p-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-sync-alt text-indigo-500 mr-2"></i> Update Status
                            </h3>
                        </div>
                        <div class="p-5">
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                                        <div class="relative">
                                            <select id="status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg shadow-sm">
                                                <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Progress" {{ $task->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Task Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                        <div class="p-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-indigo-500 mr-2"></i> Task Details
                            </h3>
                        </div>
                        <div class="p-5 space-y-4">
                            <!-- Priority -->
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Priority</span>
                                <div class="mt-1">
                                    <span class="priority-badge priority-{{ strtolower($task->priority) }}">
                                        <i class="fas fa-flag"></i> {{ $task->priority }}
                                    </span>
                                </div>
                            </div>

                            <!-- Category -->
                            @if($task->category)
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</span>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-tag mr-1 text-gray-400"></i> {{ $task->category }}
                                    </span>
                                </div>
                            </div>
                            @endif

                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</span>
                                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $task->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Due Date</span>
                                    <p class="mt-1 text-sm font-medium {{ $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'Completed' ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $task->formatted_due_date ?? 'No deadline' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- People Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                        <div class="p-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-users text-indigo-500 mr-2"></i> People
                            </h3>
                        </div>
                        <div class="p-5 space-y-6">
                            <!-- Assignee -->
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Assigned To</span>
                                @if($task->assigned_to_team && $task->role)
                                    <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $task->role->name }}</p>
                                            <p class="text-xs text-gray-500">Team Assignment</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-3">
                                        @forelse($task->users as $user)
                                            <div class="flex items-center group">
                                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3 ring-2 ring-white group-hover:ring-indigo-100 transition">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition">{{ $user->name }}</span>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-400 italic">No users assigned</p>
                                        @endforelse
                                    </div>
                                @endif
                            </div>

                            <!-- Assigner -->
                            @if($task->assigner)
                            <div class="pt-4 border-t border-gray-100">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Assigned By</span>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs mr-3">
                                        {{ strtoupper(substr($task->assigner->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $task->assigner->name }}</p>
                                        @if($task->assigner->roles->isNotEmpty())
                                            <p class="text-xs text-gray-500">{{ $task->assigner->roles->pluck('name')->implode(', ') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>

    </html>
@endsection