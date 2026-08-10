<div class="space-y-12">
    <!-- Header/Hero Section -->
    <section class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 p-8 md:p-12 rounded-[2.5rem] border border-indigo-100 shadow-sm relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-200/20 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-indigo-300/30 transition-all duration-700"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-100">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight !m-0">User Module</h1>
                    <p class="text-indigo-600 font-semibold uppercase tracking-widest text-[10px] mt-1">Core Workforce Management</p>
                </div>
            </div>
            <p class="text-lg text-gray-600 leading-relaxed max-w-3xl">
The User Module in ZynCRM helps you create and manage users easily.
You can add new users and assign roles like Developer, Manager, or Designer.
It allows you to control access based on responsibilities.
This keeps your team organized and ensures proper permissions for every user.            </p>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 mb-2">Role Control</h4>
            <p class="text-sm text-gray-500 leading-relaxed">Define precise permissions for Developers, Managers, and Designers.</p>
        </div>
        <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 mb-2">Quick Onboarding</h4>
            <p class="text-sm text-gray-500 leading-relaxed">Add new users and create custom roles instantly in one workflow.</p>
        </div>
        <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 mb-2">Central Dashboard</h4>
            <p class="text-sm text-gray-500 leading-relaxed">Monitor all system users, their status, and assigned roles at a glance.</p>
        </div>
    </section>

    <!-- Detailed Guide Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 pt-4">
        <!-- Content Column -->
        <div class="lg:col-span-7 space-y-12">
            <!-- Section 1: User Roles -->
            <section id="defining-roles">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">01</span>
                    Defining User Roles
                </h3>
                <div class="prose prose-indigo max-w-none text-gray-600">
                    <p>
                        Before adding a user, it is essential to define their Role. Roles determine what data a user can access and what actions they can perform within the CRM.
                    </p>
                    <ul class="space-y-3 mt-4">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500"></i>
                            <span><strong>Developers:</strong> Full access to technical modules and logs.</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500"></i>
                            <span><strong>Managers:</strong> Overview of team performance and reports.</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500"></i>
                            <span><strong>Video Editors/Designers:</strong> Specific access to creative assets.</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Section 2: Adding Users -->
            <section id="adding-users">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">02</span>
                    Adding a New User
                </h3>
                <p class="text-gray-600 leading-relaxed mb-8">
                    To add a team member, navigate to the Users section and click on the "Add New User" button. Fill in the following required details:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                        <h5 class="font-bold text-gray-900 mb-2">Personal Info</h5>
                        <p class="text-xs text-gray-500 leading-relaxed">Full name, professional email, and a secure password.</p>
                    </div>
                    <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                        <h5 class="font-bold text-gray-900 mb-2">Salary Details</h5>
                        <p class="text-xs text-gray-500 leading-relaxed">Define the monthly compensation for the user.</p>
                    </div>
                </div>

                <!-- Instant Role Feature -->
                <div class="mt-8 bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <h4 class="text-xl font-bold mb-3 flex items-center gap-2">
                            <i data-lucide="zap" class="w-5 h-5 text-indigo-200"></i> Instant Role Creation
                        </h4>
                        <p class="text-white leading-relaxed font-medium !m-0" style="color: #fff !important;">
                            For maximum convenience, you can use the "Create New Role" field available directly inside the user form. This allows you to define a new position instantly without leaving the creation process.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Sidebar Column -->
        <div class="lg:col-span-5 space-y-8">
            <!-- Visual Reference Card -->
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl overflow-hidden flex flex-col min-h-[450px]">
                <div class="bg-white px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <div class="px-3 py-1 rounded-md bg-gray-50 border border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        Interface View
                    </div>
                </div>
                <div class="flex-1 relative bg-gray-50">
                    <img src="/assets/userimage.png" alt="User Creation Interface" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                </div>
                <div class="p-6 bg-indigo-600 text-white text-center">
                    <span class="text-sm font-bold tracking-tight flex items-center justify-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Interactive Form Design
                    </span>
                </div>
            </div>

            <!-- Helpful Tips Card -->
            <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-xl">
                <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-yellow-400"></i> Admin Tips
                </h4>
                <div class="space-y-4">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                        <p class="text-xs  leading-relaxed" style="color: #fff !important;">Always verify the email address to ensure the user receives their login credentials correctly.</p>
                    </div>
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                        <p class="text-xs text-gray-400 leading-relaxed" style="color: #fff !important;">Regularly review roles to maintain high security standards across your organization.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <section class="bg-indigo-50 border border-indigo-100 rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="max-w-xl text-center md:text-left">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Build Your Dream Team</h3>
            <p class="text-gray-600">Start organizing your workforce with ZynCRM's advanced user management tools.</p>
        </div>
        <div class="flex gap-4">
            <a href="/docs/salary" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-2xl hover:bg-indigo-50 border border-indigo-100 transition-all shadow-sm flex items-center gap-2">
                Salary Guide
            </a>
            <a href="/docs/roles" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                Roles Guide <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </section>
</div>
