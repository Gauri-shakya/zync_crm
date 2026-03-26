@extends('components.layout')

@section('content')
    <!-- Flatpickr for consistent DD/MM/YYYY date formatting -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

        .project-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .project-card:hover {
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
    </style>

    <!-- Main Container -->
    <div class="min-h-screen bg-[#f8fafc]">
        <!-- Main Content -->
        <main class="max-w-[1600px] mx-auto p-4 sm:p-6 lg:p-8 space-y-8" id="main-content">
            
            <!-- Dashboard View -->
            <div id="dashboard-view" class="space-y-8 animate-fade-in">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight" id="page-title">Project Hub</h1>
                        <p class="text-sm font-medium text-gray-500">Track, manage and optimize your digital portfolio</p>
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="relative flex-1 md:w-64">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" id="global-search" placeholder="Search projects..." 
                                class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200 rounded-2xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none shadow-sm shadow-blue-900/5">
                        </div>
                        <button id="add-project-btn"
                            class="flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-900 text-white rounded-2xl hover:bg-primary-600 font-bold transition-all shadow-lg shadow-gray-900/10 active:scale-95 whitespace-nowrap">
                            <i class="fas fa-plus text-xs"></i>
                            <span>New Project</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-blue-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-primary-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-th-large text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="total-projects">
                                <span class="block w-12 h-8 rounded-lg loading-shimmer" id="total-projects-loading"></span>
                                <span id="total-projects-text">0</span>
                            </h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Active Projects</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-yellow-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-warning mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="in-progress-count">
                                <span class="block w-12 h-8 rounded-lg loading-shimmer" id="in-progress-loading"></span>
                                <span id="in-progress-text">0</span>
                            </h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">In Progress</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-emerald-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-success mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-check-double text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="completed-count">
                                <span class="block w-12 h-8 rounded-lg loading-shimmer" id="completed-loading"></span>
                                <span id="completed-text">0</span>
                            </h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Completed</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl shadow-red-900/5 hover:-translate-y-1 transition-transform group">
                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-danger mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-fire text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight" id="high-priority-count">
                                <span class="block w-12 h-8 rounded-lg loading-shimmer" id="high-priority-loading"></span>
                                <span id="high-priority-text">0</span>
                            </h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Critical Alert</p>
                        </div>
                    </div>
                </div>

                <!-- Projects Content -->
                <div id="projects-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Dynamic Content -->
                    <div class="col-span-full flex flex-col items-center justify-center py-24 space-y-4">
                        <div class="w-16 h-16 border-4 border-primary-100 border-t-primary-600 rounded-full animate-spin"></div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Syncing Portfolio...</p>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="no-projects-message" class="hidden flex flex-col items-center justify-center py-24 bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mb-6">
                        <i class="fas fa-folder-open text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Projects Found</h3>
                    <p class="text-sm text-gray-500 mb-8">Start your journey by creating your first project</p>
                    <button id="add-first-project-btn"
                        class="px-8 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary-600 transition-all shadow-xl shadow-gray-900/10 active:scale-95">
                        Initialize Project
                    </button>
                </div>
            </div>

            <!-- Project Details View -->
            <div id="project-details-view" class="hidden animate-fade-in">
                <button id="back-to-dashboard" class="group flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary-600 transition-colors mb-8">
                    <div class="w-8 h-8 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-sm group-hover:border-primary-200">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </div>
                    Back to Hub
                </button>
                <div id="project-details-content"></div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Project Modal -->
    <div id="project-modal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 animate-fade-in">
        <div class="relative top-10 mx-auto p-0 border-0 w-full max-w-2xl shadow-2xl rounded-[2.5rem] bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="px-8 py-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-gray-900 tracking-tight" id="modal-title">Initialize Project</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">Fill in the strategic details below</p>
                </div>
                <button id="close-modal" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-900 transition-colors shadow-sm">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8">
                <form id="project-form" class="space-y-6">
                    <input type="hidden" id="project-id" value="">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Project Title</label>
                            <input type="text" id="project-name"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                placeholder="e.g. Q1 Growth Strategy" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Client Partner</label>
                            <input type="text" id="client-name"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                placeholder="Company Name" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Strategist In-Charge</label>
                            <input type="text" id="project-owner"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                placeholder="Full Name" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Specialized Team</label>
                            <div class="relative group/select">
                                <select id="project-team"
                                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer"
                                    required>
                                    <option value="">Select Domain</option>
                                    <option value="SMM">Social Media Marketing</option>
                                    <option value="Web">Web Development</option>
                                    <option value="SEO">SEO Optimization</option>
                                    <option value="Ads">Digital Advertising</option>
                                    <option value="Content">Content Strategy</option>
                                    <option value="custom" class="font-bold text-primary-600">+ Add Custom Domain</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-focus-within/select:text-primary-500 transition-colors">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <!-- Custom Domain Input (Hidden by default) -->
                            <div id="custom-domain-container" class="hidden mt-2 animate-fade-in">
                                <div class="flex gap-2">
                                    <input type="text" id="custom-domain-input" 
                                        class="flex-1 bg-white border border-primary-200 rounded-xl px-4 py-2 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none"
                                        placeholder="Enter custom domain name...">
                                    <button type="button" id="add-custom-domain-btn"
                                        class="px-4 py-2 bg-primary-600 text-white rounded-xl text-xs font-bold hover:bg-primary-700 transition-all active:scale-95">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Current Velocity</label>
                            <select id="project-status"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer"
                                required>
                                <option value="pending">Pending</option>
                                <option value="in-progress">In Progress</option>
                                <option value="review">Under Review</option>
                                <option value="completed">Finalized</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Priority Level</label>
                            <select id="project-priority"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none appearance-none cursor-pointer"
                                required>
                                <option value="low">Standard</option>
                                <option value="medium">Elevated</option>
                                <option value="high">Critical</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Start Date</label>
                            <input type="text" id="start-date"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                placeholder="DD/MM/YYYY" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Target Deadline</label>
                            <input type="text" id="deadline"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                placeholder="DD/MM/YYYY" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Velocity (%)</label>
                            <div class="flex items-center gap-4">
                                <input type="range" id="project-progress" min="0" max="100" step="1"
                                    class="flex-1 h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer accent-primary-500">
                                <span class="text-sm font-bold text-gray-900 w-8" id="progress-value">0</span>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Budget (₹)</label>
                            <input type="number" id="project-budget"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                                placeholder="0.00">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Project Scope</label>
                            <textarea rows="3" id="project-description"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none resize-none"
                                placeholder="Define the core objectives and deliverables..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-6 border-t border-gray-100">
                        <button type="button" id="cancel-modal"
                            class="px-6 py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                            Discard
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary-600 transition-all shadow-xl shadow-gray-900/10 active:scale-95"
                            id="save-project-btn">
                            Confirm Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2" id="delete-modal-title">Delete Project</h3>
                <p class="text-gray-500 mb-6" id="delete-modal-message">Are you sure you want to delete this project? This
                    action cannot be undone.</p>
                <div class="flex justify-center space-x-3">
                    <button id="cancel-delete"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">
                        Cancel
                    </button>
                    <button id="confirm-delete"
                        class="px-5 py-2.5 bg-danger text-white rounded-lg hover:bg-red-700 font-medium">
                        Delete Project
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Global variables
        let projects = [];
        let projectToDelete = null;
        let editProjectId = null;
        const projectCsrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

        // API Endpoints
        const API = {
            projects: '{{ route("projectmanagement.projects") }}',
            project: (id) => `{{ url("/projectmanagement/projects") }}/${id}`,
            store: '{{ route("projectmanagement.project.store") }}',
            update: (id) => `{{ url("/projectmanagement/projects") }}/${id}`,
            destroy: (id) => `{{ url("/projectmanagement/projects") }}/${id}`,
            statistics: '{{ route("projectmanagement.statistics") }}',
            filters: '{{ route("projectmanagement.filters") }}'
        };

        // DOM Elements
        const dashboardView = document.getElementById('dashboard-view');
        const projectDetailsView = document.getElementById('project-details-view');
        const projectsContainer = document.getElementById('projects-container');
        const projectDetailsContent = document.getElementById('project-details-content');
        const pageTitle = document.getElementById('page-title');
        const projectModal = document.getElementById('project-modal');
        const deleteModal = document.getElementById('delete-modal');
        const modalTitle = document.getElementById('modal-title');
        const addProjectBtn = document.getElementById('add-project-btn');
        const addFirstProjectBtn = document.getElementById('add-first-project-btn');
        const closeModalBtn = document.getElementById('close-modal');
        const cancelModalBtn = document.getElementById('cancel-modal');
        const backToDashboardBtn = document.getElementById('back-to-dashboard');
        const projectForm = document.getElementById('project-form');
        const progressSlider = document.getElementById('project-progress');
        const progressValue = document.getElementById('progress-value');
        const cancelDeleteBtn = document.getElementById('cancel-delete');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const globalSearch = document.getElementById('global-search');
        const filterStatus = document.getElementById('filter-status');
        const filterTeam = document.getElementById('filter-team');
        const filterPriority = document.getElementById('filter-priority');
        const clearFiltersBtn = document.getElementById('clear-filters');
        const noProjectsMessage = document.getElementById('no-projects-message');
        const saveProjectBtn = document.getElementById('save-project-btn');

        // Form fields
        const projectIdField = document.getElementById('project-id');
        const projectNameField = document.getElementById('project-name');
        const clientNameField = document.getElementById('client-name');
        const projectOwnerField = document.getElementById('project-owner');
        const projectTeamField = document.getElementById('project-team');
        const projectStatusField = document.getElementById('project-status');
        const projectPriorityField = document.getElementById('project-priority');
        const startDateField = document.getElementById('start-date');
        const deadlineField = document.getElementById('deadline');
        const projectDescriptionField = document.getElementById('project-description');
        const projectBudgetField = document.getElementById('project-budget');

        // Statistics elements
        const totalProjectsEl = document.getElementById('total-projects-text');
        const inProgressCountEl = document.getElementById('in-progress-text');
        const completedCountEl = document.getElementById('completed-text');
        const highPriorityCountEl = document.getElementById('high-priority-text');

        // Initialize Flatpickr
        let startDatePicker, deadlinePicker;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Flatpickr for date inputs
            const fpConfig = {
                altInput: true,
                altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                allowInput: true,
                disableMobile: "true" // Force flatpickr on mobile for consistent format
            };

            startDatePicker = flatpickr("#start-date", fpConfig);
            deadlinePicker = flatpickr("#deadline", fpConfig);

            // Add custom domain listener
            const teamSelect = document.getElementById('project-team');
            const customDomainContainer = document.getElementById('custom-domain-container');
            const customDomainInput = document.getElementById('custom-domain-input');
            const addCustomDomainBtn = document.getElementById('add-custom-domain-btn');

            teamSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDomainContainer.classList.remove('hidden');
                    customDomainInput.focus();
                } else {
                    customDomainContainer.classList.add('hidden');
                }
            });

            addCustomDomainBtn.addEventListener('click', function() {
                const newDomain = customDomainInput.value.trim();
                if (newDomain) {
                    const option = document.createElement('option');
                    option.value = newDomain;
                    option.textContent = newDomain;
                    // Insert before the custom option
                    teamSelect.insertBefore(option, teamSelect.lastElementChild);
                    teamSelect.value = newDomain;
                    customDomainContainer.classList.add('hidden');
                    customDomainInput.value = '';
                }
            });

            // Set default dates for form
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);

            if (startDatePicker) startDatePicker.setDate(today);
            if (deadlinePicker) deadlinePicker.setDate(nextWeek);

            // Load initial data
            loadProjects();
            loadStatistics();
            loadFilters();

            // Event listeners
            if (addProjectBtn) addProjectBtn.addEventListener('click', openAddProjectModal);
            if (addFirstProjectBtn) {
                addFirstProjectBtn.addEventListener('click', openAddProjectModal);
            }
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeProjectModal);
            if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeProjectModal);
            if (backToDashboardBtn) backToDashboardBtn.addEventListener('click', showDashboardView);
            if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);
            if (confirmDeleteBtn) confirmDeleteBtn.addEventListener('click', confirmDeleteProject);

            // Progress slider update
            if (progressSlider) {
                progressSlider.addEventListener('input', function() {
                    progressValue.textContent = this.value;
                });
            }

            // Form submission
            if (projectForm) {
                projectForm.addEventListener('submit', handleProjectSubmit);
            }

            // Search and filter events
            if (globalSearch) {
                globalSearch.addEventListener('input', handleSearch);
            }

            // Close modals when clicking outside
            window.addEventListener('click', function (e) {
                if (e.target === projectModal) {
                    closeProjectModal();
                }
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            });
        });

        // Load projects from backend
        async function loadProjects() {
            try {
                projectsContainer.innerHTML = `
                                <div class="col-span-full text-center py-12">
                                    <div class="loading mx-auto mb-4"></div>
                                    <p class="text-gray-600">Loading projects...</p>
                                </div>
                            `;

                const response = await fetch(API.projects);
                const data = await response.json();

                if (data.success) {
                    projects = data.projects;
                    renderProjects();
                } else {
                    showError('Failed to load projects: ' + data.message);
                }
            } catch (error) {
                showError('Error loading projects: ' + error.message);
            }
        }

        // Load statistics from backend
        async function loadStatistics() {
            try {
                const response = await fetch(API.statistics);
                const data = await response.json();

                if (data.success) {
                    const stats = data.statistics;
                    totalProjectsEl.textContent = stats.total_projects;
                    inProgressCountEl.textContent = stats.in_progress;
                    completedCountEl.textContent = stats.completed;
                    highPriorityCountEl.textContent = stats.high_priority;

                    // Hide loading indicators
                    document.getElementById('total-projects-loading').style.display = 'none';
                    document.getElementById('in-progress-loading').style.display = 'none';
                    document.getElementById('completed-loading').style.display = 'none';
                    document.getElementById('high-priority-loading').style.display = 'none';
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        // Load filter options
        async function loadFilters() {
            try {
                const response = await fetch(API.filters);
                const data = await response.json();

                if (data.success) {
                    const filters = data.filters;
                    const teamSelect = document.getElementById('filter-team');

                    // Clear existing options except first
                    teamSelect.innerHTML = '<option value="all">All Teams</option>';

                    // Add team options
                    filters.teams.forEach(team => {
                        const option = document.createElement('option');
                        option.value = team;
                        option.textContent = team;
                        teamSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading filters:', error);
            }
        }

        // Render projects on dashboard
        function renderProjects(projectsToRender = projects) {
            projectsContainer.innerHTML = '';

            if (projectsToRender.length === 0) {
                noProjectsMessage.classList.remove('hidden');
                projectsContainer.classList.add('hidden');
                return;
            }

            noProjectsMessage.classList.add('hidden');
            projectsContainer.classList.remove('hidden');

            projectsToRender.forEach(project => {
                const projectCard = createProjectCard(project);
                projectsContainer.appendChild(projectCard);
            });
        }

        // Create project card element
        function createProjectCard(project) {
            const card = document.createElement('div');
            card.className = 'project-card bg-white rounded-[2rem] border border-gray-100 p-6 flex flex-col justify-between';
            card.dataset.id = project.id;

            // Status and priority badges
            const statusStyle = getStatusStyle(project.status);
            const priorityStyle = getPriorityStyle(project.priority);

            card.innerHTML = `
                <div class="space-y-6">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-bold">
                                ${project.team.charAt(0)}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">${project.name}</h3>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">${project.client}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1.5">
                            <span class="${statusStyle} px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">${formatStatus(project.status)}</span>
                            <span class="${priorityStyle} px-2 py-0.5 rounded-md text-[9px] font-bold uppercase">${project.priority}</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Velocity</span>
                            <span class="text-xs font-bold text-gray-900">${project.progress}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-primary-500 h-full rounded-full transition-all duration-1000" style="width: ${project.progress}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 rounded-2xl bg-gray-50/50 border border-gray-100/50">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Strategist</p>
                            <p class="text-xs font-bold text-gray-700 truncate">${project.owner}</p>
                        </div>
                        <div class="p-3 rounded-2xl bg-gray-50/50 border border-gray-100/50">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Deadline</p>
                            <p class="text-xs font-bold text-gray-700">${formatDate(project.deadline)}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-50">
                    <div class="flex -space-x-2">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-indigo-600">JD</div>
                        <div class="w-7 h-7 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-emerald-600">AS</div>
                        <div class="w-7 h-7 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-gray-400">+2</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="edit-project-btn w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-primary-50 hover:text-primary-600 transition-all">
                            <i class="fas fa-pen text-xs"></i>
                        </button>
                        <button class="delete-project-btn w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                        <button class="view-project-btn px-4 py-1.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary-600 transition-all active:scale-95">
                            Focus
                        </button>
                    </div>
                </div>
            `;

            // Add event listeners
            card.querySelector('.view-project-btn').addEventListener('click', () => showProjectDetails(project.id));
            card.querySelector('.edit-project-btn').addEventListener('click', () => openEditProjectModal(project.id));
            card.querySelector('.delete-project-btn').addEventListener('click', () => openDeleteModal(project.id));

            return card;
        }

        function getStatusStyle(status) {
            const styles = {
                'pending': 'bg-gray-100 text-gray-600',
                'in-progress': 'bg-blue-50 text-primary-600',
                'review': 'bg-yellow-50 text-warning',
                'completed': 'bg-emerald-50 text-success'
            };
            return styles[status] || styles['pending'];
        }

        function getPriorityStyle(priority) {
            const styles = {
                'low': 'text-gray-400',
                'medium': 'text-warning',
                'high': 'text-danger'
            };
            return styles[priority] || styles['medium'];
        }

        // Show project details view
        async function showProjectDetails(projectId) {
            try {
                projectDetailsContent.innerHTML = `
                                <div class="text-center py-12">
                                    <div class="loading mx-auto mb-4"></div>
                                    <p class="text-gray-600">Loading project details...</p>
                                </div>
                            `;

                const response = await fetch(API.project(projectId));
                const data = await response.json();

                if (data.success) {
                    const project = data.project;

                    // Update page title
                    const pt = document.getElementById('page-title');
                    if (pt) pt.textContent = project.name;
                    
                    // Update header description
                    const subTitle = pt?.nextElementSibling;
                    if (subTitle && subTitle.tagName === 'P') {
                        subTitle.textContent = `Strategic insights for ${project.client}`;
                    }

                    // Hide dashboard, show project details
                    dashboardView.classList.add('hidden');
                    projectDetailsView.classList.remove('hidden');

                    // Render project details
                    renderProjectDetails(project);
                } else {
                    showError('Failed to load project: ' + data.message);
                }
            } catch (error) {
                showError('Error loading project: ' + error.message);
            }
        }

        // Render project details
        function renderProjectDetails(project) {
            // Status and priority classes
            const statusClass = getStatusClass(project.status);
            const priorityClass = getPriorityClass(project.priority);

            projectDetailsContent.innerHTML = `
                        <div class="space-y-6">
                            <!-- Project Header -->
                            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-blue-900/5">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 font-bold text-xl">
                                                ${project.team.charAt(0)}
                                            </div>
                                            <h2 class="text-3xl font-black text-gray-900 tracking-tight">${project.name}</h2>
                                        </div>
                                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest ml-1">${project.client}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button class="edit-project-details-btn px-8 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary-600 transition-all shadow-xl shadow-gray-900/10 active:scale-95">
                                            Modify Strategy
                                        </button>
                                    </div>
                                </div>

                                <!-- Progress Overview -->
                                <div class="space-y-3 mb-10">
                                    <div class="flex justify-between items-end">
                                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Project Velocity</span>
                                        <span class="text-lg font-black text-gray-900">${project.progress}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden p-1">
                                        <div class="bg-primary-500 h-full rounded-full transition-all duration-1000 shadow-sm" style="width: ${project.progress}%"></div>
                                    </div>
                                </div>

                                <!-- Project Grid Details -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Strategist</p>
                                        <p class="text-sm font-bold text-gray-900">${project.owner}</p>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Specialized Team</p>
                                        <p class="text-sm font-bold text-gray-900">${getDepartmentByTeam(project.team)}</p>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Velocity Status</p>
                                        <span class="${statusClass} px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">${formatStatus(project.status)}</span>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Priority Level</p>
                                        <span class="${priorityClass} px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">${project.priority}</span>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Start Date</p>
                                        <p class="text-sm font-bold text-gray-900">${formatDate(project.start_date)}</p>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Target Deadline</p>
                                        <p class="text-sm font-bold text-gray-900">${formatDate(project.deadline)}</p>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Budget Allocation</p>
                                        <p class="text-sm font-bold text-gray-900">₹${project.budget ? parseFloat(project.budget).toLocaleString('en-IN') : '0.00'}</p>
                                    </div>
                                    <div class="p-6 rounded-[2rem] bg-gray-50/50 border border-gray-100/50 space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Project Code</p>
                                        <p class="text-sm font-bold text-gray-900">PROJ-${String(project.id).padStart(3, '0')}</p>
                                    </div>
                                </div>

                                <!-- Project Scope -->
                                <div class="mt-8 pt-8 border-t border-gray-100">
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 ml-1">Project Scope & Objectives</h4>
                                    <div class="bg-gray-50/50 rounded-[2rem] p-8 border border-gray-100/50">
                                        <p class="text-gray-600 leading-relaxed">${project.description || 'No specific objectives defined for this strategy.'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

            // Add event listener to edit button in project details
            const editDetailsBtn = document.querySelector('.edit-project-details-btn');
            if (editDetailsBtn) {
                editDetailsBtn.addEventListener('click', () => {
                    openEditProjectModal(project.id);
                    showDashboardView(); // Go back to dashboard to see the modal
                });
            }
        }

        // Show dashboard view
        function showDashboardView() {
            dashboardView.classList.remove('hidden');
            projectDetailsView.classList.add('hidden');

            const pt = document.getElementById('page-title');
            if (pt) pt.textContent = 'Project Hub';
            
            const subTitle = pt?.nextElementSibling;
            if (subTitle && subTitle.tagName === 'P') {
                subTitle.textContent = 'Track, manage and optimize your digital portfolio';
            }

            loadProjects(); // Refresh the projects list
            loadStatistics(); // Refresh statistics
        }

        // Open add project modal
        function openAddProjectModal() {
            modalTitle.textContent = 'Add New Project';
            projectIdField.value = '';
            editProjectId = null;

            // Reset form fields and clear errors
            projectForm.reset();
            clearFormErrors();

            // Set default dates
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);

            startDateField.value = formatDateForInput(today);
            deadlineField.value = formatDateForInput(nextWeek);
            if (startDatePicker) startDatePicker.setDate(today);
            if (deadlinePicker) deadlinePicker.setDate(nextWeek);
            progressSlider.value = 0;
            progressValue.textContent = '0';
            projectBudgetField.value = '';
            projectDescriptionField.value = '';

            // Show modal
            projectModal.classList.remove('hidden');
        }

        // Open edit project modal
        async function openEditProjectModal(projectId) {
            try {
                const response = await fetch(API.project(projectId));
                const data = await response.json();

                if (data.success) {
                    const project = data.project;

                    modalTitle.textContent = 'Edit Project';
                    editProjectId = projectId;

                    // Clear form errors
                    clearFormErrors();

                    // Populate form fields
                    projectIdField.value = project.id;
                    projectNameField.value = project.name;
                    clientNameField.value = project.client;
                    projectOwnerField.value = project.owner;
                    projectTeamField.value = project.team;
                    projectStatusField.value = project.status;
                    projectPriorityField.value = project.priority;
                    if (startDatePicker) startDatePicker.setDate(project.start_date);
                    if (deadlinePicker) deadlinePicker.setDate(project.deadline);
                    projectDescriptionField.value = project.description || '';
                    projectBudgetField.value = project.budget || '';
                    progressSlider.value = project.progress;
                    progressValue.textContent = project.progress;

                    // Show modal
                    projectModal.classList.remove('hidden');
                } else {
                    showError('Failed to load project for editing: ' + data.message);
                }
            } catch (error) {
                showError('Error loading project: ' + error.message);
            }
        }

        // Handle project form submission
        async function handleProjectSubmit(e) {
            e.preventDefault();

            // Clear previous errors
            clearFormErrors();

            // Disable save button and show loading
            const originalBtnText = saveProjectBtn.innerHTML;
            saveProjectBtn.innerHTML = '<span class="loading mr-2"></span> Saving...';
            saveProjectBtn.disabled = true;

            try {
                // Prepare form data
                const formData = {
                    name: projectNameField.value,
                    client: clientNameField.value,
                    owner: projectOwnerField.value,
                    team: projectTeamField.value,
                    status: projectStatusField.value,
                    priority: projectPriorityField.value,
                    start_date: startDateField.value,
                    deadline: deadlineField.value,
                    progress: parseInt(progressSlider.value),
                    budget: projectBudgetField.value ? parseFloat(projectBudgetField.value) : null,
                    description: projectDescriptionField.value
                };

                let url, method;

                if (editProjectId) {
                    // Update existing project
                    url = API.update(editProjectId);
                    method = 'PUT';
                } else {
                    // Create new project
                    url = API.store;
                    method = 'POST';
                }

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': projectCsrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    alert(editProjectId ? 'Project updated successfully!' : 'Project created successfully!');

                    // Close modal
                    closeProjectModal();

                    // Refresh data
                    loadProjects();
                    loadStatistics();

                    // If we were in project details view, go back to dashboard
                    if (!dashboardView.classList.contains('hidden')) {
                        showDashboardView();
                    }
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        displayFormErrors(data.errors);
                    } else {
                        showError(data.message || 'An error occurred');
                    }
                }
            } catch (error) {
                showError('Error saving project: ' + error.message);
            } finally {
                // Restore save button
                saveProjectBtn.innerHTML = originalBtnText;
                saveProjectBtn.disabled = false;
            }
        }

        // Open delete confirmation modal
        function openDeleteModal(projectId) {
            const project = projects.find(p => p.id == projectId);
            if (!project) return;

            projectToDelete = projectId;

            // Update modal content
            document.getElementById('delete-modal-title').textContent = `Delete ${project.name}`;
            document.getElementById('delete-modal-message').textContent = `Are you sure you want to delete "${project.name}"? This action cannot be undone.`;

            // Show modal
            deleteModal.classList.remove('hidden');
        }

        // Confirm and delete project
        async function confirmDeleteProject() {
            if (!projectToDelete) return;

            try {
                const response = await fetch(API.destroy(projectToDelete), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': projectCsrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Project deleted successfully!');

                    // Close modal
                    closeDeleteModal();

                    // Refresh data
                    loadProjects();
                    loadStatistics();

                    // If we were in project details view, go back to dashboard
                    if (!dashboardView.classList.contains('hidden')) {
                        showDashboardView();
                    }
                } else {
                    showError('Failed to delete project: ' + data.message);
                }
            } catch (error) {
                showError('Error deleting project: ' + error.message);
            }
        }

        // Close project modal
        function closeProjectModal() {
            projectModal.classList.add('hidden');
            projectForm.reset();
            editProjectId = null;
            clearFormErrors();
        }

        // Close delete modal
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            projectToDelete = null;
        }

        // Handle search
        async function handleSearch() {
            const searchTerm = globalSearch.value.trim();

            try {
                const url = new URL(API.projects);
                if (searchTerm) {
                    url.searchParams.append('search', searchTerm);
                }
                if (filterStatus.value !== 'all') {
                    url.searchParams.append('status', filterStatus.value);
                }
                if (filterTeam.value !== 'all') {
                    url.searchParams.append('team', filterTeam.value);
                }
                if (filterPriority.value !== 'all') {
                    url.searchParams.append('priority', filterPriority.value);
                }

                const response = await fetch(url);
                const data = await response.json();

                if (data.success) {
                    renderProjects(data.projects);
                }
            } catch (error) {
                console.error('Error searching projects:', error);
            }
        }

        // Filter projects
        function filterProjects() {
            handleSearch();
        }

        // Clear all filters
        function clearFilters() {
            filterStatus.value = 'all';
            filterTeam.value = 'all';
            filterPriority.value = 'all';
            globalSearch.value = '';

            loadProjects();
        }

        // Display form errors
        function displayFormErrors(errors) {
            for (const field in errors) {
                const errorElement = document.getElementById(`${field}-error`);
                if (errorElement) {
                    errorElement.textContent = errors[field][0];
                    errorElement.classList.remove('hidden');
                }
            }
        }

        // Clear form errors
        function clearFormErrors() {
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.classList.add('hidden');
            });
        }

        // Show error message
        function showError(message) {
            alert('Error: ' + message);
        }

        // Helper functions
        function getStatusClass(status) {
            switch (status) {
                case 'pending': return 'bg-yellow-100 text-yellow-800';
                case 'in-progress': return 'bg-blue-100 text-blue-800';
                case 'review': return 'bg-purple-100 text-purple-800';
                case 'completed': return 'bg-green-100 text-green-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        function getPriorityClass(priority) {
            switch (priority) {
                case 'low': return 'bg-green-100 text-green-800';
                case 'medium': return 'bg-yellow-100 text-yellow-800';
                case 'high': return 'bg-red-100 text-red-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        function getPhaseStatusClass(status) {
            switch (status) {
                case 'completed': return 'bg-green-500';
                case 'in-progress': return 'bg-blue-500';
                case 'review': return 'bg-purple-500';
                case 'pending': return 'bg-gray-300';
                default: return 'bg-gray-300';
            }
        }

        function getDepartmentByTeam(team) {
            const teamMap = {
                'SMM': 'Social Media Marketing',
                'Web': 'Web Development',
                'SEO': 'Search Engine Optimization',
                'Ads': 'Digital Advertising',
                'Content': 'Content Marketing',
                'Email': 'Email Marketing'
            };
            return teamMap[team] || 'Digital Marketing';
        }

        function formatStatus(status) {
            if (!status) return 'Unknown';
            return status.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
        }

        function formatDate(dateString) {
            if (!dateString) return 'Not set';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function toInputDate(value) {
            if (!value) return '';
            if (typeof value === 'string') {
                const tIndex = value.indexOf('T');
                if (tIndex > 0) return value.substring(0, tIndex);
                const spaceIndex = value.indexOf(' ');
                if (spaceIndex > 0) return value.substring(0, spaceIndex);
                if (/^\d{4}-\d{2}-\d{2}$/.test(value)) return value;
            }
            const d = new Date(value);
            if (isNaN(d.getTime())) return '';
            return d.toISOString().split('T')[0];
        }

        function formatDateForInput(date) {
            return date.toISOString().split('T')[0];
        }
    </script>


@endsection
