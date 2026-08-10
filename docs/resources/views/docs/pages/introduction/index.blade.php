<div class="space-y-16">
    <!-- Hero Section with Background Image -->
    <section class="relative rounded-[2.5rem] overflow-hidden min-h-[270px] flex items-center shadow-2xl group">
        <!-- Background Image Container -->
        <div class="absolute inset-0 z-0">
            <img src="/assets/hero-banner.jpg" alt="ZynCRM Hero" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
            <!-- Professional Gradient Overlay for Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/90 via-blue-900/60 to-blue-800/20"></div>
            <!-- Subtle Mesh Gradient for Depth -->
            <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-400 via-transparent to-transparent"></div>
        </div>

        <!-- Hero Content Overlay -->
        <div class="relative z-10 px-8 md:px-16 py-8 w-full">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 backdrop-blur-md text-blue-100 text-[10px] font-bold mb-4 animate-fade-in uppercase tracking-wider">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Documentation Hub
                </div>
                
                <h1 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight mb-3 leading-tight">
                    Empower Your Business <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-indigo-100 text-xl md:text-3xl">with ZynCRM Docs</span>
                </h1>
                
                <p class="text-sm md:text-base text-blue-50/90 leading-relaxed mb-6 max-w-2xl font-medium line-clamp-2">
Master every ZynCRM module from HR automation to <br>sales pipelines and scale your operations                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="#hr-payroll" class="px-5 py-2.5 bg-white text-blue-900 font-bold rounded-lg hover:bg-blue-50 transition-all shadow-lg hover:shadow-xl active:scale-95 flex items-center gap-2 text-xs">
                        Get Started <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="/docs/besdex" class="px-5 py-2.5 bg-blue-800/40 backdrop-blur-md border border-white/20 text-white font-bold rounded-lg hover:bg-blue-800/60 transition-all flex items-center gap-2 text-xs">
                        Explore Modules
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Group: HR & Payroll -->
    <section id="hr-payroll">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 !mt-0 !mb-0">HR & Payroll</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Attendance -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Attendance</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Manage employee attendance with geo-fencing and real-time records.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/my-attendance" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">My Attendance <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                    <a href="/docs/attendance-records" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Records <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>

            <!-- Salary -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i data-lucide="credit-card" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Salary & Payroll</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Automate payroll processing, salary slips, and payment tracking.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/salary" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Guide <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>

            <!-- Leave Management -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i data-lucide="file-minus" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Leave Management</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Streamline leave applications and maintain detailed leave records.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/leave-apply" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Apply <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                    <a href="/docs/leave-record" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Records <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Group: Sales & Leads -->
    <section>
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 !mt-0 !mb-0">Sales & Automation</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Leads -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i data-lucide="user-plus" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Lead Management</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Track leads, manage pipelines, and integrate with Besdex for better conversions.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/my-leads" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">My Leads <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                    <a href="/docs/besdex" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Besdex <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>

            <!-- Proposals & Invoices -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Proposals & Invoices</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Create professional proposals and invoices to close deals faster.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/proposal" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Proposals <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                    <a href="/docs/invoice" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Invoices <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Group: Project & Tasks -->
    <section>
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 !mt-0 !mb-0">Project & Tasks</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Project Management -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Projects</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">End-to-end project management with milestones and progress tracking.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/project-management" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Guide <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>

            <!-- Tasks & Todo -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Tasks & To-Do</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Stay organized with detailed task assignments and personal todo lists.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/task" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Tasks <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                    <a href="/docs/todo" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">To-Do <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>

            <!-- Collaboration -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-yellow-600 group-hover:text-white transition-colors">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Collaboration</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Shared calendars, notes, and collaborative workspace tools.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/calendar" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Calendar <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                    <a href="/docs/notepad" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Notepad <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Group: Communication & Support -->
    <section>
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center text-white">
                <i data-lucide="message-square" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 !mt-0 !mb-0">Support & Communication</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tickets -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <i data-lucide="headphones" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Support Tickets</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Resolve client issues efficiently with a centralized ticketing system.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/my-tickets" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Guide <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>

            <!-- Interaction -->
            <div class="group p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-pink-600 group-hover:text-white transition-colors">
                    <i data-lucide="message-circle" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Client Interaction</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Real-time chat and communication tools for clients and team members.</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm">
                    <a href="/docs/interaction" class="text-blue-600 font-semibold hover:underline flex items-center gap-1">Chat Guide <i data-lucide="arrow-right" class="w-3 h-3"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Getting Started (Restored Original Content with New UI) -->
    <section class="bg-blue-50/50 rounded-[2.5rem] p-10 md:p-16 border border-blue-100 flex flex-col lg:flex-row gap-12 items-center">
        <div class="flex-1">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Ready to scale your business?</h2>
            <p class="text-gray-600 text-lg mb-10 max-w-xl leading-relaxed">
                Follow our quick-start guide to get your team up and running in ZynCRM within minutes.
            </p>
            
            <div class="space-y-6">
                <!-- Step 1 -->
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">1</div>
                    <div class="text-gray-700 font-medium pt-1">Create your business profile and invite your team.</div>
                </div>
                <!-- Step 2 -->
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">2</div>
                    <div class="text-gray-700 font-medium pt-1">Configure company details and tax settings.</div>
                </div>
                <!-- Step 3 -->
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">3</div>
                    <div class="text-gray-700 font-medium pt-1">Import your existing data and start growing.</div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-96 bg-white rounded-3xl p-8 border border-blue-100 shadow-sm">
            <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i data-lucide="help-circle" class="w-5 h-5 text-blue-600"></i> Need help?
            </h4>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Our expert team is available 24/7 to assist you with onboarding and custom configurations.
            </p>
            <a href="/docs/my-tickets" class="block w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-center shadow-lg shadow-blue-900/10">
                Contact Support
            </a>
        </div>
    </section>
</div>
