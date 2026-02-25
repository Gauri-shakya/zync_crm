@extends('components.layout')

@section('content')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                    },
                    fontFamily: {
                        'jakarta': ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .note-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .note-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        .loading-shimmer {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        #note-content-editor {
            min-height: 200px;
            outline: none;
        }
        
        #note-content-editor:empty:before {
            content: attr(placeholder);
            color: #9ca3af;
        }
    </style>

    <div class="min-h-screen bg-[#f8fafc]">
        <!-- Main Content -->
        <main class="max-w-[1600px] mx-auto p-4 sm:p-6 lg:p-8 space-y-8">
            
                <!-- Dashboard View -->
                <div id="dashboard-view" class="space-y-8 animate-fade-in">
                    <!-- Header Section -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="space-y-1">
                            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Thought Canvas</h1>
                            <p class="text-sm font-medium text-gray-500">Capture ideas, strategies and meeting insights</p>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <div class="relative flex-1 md:w-64">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" id="global-search" placeholder="Search thoughts..." 
                                    class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200 rounded-2xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none shadow-sm shadow-blue-900/5">
                            </div>
                            <button id="add-note-btn"
                                class="flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-900 text-white rounded-2xl hover:bg-primary-600 font-bold transition-all shadow-lg shadow-gray-900/10 active:scale-95 whitespace-nowrap">
                                <i class="fas fa-plus text-xs"></i>
                                <span>New Note</span>
                            </button>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-blue-900/5 hover:-translate-y-1 transition-transform group">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-primary-600 mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-sticky-note text-lg"></i>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="total-notes">0</h3>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Canvas</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-emerald-900/5 hover:-translate-y-1 transition-transform group">
                            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-success mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-user text-lg"></i>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="my-notes-count">0</h3>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Personal</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-purple-900/5 hover:-translate-y-1 transition-transform group">
                            <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="team-notes-count">0</h3>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Collaborative</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-yellow-900/5 hover:-translate-y-1 transition-transform group">
                            <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-warning mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-thumbtack text-lg"></i>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="pinned-notes-count">0</h3>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pinned</p>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm">
                        <select id="filter-category" class="bg-gray-50 border-none rounded-xl px-4 py-2 text-xs font-bold text-gray-600 focus:ring-2 focus:ring-primary-500 outline-none cursor-pointer">
                            <option value="all">All Categories</option>
                            <option value="client">Client</option>
                            <option value="project">Project</option>
                            <option value="task">Task</option>
                            <option value="meeting">Meeting</option>
                            <option value="idea">Idea</option>
                            <option value="campaign">Campaign</option>
                            <option value="personal">Personal</option>
                        </select>

                        <select id="filter-visibility" class="bg-gray-50 border-none rounded-xl px-4 py-2 text-xs font-bold text-gray-600 focus:ring-2 focus:ring-primary-500 outline-none cursor-pointer">
                            <option value="all">All Visibility</option>
                            <option value="private">Private</option>
                            <option value="team">Team</option>
                            <option value="public">Public</option>
                        </select>

                        <select id="filter-date" class="bg-gray-50 border-none rounded-xl px-4 py-2 text-xs font-bold text-gray-600 focus:ring-2 focus:ring-primary-500 outline-none cursor-pointer">
                            <option value="all">All Time</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>

                        <select id="filter-sort" class="bg-gray-50 border-none rounded-xl px-4 py-2 text-xs font-bold text-gray-600 focus:ring-2 focus:ring-primary-500 outline-none cursor-pointer">
                            <option value="created_at">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="updated_at">Recent Activity</option>
                            <option value="title">Alphabetical</option>
                        </select>

                        <div class="ml-auto flex items-center gap-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest" id="notes-count-text">Synchronizing...</p>
                            <button id="clear-filters" class="text-xs font-black text-gray-400 hover:text-primary-600 uppercase tracking-widest transition-colors">
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Notes Content -->
                <div id="notes-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Dynamic Content -->
                </div>

                <!-- Loading State -->
                <div id="loading-state" class="flex flex-col items-center justify-center py-24 space-y-4">
                    <div class="w-16 h-16 border-4 border-primary-100 border-t-primary-600 rounded-full animate-spin"></div>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Synchronizing Thoughts...</p>
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="hidden flex flex-col items-center justify-center py-24 bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mb-6">
                        <i class="fas fa-feather-pointed text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Canvas is Blank</h3>
                    <p class="text-sm text-gray-500 mb-8">Your brilliant ideas deserve a place to live.</p>
                    <button id="create-first-note"
                        class="px-8 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary-600 transition-all shadow-xl shadow-gray-900/10 active:scale-95">
                        Begin Writing
                    </button>
                </div>
            </div>

            <!-- Note Detail View -->
            <div id="note-detail-view" class="hidden animate-fade-in space-y-8">
                <button id="back-to-notes" class="group flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary-600 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-sm group-hover:border-primary-200">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </div>
                    Back to Canvas
                </button>
                <div id="note-detail-content"></div>
            </div>

            <!-- Add/Edit Note View -->
            <div id="add-edit-note-view" class="hidden animate-fade-in space-y-8">
                <div class="flex items-center justify-between">
                    <button id="back-from-add-edit" class="group flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary-600 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-sm group-hover:border-primary-200">
                            <i class="fas fa-arrow-left text-xs"></i>
                        </div>
                        Discard Changes
                    </button>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight" id="add-edit-title">New Entry</h2>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-blue-900/5 overflow-hidden">
                    <form id="note-form" class="p-8 space-y-8">
                        <input type="hidden" id="note-id" value="">
                        
                        <div class="space-y-6">
                            <!-- Title -->
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Note Title</label>
                                <input type="text" id="note-title"
                                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-lg font-bold focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                    placeholder="Enter a descriptive title..." required>
                                <p id="title-error" class="text-xs text-red-500 mt-1 hidden"></p>
                            </div>

                            <!-- Editor -->
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Content</label>
                                <div class="bg-gray-50 border border-gray-100 rounded-[2rem] overflow-hidden">
                                    <div class="flex items-center gap-1 p-3 border-b border-gray-100 bg-white/50 backdrop-blur-sm">
                                        <button type="button" class="format-btn w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors" data-command="bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="format-btn w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors" data-command="italic"><i class="fas fa-italic"></i></button>
                                        <button type="button" class="format-btn w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors" data-command="underline"><i class="fas fa-underline"></i></button>
                                        <div class="w-px h-6 bg-gray-200 mx-2"></div>
                                        <button type="button" class="format-btn w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors" data-command="insertUnorderedList"><i class="fas fa-list-ul"></i></button>
                                        <button type="button" class="format-btn w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors" data-command="insertOrderedList"><i class="fas fa-list-ol"></i></button>
                                    </div>
                                    <div id="note-content-editor" contenteditable="true" 
                                        class="p-6 focus:outline-none text-gray-700 leading-relaxed custom-scrollbar" 
                                        placeholder="Start writing your thoughts here..."></div>
                                    <textarea id="note-content" name="content" class="hidden"></textarea>
                                </div>
                                <p id="content-error" class="text-xs text-red-500 mt-1 hidden"></p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Category & Tags -->
                                <div class="space-y-6">
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Classification</label>
                                        <select id="note-category" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer" required>
                                            <option value="">Select Category</option>
                                            <option value="client">Client Strategy</option>
                                            <option value="project">Project Insights</option>
                                            <option value="task">Action Items</option>
                                            <option value="meeting">Meeting Minutes</option>
                                            <option value="idea">Raw Ideas</option>
                                            <option value="campaign">Campaign Planning</option>
                                            <option value="personal">Personal Notes</option>
                                            <option value="other">Other...</option>
                                        </select>
                                        <input type="text" id="note-category-other" class="w-full mt-2 bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm hidden" placeholder="Enter custom category...">
                                        <p id="category-error" class="text-xs text-red-500 mt-1 hidden"></p>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tags</label>
                                        <div class="flex flex-wrap gap-2 mb-3" id="selected-tags"></div>
                                        <input type="text" id="tag-input" 
                                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                            placeholder="Add tags and press Enter...">
                                    </div>
                                </div>

                                <!-- Visibility -->
                                <div class="space-y-6">
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Privacy Level</label>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="relative flex items-center p-4 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-primary-200 transition-all group">
                                                <input type="radio" name="visibility" value="private" class="w-4 h-4 text-primary-600 focus:ring-primary-500" checked>
                                                <div class="ml-4">
                                                    <p class="text-sm font-bold text-gray-900">Private Canvas</p>
                                                    <p class="text-[10px] text-gray-500">Only you can access this entry</p>
                                                </div>
                                            </label>
                                            <label class="relative flex items-center p-4 rounded-2xl bg-gray-50 border border-gray-100 cursor-pointer hover:border-primary-200 transition-all group">
                                                <input type="radio" name="visibility" value="team" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                                <div class="ml-4">
                                                    <p class="text-sm font-bold text-gray-900">Team Collaboration</p>
                                                    <p class="text-[10px] text-gray-500">Shared with designated team members</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="team-selection-container" class="hidden space-y-3 p-4 rounded-2xl bg-blue-50 border border-blue-100 animate-fade-in">
                                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest ml-1">Select Teams</p>
                                        <div class="grid grid-cols-2 gap-2">
                                            <!-- These would typically be populated from the database -->
                                            <label class="flex items-center gap-2 p-2 rounded-xl hover:bg-white transition-colors cursor-pointer">
                                                <input type="checkbox" value="development" class="w-4 h-4 rounded text-blue-600">
                                                <span class="text-xs font-bold text-gray-700">Development</span>
                                            </label>
                                            <label class="flex items-center gap-2 p-2 rounded-xl hover:bg-white transition-colors cursor-pointer">
                                                <input type="checkbox" value="marketing" class="w-4 h-4 rounded text-blue-600">
                                                <span class="text-xs font-bold text-gray-700">Marketing</span>
                                            </label>
                                            <label class="flex items-center gap-2 p-2 rounded-xl hover:bg-white transition-colors cursor-pointer">
                                                <input type="checkbox" value="sales" class="w-4 h-4 rounded text-blue-600">
                                                <span class="text-xs font-bold text-gray-700">Sales</span>
                                            </label>
                                            <label class="flex items-center gap-2 p-2 rounded-xl hover:bg-white transition-colors cursor-pointer">
                                                <input type="checkbox" value="management" class="w-4 h-4 rounded text-blue-600">
                                                <span class="text-xs font-bold text-gray-700">Management</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-primary-50 border border-primary-100">
                                        <input type="checkbox" id="note-pinned" class="w-5 h-5 rounded-lg text-primary-600 focus:ring-primary-500 cursor-pointer">
                                        <label for="note-pinned" class="text-sm font-bold text-primary-700 cursor-pointer">Pin to Dashboard</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Entities (Optional) -->
                            <div class="pt-6 border-t border-gray-100">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-4 block">Connections (Optional)</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-gray-400 ml-1">Related Client</label>
                                        <select id="related-client" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-xs font-bold focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">None</option>
                                            <option value="other">Other...</option>
                                        </select>
                                        <input type="text" id="related-client-other" class="w-full mt-2 bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-xs hidden" placeholder="Client name...">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-gray-400 ml-1">Related Project</label>
                                        <select id="related-project" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-xs font-bold focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">None</option>
                                            <option value="other">Other...</option>
                                        </select>
                                        <input type="text" id="related-project-other" class="w-full mt-2 bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-xs hidden" placeholder="Project name...">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-gray-400 ml-1">Related Task</label>
                                        <select id="related-task" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-xs font-bold focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">None</option>
                                            <option value="other">Other...</option>
                                        </select>
                                        <input type="text" id="related-task-other" class="w-full mt-2 bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-xs hidden" placeholder="Task name...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-8 border-t border-gray-100">
                            <button type="button" id="cancel-note" class="px-8 py-3 text-sm font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Discard</button>
                            <button type="submit" id="submit-note" class="px-10 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary-600 transition-all shadow-xl shadow-gray-900/10 active:scale-95 flex items-center justify-center">
                                <i id="submit-spinner" class="fas fa-circle-notch fa-spin mr-2 hidden"></i>
                                <span id="submit-text">Finalize Note</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Confirmation -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4 animate-fade-in">
        <div class="bg-white rounded-[2.5rem] p-8 max-w-md w-full shadow-2xl border border-gray-100">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-danger mb-6">
                <i class="fas fa-trash-can text-2xl"></i>
            </div>
            <h3 id="delete-modal-title" class="text-2xl font-black text-gray-900 tracking-tight mb-2">Erase Thought?</h3>
            <p class="text-sm text-gray-500 mb-8">This action is permanent and cannot be recovered from the digital void.</p>
            <div class="flex gap-3">
                <button id="cancel-delete" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl font-bold hover:bg-gray-200 transition-all">Keep It</button>
                <button id="confirm-delete" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-600/20">Delete Forever</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast-container" class="fixed bottom-8 right-8 z-[60] flex flex-col gap-3"></div>

    <script>
        // Notes Management System with Database Integration
        let currentView = "grid"; // grid or list
        let currentFilter = "all"; // all, my, team, pinned, recent
        let selectedTags = [];
        let noteToDelete = null;
        let noteDetailId = null;
        let notepadCsrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast Notification Function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-slide-up ${
                type === 'success' ? 'bg-gray-900 text-white' : 'bg-red-600 text-white'
            }`;

            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            toast.innerHTML = `
                <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas ${icon}"></i>
                </div>
                <p class="text-sm font-bold">${message}</p>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                toast.style.transition = 'all 0.5s ease';
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function () {
            // Load initial data
            loadStats();
            loadNotes();

            // Set up rich text editor buttons
            setupRichTextEditor();

            // Navigation and Actions
            const addNoteBtn = document.getElementById('add-note-btn');
            if (addNoteBtn) addNoteBtn.addEventListener('click', openAddNotePage);
            
            const createFirstNoteBtn = document.getElementById('create-first-note');
            if (createFirstNoteBtn) createFirstNoteBtn.addEventListener('click', openAddNotePage);

            const backToNotesBtn = document.getElementById('back-to-notes');
            if (backToNotesBtn) backToNotesBtn.addEventListener('click', showNotesList);
            
            const backFromAddEditBtn = document.getElementById('back-from-add-edit');
            if (backFromAddEditBtn) backFromAddEditBtn.addEventListener('click', showNotesList);

            const cancelNoteBtn = document.getElementById('cancel-note');
            if (cancelNoteBtn) cancelNoteBtn.addEventListener('click', showNotesList);

            // Filter event listeners
            const filterCategory = document.getElementById('filter-category');
            if (filterCategory) filterCategory.addEventListener('change', loadNotes);
            
            const filterVisibility = document.getElementById('filter-visibility');
            if (filterVisibility) filterVisibility.addEventListener('change', loadNotes);
            
            const filterSort = document.getElementById('filter-sort');
            if (filterSort) filterSort.addEventListener('change', loadNotes);
            
            const globalSearch = document.getElementById('global-search');
            if (globalSearch) globalSearch.addEventListener('input', debounce(loadNotes, 500));
            
            const clearFiltersBtn = document.getElementById('clear-filters');
            if (clearFiltersBtn) clearFiltersBtn.addEventListener('click', clearFilters);

            // Note form submission
            const noteForm = document.getElementById('note-form');
            if (noteForm) noteForm.addEventListener('submit', handleNoteSubmit);

            // Tag input handling
            const tagInput = document.getElementById('tag-input');
            if (tagInput) {
                tagInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const tag = e.target.value.trim();
                        if (tag && !selectedTags.includes(tag)) {
                            selectedTags.push(tag);
                            renderSelectedTags();
                            e.target.value = '';
                        }
                    }
                });
            }

            // Remove tag event delegation
            const selectedTagsContainer = document.getElementById('selected-tags');
            if (selectedTagsContainer) {
                selectedTagsContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-tag')) {
                        const tag = e.target.closest('.remove-tag').dataset.tag;
                        selectedTags = selectedTags.filter(t => t !== tag);
                        renderSelectedTags();
                    }
                });
            }

            // Visibility radio buttons
            document.querySelectorAll('input[name="visibility"]').forEach(radio => {
                radio.addEventListener('change', (e) => {
                    const teamContainer = document.getElementById('team-selection-container');
                    if (e.target.value === 'team') {
                        teamContainer.classList.remove('hidden');
                    } else {
                        teamContainer.classList.add('hidden');
                    }
                });
            });

            // Setup "Other" option listeners
            const otherFields = ['note-category', 'related-client', 'related-project', 'related-task'];
            otherFields.forEach(fieldId => {
                const select = document.getElementById(fieldId);
                const otherInput = document.getElementById(fieldId + '-other');
                
                if (select && otherInput) {
                    select.addEventListener('change', function() {
                        if (this.value === 'other') {
                            otherInput.classList.remove('hidden');
                            otherInput.focus();
                            otherInput.required = true;
                        } else {
                            otherInput.classList.add('hidden');
                            otherInput.value = '';
                            otherInput.required = false;
                        }
                    });
                }
            });

            // Delete modal
            document.getElementById('cancel-delete').addEventListener('click', closeDeleteModal);
            document.getElementById('confirm-delete').addEventListener('click', confirmDeleteNote);

            // Close delete modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === document.getElementById('delete-modal')) {
                    closeDeleteModal();
                }
            });

            // Handle window resize for better mobile experience
            window.addEventListener('resize', handleResize);

            // Initial resize handling
            handleResize();
        });

                // Handle responsive layout adjustments
                function handleResize() {
                    const width = window.innerWidth;

                    // Adjust note container layout for mobile
                    if (width < 640) {
                        // Ensure proper stacking on mobile
                        const noteContainer = document.getElementById('notes-container');
                        if (noteContainer && currentView === 'grid') {
                            noteContainer.className = 'grid grid-cols-1 gap-4';
                        }
                    }
                }

                // Set up rich text editor functionality with improved list handling
                function setupRichTextEditor() {
                    const editor = document.getElementById('note-content-editor');
                    const formatButtons = document.querySelectorAll('.format-btn');

                    formatButtons.forEach(button => {
                        button.addEventListener('click', function (e) {
                            e.preventDefault();
                            const command = this.dataset.command;

                            // Focus the editor first
                            editor.focus();

                            // Execute the formatting command
                            if (command === 'insertUnorderedList' || command === 'insertOrderedList') {
                                // For lists, we need to ensure proper HTML structure
                                try {
                                    document.execCommand(command, false, null);
                                } catch (err) {
                                    // Fallback for list creation
                                    if (command === 'insertUnorderedList') {
                                        insertList('ul');
                                    } else {
                                        insertList('ol');
                                    }
                                }
                            } else {
                                document.execCommand(command, false, null);
                            }

                            // Update button active state
                            formatButtons.forEach(btn => btn.classList.remove('active'));
                            this.classList.add('active');

                            // Remove active state after a short delay
                            setTimeout(() => {
                                this.classList.remove('active');
                            }, 300);

                            // Update hidden textarea
                            updateHiddenTextarea();
                        });
                    });

                    // Update hidden textarea whenever editor content changes
                    editor.addEventListener('input', updateHiddenTextarea);
                    editor.addEventListener('blur', updateHiddenTextarea);

                    // Ensure proper list styling
                    editor.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') {
                            setTimeout(() => {
                                updateHiddenTextarea();
                            }, 10);
                        }
                    });
                }

                // Helper function to insert list with proper HTML
                function insertList(type) {
                    const editor = document.getElementById('note-content-editor');
                    const selection = window.getSelection();
                    const range = selection.getRangeAt(0);

                    // Create list element
                    const list = document.createElement(type);
                    const listItem = document.createElement('li');
                    listItem.innerHTML = '&nbsp;'; // Non-breaking space for empty item
                    list.appendChild(listItem);

                    // Insert list at cursor position
                    range.deleteContents();
                    range.insertNode(list);

                    // Move cursor inside the list item
                    const newRange = document.createRange();
                    newRange.setStart(listItem, 0);
                    newRange.setEnd(listItem, 0);
                    selection.removeAllRanges();
                    selection.addRange(newRange);

                    updateHiddenTextarea();
                }

                // Update hidden textarea with editor content
                function updateHiddenTextarea() {
                    const editor = document.getElementById('note-content-editor');
                    const textarea = document.getElementById('note-content');
                    textarea.value = editor.innerHTML;
                }

                // Load statistics from database
                function loadStats() {
                    const totalNotesEl = document.getElementById('total-notes');
                    const myNotesCountEl = document.getElementById('my-notes-count');
                    const teamNotesCountEl = document.getElementById('team-notes-count');
                    const pinnedNotesCountEl = document.getElementById('pinned-notes-count');

                    fetch('/api/notes/stats')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (totalNotesEl) totalNotesEl.textContent = data.total || 0;
                            if (myNotesCountEl) myNotesCountEl.textContent = data.my_notes || 0;
                            if (teamNotesCountEl) teamNotesCountEl.textContent = data.team_notes || 0;
                            if (pinnedNotesCountEl) pinnedNotesCountEl.textContent = data.pinned || 0;
                            
                            const recentNotesCountEl = document.getElementById('recent-notes-count');
                            if (recentNotesCountEl) recentNotesCountEl.textContent = data.recent || 0;
                        })
                        .catch(error => {
                            console.error('Error loading stats:', error);
                        });
                }

                // Load notes from database with filters
                function loadNotes() {
                    // Show loading state
                    const loadingState = document.getElementById('loading-state');
                    const notesContainer = document.getElementById('notes-container');
                    const emptyState = document.getElementById('empty-state');
                    const notesCountText = document.getElementById('notes-count-text');

                    if (loadingState) loadingState.classList.remove('hidden');
                    if (notesContainer) notesContainer.classList.add('hidden');
                    if (emptyState) emptyState.classList.add('hidden');
                    if (notesCountText) notesCountText.textContent = 'Loading thoughts...';

                    // Build query parameters
                    const params = new URLSearchParams({
                        filter: currentFilter,
                        category: document.getElementById('filter-category').value,
                        visibility: document.getElementById('filter-visibility').value,
                        date: document.getElementById('filter-date').value,
                        sort_by: document.getElementById('filter-sort').value === 'oldest' ? 'created_at' :
                            document.getElementById('filter-sort').value === 'title' ? 'title' :
                                document.getElementById('filter-sort').value,
                        sort_order: document.getElementById('filter-sort').value === 'oldest' ? 'asc' : 'desc',
                        search: document.getElementById('global-search').value
                    });

                    fetch(`/api/notes?${params}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(notes => {
                            renderNotes(notes);
                            loadStats(); // Refresh stats
                        })
                        .catch(error => {
                            console.error('Error loading notes:', error);
                            if (notesCountText) notesCountText.textContent = 'Sync failed';
                            renderNotes([]); // Show empty state
                        })
                        .finally(() => {
                            if (loadingState) loadingState.classList.add('hidden');
                            if (notesContainer) notesContainer.classList.remove('hidden');
                        });
                }

                // Render notes to the DOM
                function renderNotes(notes) {
                    const notesContainer = document.getElementById('notes-container');
                    if (!notesContainer) return;

                    // Update notes count text
                    const notesCountText = document.getElementById('notes-count-text');
                    if (notesCountText) {
                        notesCountText.textContent = `Showing ${notes.length} note${notes.length !== 1 ? 's' : ''}`;
                    }

                    // Show empty state if no notes
                    const emptyState = document.getElementById('empty-state');
                    if (notes.length === 0) {
                        notesContainer.innerHTML = '';
                        if (emptyState) emptyState.classList.remove('hidden');
                        return;
                    }

                    if (emptyState) emptyState.classList.add('hidden');

                    // Clear container
                    notesContainer.innerHTML = '';

                    // Render each note
                    notes.forEach(note => {
                        const noteElement = createNoteElement(note);
                        notesContainer.appendChild(noteElement);
                    });
                }

                // Create note element for grid/list view
                function createNoteElement(note) {
                    const noteDiv = document.createElement('div');
                    noteDiv.className = 'note-card bg-white rounded-[2rem] border border-gray-100 p-6 flex flex-col justify-between group cursor-pointer';
                    noteDiv.dataset.id = note.id;

                    const visibilityInfo = getVisibilityInfo(note.visibility);
                    const categoryName = getCategoryName(note.category);

                    // Truncate content
                    let contentPreview = note.content || '';
                    contentPreview = contentPreview.replace(/<[^>]*>/g, '');
                    contentPreview = contentPreview.length > 100 ? contentPreview.substring(0, 100) + '...' : contentPreview;

                    noteDiv.innerHTML = `
                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                                        <i class="fas fa-file-lines text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-1">${note.title}</h3>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">${categoryName}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    ${note.pinned ? '<i class="fas fa-thumbtack text-warning text-xs"></i>' : ''}
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-md ${visibilityInfo.color.replace('bg-', 'bg-opacity-10 ')}">
                                        ${note.visibility.toUpperCase()}
                                    </span>
                                </div>
                            </div>

                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">${contentPreview}</p>

                            <div class="flex flex-wrap gap-1.5">
                                ${note.tags ? (typeof note.tags === 'string' ? JSON.parse(note.tags) : note.tags).slice(0, 3).map(tag => `
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded-lg">#${tag}</span>
                                `).join('') : ''}
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-primary-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-primary-600">
                                    ${(note.user?.name?.charAt(0) || 'U')}
                                </div>
                                <span class="text-[10px] font-bold text-gray-500">${formatDate(note.created_at)}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="note-edit-btn w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-primary-50 hover:text-primary-600 transition-all">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button class="note-view-btn px-4 py-1.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary-600 transition-all active:scale-95">
                                    Focus
                                </button>
                            </div>
                        </div>
                    `;

                    // Add event listeners
                    noteDiv.querySelector('.note-view-btn').addEventListener('click', (e) => {
                        e.stopPropagation();
                        showNoteDetailPage(note.id);
                    });
                    noteDiv.querySelector('.note-edit-btn').addEventListener('click', (e) => {
                        e.stopPropagation();
                        openEditNotePage(note.id);
                    });
                    noteDiv.addEventListener('click', () => showNoteDetailPage(note.id));

                    return noteDiv;
                }

                // Show note detail page
                function showNoteDetailPage(noteId) {
                    noteDetailId = noteId;

                    // Hide dashboard and add/edit view, show note detail view
                    document.getElementById('dashboard-view').classList.add('hidden');
                    document.getElementById('add-edit-note-view').classList.add('hidden');
                    document.getElementById('note-detail-view').classList.remove('hidden');

                    // Load note details from database
                    fetch(`/api/notes/${noteId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Note not found');
                            }
                            return response.json();
                        })
                        .then(note => {
                            renderNoteDetail(note);
                        })
                        .catch(error => {
                            console.error('Error loading note:', error);
                            showToast('Error loading note details', 'danger');
                            showNotesList();
                        });
                }

                // Render note detail content
                function renderNoteDetail(note) {
                    const detailContent = document.getElementById('note-detail-content');
                    if (!detailContent) return;

                    const visibilityInfo = getVisibilityInfo(note.visibility);
                    const categoryName = getCategoryName(note.category);

                    detailContent.innerHTML = `
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2 space-y-8">
                                <div class="bg-white rounded-[2.5rem] p-8 sm:p-12 border border-gray-100 shadow-xl shadow-blue-900/5">
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        ${note.content || 'No content available'}
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-lg shadow-blue-900/5 space-y-6">
                                    <div class="space-y-4">
                                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Classification</p>
                                            <p class="text-sm font-bold text-gray-900">${categoryName}</p>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Visibility</p>
                                            <p class="text-sm font-bold text-gray-900">${note.visibility.toUpperCase()}</p>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Last Sync</p>
                                            <p class="text-sm font-bold text-gray-900">${formatDate(note.updated_at)}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        <button id="detail-edit-btn" class="w-full py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary-600 transition-all shadow-lg shadow-gray-900/10 active:scale-95">
                                            Modify Entry
                                        </button>
                                        <button id="detail-delete-btn" class="w-full py-3 bg-white text-danger border border-danger/10 rounded-2xl font-bold hover:bg-danger hover:text-white transition-all active:scale-95">
                                            Erase Thought
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    const editBtn = document.getElementById('detail-edit-btn');
                    if (editBtn) editBtn.addEventListener('click', () => openEditNotePage(note.id));
                    
                    const deleteBtn = document.getElementById('detail-delete-btn');
                    if (deleteBtn) deleteBtn.addEventListener('click', () => openDeleteModal(note.id));
                }

                // Open add note page
                function openAddNotePage() {
                    // Update page title
                    const pt = document.getElementById('page-title');
                    const aet = document.getElementById('add-edit-title');
                    const ni = document.getElementById('note-id');
                    const st = document.getElementById('submit-text');

                    if (pt) pt.textContent = 'Create New Note';
                    if (aet) aet.textContent = 'Create New Note';
                    if (ni) ni.value = '';
                    if (st) st.textContent = 'Save Note';

                    // Reset form
                    const nf = document.getElementById('note-form');
                    const nce = document.getElementById('note-content-editor');
                    const stc = document.getElementById('selected-tags');
                    
                    if (nf) nf.reset();
                    if (nce) nce.innerHTML = '';
                    if (stc) stc.innerHTML = '';
                    selectedTags = [];

                    // Reset "Other" fields
                    ['note-category', 'related-client', 'related-project', 'related-task'].forEach(fieldId => {
                        const otherInput = document.getElementById(fieldId + '-other');
                        if (otherInput) {
                            otherInput.classList.add('hidden');
                            otherInput.value = '';
                            otherInput.required = false;
                        }
                    });

                    // Clear errors
                    clearFormErrors();

                    // Set default values
                    const nc = document.getElementById('note-category');
                    if (nc) nc.value = 'client';

                    const vp = document.getElementById('visibility-private');
                    if (vp) vp.checked = true;

                    // Hide team selection
                    const tsc = document.getElementById('team-selection-container');
                    if (tsc) tsc.classList.add('hidden');

                    // Uncheck all team checkboxes
                    document.querySelectorAll('#team-selection-container input[type="checkbox"]').forEach(cb => {
                        cb.checked = false;
                    });

                    // Hide dashboard and detail view, show add/edit view
                    const dv = document.getElementById('dashboard-view');
                    const ndv = document.getElementById('note-detail-view');
                    const aenv = document.getElementById('add-edit-note-view');

                    if (dv) dv.classList.add('hidden');
                    if (ndv) ndv.classList.add('hidden');
                    if (aenv) aenv.classList.remove('hidden');

                    // Focus on title input
                    const nt = document.getElementById('note-title');
                    if (nt) {
                        setTimeout(() => nt.focus(), 100);
                    }
                }

                // Open edit note page
                function openEditNotePage(noteId) {
                    fetch(`/api/notes/${noteId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Note not found');
                            }
                            return response.json();
                        })
                        .then(note => {
                            // Update page title
                            const pt = document.getElementById('page-title');
                            const aet = document.getElementById('add-edit-title');
                            const ni = document.getElementById('note-id');
                            const st = document.getElementById('submit-text');

                            if (pt) pt.textContent = 'Edit Note';
                            if (aet) aet.textContent = 'Edit Note';
                            if (ni) ni.value = noteId;
                            if (st) st.textContent = 'Update Note';

                            // Fill form with note data
                            const nt = document.getElementById('note-title');
                            const nce = document.getElementById('note-content-editor');
                            const np = document.getElementById('note-pinned');

                            if (nt) nt.value = note.title || '';
                            if (nce) nce.innerHTML = note.content || '';
                            setSelectWithOther('note-category', note.category, 'client');
                            if (np) np.checked = note.pinned || false;

                            // Update hidden textarea
                            updateHiddenTextarea();

                            // Set tags (parse from JSON if needed)
                            if (typeof note.tags === 'string') {
                                try {
                                    selectedTags = JSON.parse(note.tags);
                                } catch (e) {
                                    selectedTags = [];
                                }
                            } else {
                                selectedTags = note.tags || [];
                            }
                            renderSelectedTags();

                            // Set related items
                            setSelectWithOther('related-client', note.related_client);
                            setSelectWithOther('related-project', note.related_project);
                            setSelectWithOther('related-task', note.related_task);

                            // Set visibility
                            const visRadio = document.querySelector(`input[name="visibility"][value="${note.visibility || 'private'}"]`);
                            if (visRadio) visRadio.checked = true;

                            // Show/hide team selection based on visibility
                            const tsc = document.getElementById('team-selection-container');
                            if (note.visibility === 'team') {
                                if (tsc) tsc.classList.remove('hidden');
                                // Check teams (parse from JSON if needed)
                                let teams = note.teams;
                                if (typeof teams === 'string') {
                                    try {
                                        teams = JSON.parse(teams);
                                    } catch (e) {
                                        teams = [];
                                    }
                                }
                                if (teams) {
                                    teams.forEach(team => {
                                        const checkbox = document.getElementById(`team-${team}`);
                                        if (checkbox) checkbox.checked = true;
                                    });
                                }
                            } else {
                                if (tsc) tsc.classList.add('hidden');
                            }

                            // Clear errors
                            clearFormErrors();

                            // Hide dashboard and detail view, show add/edit view
                            const dv = document.getElementById('dashboard-view');
                            const ndv = document.getElementById('note-detail-view');
                            const aenv = document.getElementById('add-edit-note-view');

                            if (dv) dv.classList.add('hidden');
                            if (ndv) ndv.classList.add('hidden');
                            if (aenv) aenv.classList.remove('hidden');

                            // Focus on title input
                            if (nt) {
                                setTimeout(() => nt.focus(), 100);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading note for edit:', error);
                            showToast('Error loading note for editing', 'danger');
                            showNotesList();
                        });
                }

                // Go back to notes list
                function showNotesList() {
                    // Update page title
                    const pt = document.getElementById('page-title');
                    if (pt) pt.textContent = 'Notes Dashboard';

                    // Show dashboard, hide note detail and add/edit views
                    const dv = document.getElementById('dashboard-view');
                    const ndv = document.getElementById('note-detail-view');
                    const aenv = document.getElementById('add-edit-note-view');

                    if (dv) dv.classList.remove('hidden');
                    if (ndv) ndv.classList.add('hidden');
                    if (aenv) aenv.classList.add('hidden');

                    // Refresh notes list
                    loadNotes();
                }

                // Toggle pin status of a note
                function togglePinNote(noteId) {
                    fetch(`/api/notes/${noteId}/toggle-pin`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': notepadCsrfToken
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Update UI
                                loadNotes();

                                // If we're in detail view, update the pin button text
                                if (noteDetailId === noteId) {
                                    const pinText = document.getElementById('pin-text');
                                    if (pinText) {
                                        pinText.textContent = data.pinned ? 'Unpin' : 'Pin';
                                    }
                                }
                            }
                        })
                        .catch(error => console.error('Error toggling pin:', error));
                }

                // Render selected tags in the form
                function renderSelectedTags() {
                    const container = document.getElementById('selected-tags');
                    container.innerHTML = '';

                    selectedTags.forEach(tag => {
                        const tagElement = document.createElement('span');
                        tagElement.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                        tagElement.innerHTML = `
                                                                    ${tag}
                                                                    <button type="button" class="ml-1 text-blue-600 hover:text-blue-800 remove-tag" data-tag="${tag}">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                `;
                        container.appendChild(tagElement);
                    });
                }

                // Handle note form submission
                function handleNoteSubmit(e) {
                    e.preventDefault();

                    // Show loading state
                    const submitBtn = document.getElementById('submit-note');
                    const submitText = document.getElementById('submit-text');
                    const submitSpinner = document.getElementById('submit-spinner');

                    if (submitText) submitText.textContent = 'Saving...';
                    if (submitSpinner) submitSpinner.classList.remove('hidden');
                    if (submitBtn) submitBtn.disabled = true;

                    // Clear previous errors
                    clearFormErrors();

                    // Get form data
                    const noteIdEl = document.getElementById('note-id');
                    const noteId = noteIdEl ? noteIdEl.value : '';
                    
                    const titleEl = document.getElementById('note-title');
                    const title = titleEl ? titleEl.value.trim() : '';
                    
                    const contentEditor = document.getElementById('note-content-editor');
                    const contentTextarea = document.getElementById('note-content');
                    const content = contentEditor ? contentEditor.innerHTML.trim() : (contentTextarea ? contentTextarea.value.trim() : '');
                    
                    const categoryEl = document.getElementById('note-category');
                    let category = categoryEl ? categoryEl.value : '';
                    if (category === 'other') {
                        const categoryOtherEl = document.getElementById('note-category-other');
                        if (categoryOtherEl) category = categoryOtherEl.value.trim();
                    }
                    
                    const visibilityEl = document.querySelector('input[name="visibility"]:checked');
                    const visibility = visibilityEl ? visibilityEl.value : 'private';
                    
                    const pinnedEl = document.getElementById('note-pinned');
                    const pinned = pinnedEl ? pinnedEl.checked : false;
                    
                    const relatedClientEl = document.getElementById('related-client');
                    let relatedClient = relatedClientEl ? relatedClientEl.value : '';
                    if (relatedClient === 'other') {
                        const relatedClientOtherEl = document.getElementById('related-client-other');
                        if (relatedClientOtherEl) relatedClient = relatedClientOtherEl.value.trim();
                    }
                    
                    const relatedProjectEl = document.getElementById('related-project');
                    let relatedProject = relatedProjectEl ? relatedProjectEl.value : '';
                    if (relatedProject === 'other') {
                        const relatedProjectOtherEl = document.getElementById('related-project-other');
                        if (relatedProjectOtherEl) relatedProject = relatedProjectOtherEl.value.trim();
                    }
                    
                    const relatedTaskEl = document.getElementById('related-task');
                    let relatedTask = relatedTaskEl ? relatedTaskEl.value : '';
                    if (relatedTask === 'other') {
                        const relatedTaskOtherEl = document.getElementById('related-task-other');
                        if (relatedTaskOtherEl) relatedTask = relatedTaskOtherEl.value.trim();
                    }

                    // Get selected teams if visibility is team
                    let selectedTeams = [];
                    if (visibility === 'team') {
                        document.querySelectorAll('#team-selection-container input[type="checkbox"]:checked').forEach(checkbox => {
                            selectedTeams.push(checkbox.value);
                        });
                    }

                    // Validate required fields
                    let hasError = false;

                    if (!title) {
                        const titleError = document.getElementById('title-error');
                        if (titleError) {
                            titleError.textContent = 'Title is required';
                            titleError.classList.remove('hidden');
                        }
                        hasError = true;
                    }

                    if (!content || content === '<br>') {
                        const contentError = document.getElementById('content-error');
                        if (contentError) {
                            contentError.textContent = 'Content is required';
                            contentError.classList.remove('hidden');
                        }
                        hasError = true;
                    }

                    if (!category) {
                        const categoryError = document.getElementById('category-error');
                        if (categoryError) {
                            categoryError.textContent = 'Category is required';
                            categoryError.classList.remove('hidden');
                        }
                        hasError = true;
                    }

                    if (hasError) {
                        if (submitText) submitText.textContent = noteId ? 'Update Note' : 'Save Note';
                        if (submitSpinner) submitSpinner.classList.add('hidden');
                        if (submitBtn) submitBtn.disabled = false;
                        return;
                    }

                    // Prepare data
                    const formData = {
                        title,
                        content,
                        category,
                        visibility,
                        tags: selectedTags,
                        teams: selectedTeams,
                        related_client: relatedClient || null,
                        related_project: relatedProject || null,
                        related_task: relatedTask || null,
                        pinned
                    };

                    // Determine URL and method
                    const url = noteId ? `/api/notes/${noteId}` : '/api/notes';
                    const method = noteId ? 'PUT' : 'POST';

                    // Send request to database
                    fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': notepadCsrfToken
                        },
                        body: JSON.stringify(formData)
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw err;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                showToast('Note saved successfully', 'success');

                                // Go to detail view of the note
                                if (noteId) {
                                    showNoteDetailPage(noteId);
                                } else {
                                    showNoteDetailPage(data.note.id);
                                }
                            }
                        })
                        .catch(error => {
                            if (error.errors) {
                                // Display validation errors
                                Object.keys(error.errors).forEach(field => {
                                    const errorElement = document.getElementById(`${field}-error`);
                                    if (errorElement) {
                                        errorElement.textContent = error.errors[field][0];
                                        errorElement.classList.remove('hidden');
                                    }
                                });
                            } else {
                                console.error('Save error:', error);
                                showToast('Error saving note: ' + (error.message || 'Unknown error'), 'danger');
                            }
                        })
                        .finally(() => {
                            // Reset button state
                            if (submitText) submitText.textContent = noteId ? 'Update Note' : 'Save Note';
                            if (submitSpinner) submitSpinner.classList.add('hidden');
                            if (submitBtn) submitBtn.disabled = false;
                        });
                }

                // Open delete confirmation modal
                function openDeleteModal(noteId) {
                    noteToDelete = noteId;

                    const modalTitle = document.getElementById('delete-modal-title');
                    if (modalTitle) modalTitle.textContent = 'Preparing Delete...';

                    // Fetch note title for modal
                    fetch(`/api/notes/${noteId}`)
                        .then(response => response.json())
                        .then(note => {
                            if (modalTitle) modalTitle.textContent = `Delete "${note.title}"`;
                        })
                        .catch(() => {
                            if (modalTitle) modalTitle.textContent = 'Delete Note';
                        });

                    const deleteModal = document.getElementById('delete-modal');
                    if (deleteModal) deleteModal.classList.remove('hidden');
                }

                // Close delete modal
                function closeDeleteModal() {
                    const deleteModal = document.getElementById('delete-modal');
                    if (deleteModal) deleteModal.classList.add('hidden');
                    noteToDelete = null;
                }

                // Confirm and delete note
                function confirmDeleteNote() {
                    if (!noteToDelete) return;

                    fetch(`/api/notes/${noteToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': notepadCsrfToken
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showToast('Note deleted successfully', 'success');
                                closeDeleteModal();
                                showNotesList();
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting note:', error);
                            showToast('Error deleting note', 'danger');
                            closeDeleteModal();
                        });
                }

                // Clear all filters
                function clearFilters() {
                    document.getElementById('filter-category').value = 'all';
                    document.getElementById('filter-visibility').value = 'all';
                    document.getElementById('filter-date').value = 'all';
                    document.getElementById('filter-sort').value = 'created_at';
                    document.getElementById('global-search').value = '';
                    selectedTags = [];
                    currentFilter = 'all';
                    document.getElementById('section-title').textContent = 'All Notes';

                    loadNotes();
                }

                // Clear form errors
                function clearFormErrors() {
                    document.querySelectorAll('[id$="-error"]').forEach(element => {
                        element.textContent = '';
                        element.classList.add('hidden');
                    });
                }

                // Utility functions
                function getCategoryColor(category) {
                    const colors = {
                        client: 'bg-purple-100 text-purple-800',
                        project: 'bg-blue-100 text-blue-800',
                        task: 'bg-green-100 text-green-800',
                        meeting: 'bg-yellow-100 text-yellow-800',
                        idea: 'bg-pink-100 text-pink-800',
                        campaign: 'bg-red-100 text-red-800',
                        personal: 'bg-gray-100 text-gray-800'
                    };
                    return colors[category] || 'bg-gray-100 text-gray-800';
                }

                function getCategoryName(category) {
                    const names = {
                        client: 'Client',
                        project: 'Project',
                        task: 'Task',
                        meeting: 'Meeting',
                        idea: 'Idea',
                        campaign: 'Campaign',
                        personal: 'Personal'
                    };
                    return names[category] || category;
                }

                function getVisibilityInfo(visibility) {
                    const info = {
                        private: { icon: 'fa-lock', color: 'bg-gray-100 text-gray-800' },
                        team: { icon: 'fa-users', color: 'bg-blue-100 text-blue-800' },
                        public: { icon: 'fa-globe', color: 'bg-green-100 text-green-800' }
                    };
                    return info[visibility] || info.private;
                }

                function formatDate(dateString) {
                    if (!dateString) return 'Recently';

                    const date = new Date(dateString);
                    const now = new Date();
                    const diffMs = now - date;
                    const diffMins = Math.floor(diffMs / 60000);
                    const diffHours = Math.floor(diffMs / 3600000);
                    const diffDays = Math.floor(diffMs / 86400000);

                    if (diffMins < 1) return "Just now";
                    if (diffMins < 60) return `${diffMins}m ago`;
                    if (diffHours < 24) return `${diffHours}h ago`;
                    if (diffDays < 7) return `${diffDays}d ago`;

                    return date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined
                    });
                }

                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                function setSelectWithOther(selectId, value, defaultValue = '') {
                    const select = document.getElementById(selectId);
                    const otherInput = document.getElementById(selectId + '-other');
                    
                    if (!select) return;
                    
                    // Reset first
                    select.value = defaultValue;
                    if (otherInput) {
                        otherInput.classList.add('hidden');
                        otherInput.value = '';
                        otherInput.required = false;
                    }

                    if (!value) return;

                    // Check if value exists in options
                    let exists = false;
                    for (let i = 0; i < select.options.length; i++) {
                        if (select.options[i].value === value) {
                            exists = true;
                            break;
                        }
                    }

                    if (exists) {
                        select.value = value;
                    } else {
                        select.value = 'other';
                        if (otherInput) {
                            otherInput.classList.remove('hidden');
                            otherInput.value = value;
                            otherInput.required = true;
                        }
                    }
                }
            </script>
        </div>
    </div>
@endsection