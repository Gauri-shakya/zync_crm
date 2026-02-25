@extends('components.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts Management | Digital Marketing CRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
        }
        
        .contact-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2rem;
            background: white;
            border: 1px solid rgba(243, 244, 246, 1);
        }
        
        .contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
            border-color: rgba(37, 99, 235, 0.1);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header Section -->
    <header class="bg-white shadow-sm border-b border-gray-200 hidden">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 sm:px-6 py-3 sm:py-4 space-y-3 sm:space-y-0">
            <!-- Left Section: Breadcrumb and Search -->
            <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                <!-- Search bar - full width on mobile, auto on desktop -->
                <div class="relative w-full sm:w-64">
                    <input type="text" placeholder="Search contacts..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-sm sm:text-base">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                
                <!-- Breadcrumb - hidden on small mobile, shown on larger screens -->
                <div class="hidden sm:block text-sm text-gray-500">
                    <span class="text-gray-400">/</span> CRM <span class="text-gray-400">/</span> <span class="text-indigo-600 font-medium">Contacts Grid</span>
                </div>
            </div>
            
            <!-- Right Section: User actions -->
            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto space-x-2 sm:space-x-4">
                <!-- Icons -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="relative">
                        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell text-base sm:text-lg"></i>
                        </button>
                        <span class="absolute top-0 right-0 h-2 w-2 sm:h-3 sm:w-3 bg-red-500 rounded-full"></span>
                    </div>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 hidden sm:block">
                        <i class="fas fa-cog text-base sm:text-lg"></i>
                    </button>
                </div>
                
                <!-- User profile -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                        <div class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center text-sm sm:text-base">
                            <span class="text-indigo-600 font-medium">JD</span>
                        </div>
                        <span class="font-medium hidden sm:inline">John Doe</span>
                        <i class="fas fa-chevron-down text-xs hidden sm:inline"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile breadcrumb -->
        <div class="sm:hidden px-4 pb-2">
            <div class="text-sm text-gray-500">
                <span class="text-gray-400">/</span> CRM <span class="text-gray-400">/</span> <span class="text-indigo-600 font-medium">Contacts Grid</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Page Title and Actions -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12 gap-6">
            <div>
                <h1 class="text-4xl sm:text-5xl font-black text-gray-900 tracking-tight mb-4">Contacts</h1>
                <div class="flex items-center gap-2 text-[11px] font-black uppercase tracking-[0.2em] text-gray-400">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    CRM
                    <i class="fas fa-chevron-right text-[8px] mx-1"></i>
                    <span class="text-blue-600">Contacts Grid</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Add Contact Button -->
                <button id="addContactBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-[0_10px_25px_-5px_rgba(37,99,235,0.4)] hover:shadow-[0_15px_30px_-5px_rgba(37,99,235,0.5)] active:scale-95 flex items-center gap-3">
                    <i class="fas fa-plus text-[10px]"></i>
                    <span>Add New Contact</span>
                </button>
            </div>
        </div>

        <!-- Filters and Stats Bar -->
        <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] border border-gray-50 p-4 sm:p-6 mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-8">
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Database</span>
                    <span class="text-2xl font-black text-gray-900"><span id="contactsCount">0</span> <span class="text-sm font-bold text-gray-400">Contacts</span></span>
                </div>
                <div class="h-10 w-[1px] bg-gray-100 hidden sm:block"></div>
                <div class="hidden sm:flex flex-col">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Status</span>
                    <span class="text-sm font-bold text-emerald-500 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Sync
                    </span>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <div class="relative group w-full sm:w-auto">
                    <i class="fas fa-sort-amount-down absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs transition-colors group-focus-within:text-blue-500"></i>
                    <select id="sortContacts" class="w-full sm:w-64 bg-gray-50/50 border-2 border-gray-50 rounded-2xl py-3.5 pl-10 pr-4 text-[11px] font-black uppercase tracking-widest text-gray-600 focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 outline-none transition-all appearance-none cursor-pointer">
                        <option value="latest">Sort: Newest First</option>
                        <option value="oldest">Sort: Oldest First</option>
                        <option value="a-z">Sort: Name (A-Z)</option>
                        <option value="z-a">Sort: Name (Z-A)</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-300 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <!-- Contacts Table Wrapper -->
        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_-15px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Contact Identity</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] hidden md:table-cell">Position</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] hidden lg:table-cell">Communication</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] hidden xl:table-cell">Socials</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="contactsTableBody" class="divide-y divide-gray-50">
                        <!-- Table rows will be dynamically generated here -->
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-users text-gray-300 text-3xl animate-pulse"></i>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 mb-2">Syncing Contacts</h3>
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Accessing your database...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Contact Modal -->
    <div id="addContactModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <!-- Overlay -->
        <div class="modal-overlay absolute inset-0"></div>

        <!-- Modal content -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl mx-auto z-10 max-h-[90vh] overflow-hidden relative animate-fade-in">
            <div class="p-6 sm:p-8 border-b border-gray-50 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Add Contact</h2>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Create a new database entry</p>
                </div>
                <button id="closeAddContactModal" class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <div class="p-6 sm:p-8 overflow-y-auto custom-scrollbar max-h-[calc(90vh-100px)]">
                <form id="addContactForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Full Name *</label>
                            <input type="text" id="fullName" name="name" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="e.g. John Doe" required>
                            <div id="fullNameError" class="text-red-500 text-[9px] font-bold mt-1 ml-1 hidden"></div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Position *</label>
                            <input type="text" id="position" name="position" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="e.g. CEO" required>
                            <div id="positionError" class="text-red-500 text-[9px] font-bold mt-1 ml-1 hidden"></div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Email *</label>
                            <input type="email" id="email" name="email" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="e.g. john@example.com" required>
                            <div id="emailError" class="text-red-500 text-[9px] font-bold mt-1 ml-1 hidden"></div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Phone *</label>
                            <input type="tel" name="phone" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="e.g. 9876543210" required pattern="[0-9]{10,15}">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Country *</label>
                            <input type="text" name="country" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="e.g. India" required>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-50">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 block">Social Presence</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative group">
                                <i class="fab fa-instagram absolute left-4 top-1/2 -translate-y-1/2 text-pink-500 text-xs"></i>
                                <input type="text" name="instagram" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-pink-100 focus:ring-4 focus:ring-pink-50/50 transition-all" placeholder="Instagram">
                            </div>
                            <div class="relative group">
                                <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500 text-xs"></i>
                                <input type="text" name="whatsapp" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-emerald-100 focus:ring-4 focus:ring-emerald-50/50 transition-all" placeholder="WhatsApp">
                            </div>
                            <div class="relative group">
                                <i class="fab fa-facebook absolute left-4 top-1/2 -translate-y-1/2 text-blue-600 text-xs"></i>
                                <input type="text" name="facebook" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" placeholder="Facebook">
                            </div>
                            <div class="relative group">
                                <i class="fab fa-linkedin absolute left-4 top-1/2 -translate-y-1/2 text-blue-700 text-xs"></i>
                                <input type="text" name="linkedin" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" placeholder="LinkedIn">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-4 border-t border-gray-50">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 block">Notes</label>
                        <textarea name="notes" rows="2" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="Additional notes..."></textarea>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-6">
                        <button type="button" id="cancelAddContact" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95 flex items-center gap-2">
                            <i class="fas fa-save text-[9px]" id="addContactSpinner"></i>
                            Save Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Contact Modal -->
    <div id="editContactModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="modal-overlay absolute inset-0"></div>
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl mx-auto z-10 max-h-[90vh] overflow-hidden relative animate-fade-in">
            <div class="p-6 sm:p-8 border-b border-gray-50 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Edit Profile</h2>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Modify existing details</p>
                </div>
                <button type="button" id="closeEditContactModal" class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <div class="p-6 sm:p-8 overflow-y-auto custom-scrollbar max-h-[calc(90vh-100px)]">
                <form id="editContactForm" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editContactId" name="id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Full Name *</label>
                            <input type="text" id="editFullName" name="name" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" required>
                            <div id="editFullNameError" class="text-red-500 text-[9px] font-bold mt-1 ml-1 hidden"></div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Position *</label>
                            <input type="text" id="editPosition" name="position" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" required>
                            <div id="editPositionError" class="text-red-500 text-[9px] font-bold mt-1 ml-1 hidden"></div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Email Address *</label>
                            <input type="email" id="editEmail" name="email" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" required>
                            <div id="editEmailError" class="text-red-500 text-[9px] font-bold mt-1 ml-1 hidden"></div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Phone Number *</label>
                            <input type="tel" id="editPhone" name="phone" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Country *</label>
                            <input type="text" id="editCountry" name="country" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-50">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 block">Social Media</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative">
                                <i class="fab fa-instagram absolute left-4 top-1/2 -translate-y-1/2 text-pink-500 text-xs"></i>
                                <input type="text" id="editInstagram" name="instagram" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-pink-100 focus:ring-4 focus:ring-pink-50/50 transition-all" placeholder="Instagram">
                            </div>
                            <div class="relative">
                                <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500 text-xs"></i>
                                <input type="text" id="editWhatsapp" name="whatsapp" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-emerald-100 focus:ring-4 focus:ring-emerald-50/50 transition-all" placeholder="WhatsApp">
                            </div>
                            <div class="relative">
                                <i class="fab fa-facebook absolute left-4 top-1/2 -translate-y-1/2 text-blue-600 text-xs"></i>
                                <input type="text" id="editFacebook" name="facebook" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" placeholder="Facebook">
                            </div>
                            <div class="relative">
                                <i class="fab fa-linkedin absolute left-4 top-1/2 -translate-y-1/2 text-blue-700 text-xs"></i>
                                <input type="text" id="editLinkedin" name="linkedin" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl pl-10 pr-4 py-3 text-[11px] font-bold text-gray-600 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all" placeholder="LinkedIn">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-4 border-t border-gray-50">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 block">Notes</label>
                        <textarea id="editNotes" name="notes" rows="2" class="w-full bg-gray-50 border-2 border-gray-50 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-100 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder:text-gray-300" placeholder="Additional notes..."></textarea>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-6">
                        <button type="button" onclick="closeEditContactModal()" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition-colors">
                            Discard
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95 flex items-center gap-2">
                            <i class="fas fa-sync-alt text-[9px]" id="editContactSpinner"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const contactsTableBody = document.getElementById('contactsTableBody');
        const addContactModal = document.getElementById('addContactModal');
        const editContactModal = document.getElementById('editContactModal');
        const addContactBtn = document.getElementById('addContactBtn');
        const cancelAddContact = document.getElementById('cancelAddContact');
        const addContactForm = document.getElementById('addContactForm');
        const editContactForm = document.getElementById('editContactForm');
        const sortContacts = document.getElementById('sortContacts');
        const contactsCount = document.getElementById('contactsCount');

        // Initialize the application
        function initApp() {
            loadContacts();
            
            // Set up event listeners
            addContactBtn.addEventListener('click', openAddContactModal);
            document.getElementById('closeAddContactModal').addEventListener('click', closeAddContactModal);
            document.getElementById('closeEditContactModal').addEventListener('click', closeEditContactModal);
            cancelAddContact.addEventListener('click', closeAddContactModal);
            addContactForm.addEventListener('submit', saveNewContact);
            editContactForm.addEventListener('submit', updateContact);
            sortContacts.addEventListener('change', sortContactsHandler);
            
            // Close modals when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === addContactModal) {
                    closeAddContactModal();
                }
                if (e.target === editContactModal) {
                    closeEditContactModal();
                }
            });
        }

        // Load contacts from server
        function loadContacts() {
            showLoadingState();
            
            fetch('{{ route("contacts.index") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    renderContacts(data.contacts);
                    updateContactsCount(data.contacts.length);
                } else {
                    throw new Error(data.message || 'Failed to load contacts');
                }
            })
            .catch(error => {
                console.error('Error loading contacts:', error);
                showErrorState('Failed to load contacts. Please try again. Error: ' + error.message);
            });
        }

        // Show loading state
        function showLoadingState() {
            contactsTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-gray-300 text-3xl animate-pulse"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2">Syncing Contacts</h3>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Accessing your database...</p>
                    </td>
                </tr>
            `;
        }

        // Show error state
        function showErrorState(message) {
            contactsTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-4"></i>
                        <h3 class="text-xl font-black text-gray-900 mb-2">Sync Interrupted</h3>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">${message}</p>
                        <button onclick="loadContacts()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">
                            <i class="fas fa-redo mr-2"></i> Re-Sync Database
                        </button>
                    </td>
                </tr>
            `;
        }

        // Update contacts count
        function updateContactsCount(count) {
            contactsCount.textContent = count;
        }

        // Render contacts to the table
        function renderContacts(contacts) {
            contactsTableBody.innerHTML = '';
            
            if (!contacts || contacts.length === 0) {
                contactsTableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-8">
                                <i class="fas fa-users text-blue-200 text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 mb-3 tracking-tight">Database Empty</h3>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-10">Start building your network today</p>
                            <button id="addFirstContact" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-5 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-xl">
                                <i class="fas fa-plus mr-3"></i> Add Your First Contact
                            </button>
                        </td>
                    </tr>
                `;
                document.getElementById('addFirstContact').addEventListener('click', openAddContactModal);
                return;
            }
            
            contacts.forEach(contact => {
                const row = document.createElement('tr');
                row.className = 'group hover:bg-blue-50/30 transition-all animate-fade-in';
                row.innerHTML = `
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white text-sm font-black shadow-lg">
                                ${contact.name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[13px] font-black text-gray-900 truncate group-hover:text-blue-600 transition-colors">${contact.name}</span>
                                <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Added ${new Date(contact.created_at).toLocaleDateString()}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3 hidden md:table-cell">
                        <span class="text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md uppercase tracking-widest border border-blue-100/50">
                            ${contact.position}
                        </span>
                    </td>
                    <td class="px-6 py-3 hidden lg:table-cell">
                        <div class="flex flex-col gap-0.5">
                            <div class="flex items-center gap-2 text-[11px] font-bold text-gray-600">
                                <i class="fas fa-envelope text-gray-400 text-[9px]"></i>
                                <span>${contact.email}</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] font-bold text-gray-600">
                                <i class="fas fa-phone-alt text-gray-400 text-[9px]"></i>
                                <span>${contact.phone}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3 hidden xl:table-cell">
                        <div class="flex items-center gap-1.5">
                            ${contact.instagram ? `<a href="https://instagram.com/${contact.instagram}" target="_blank" class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-pink-50 hover:text-pink-500 transition-all"><i class="fab fa-instagram text-[10px]"></i></a>` : ''}
                            ${contact.whatsapp ? `<a href="https://wa.me/${contact.whatsapp}" target="_blank" class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-emerald-50 hover:text-emerald-500 transition-all"><i class="fab fa-whatsapp text-[10px]"></i></a>` : ''}
                            ${contact.linkedin ? `<a href="${contact.linkedin}" target="_blank" class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition-all"><i class="fab fa-linkedin text-[10px]"></i></a>` : ''}
                        </div>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <button class="edit-contact w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white hover:shadow-lg transition-all" data-id="${contact.id}">
                                <i class="fas fa-edit text-[9px]"></i>
                            </button>
                            <button class="delete-contact w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-red-500 hover:text-white hover:shadow-lg transition-all" data-id="${contact.id}">
                                <i class="fas fa-trash-alt text-[9px]"></i>
                            </button>
                        </div>
                    </td>
                `;
                contactsTableBody.appendChild(row);
            });

            // Event Listeners for buttons
            document.querySelectorAll('.edit-contact').forEach(button => {
                button.addEventListener('click', function() {
                    const contactId = parseInt(this.getAttribute('data-id'));
                    openEditContactModal(contactId);
                });
            });

            document.querySelectorAll('.delete-contact').forEach(button => {
                button.addEventListener('click', function() {
                    const contactId = parseInt(this.getAttribute('data-id'));
                    deleteContact(contactId);
                });
            });
        }

        // Open Add Contact Modal
        function openAddContactModal() {
            addContactModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            clearFormErrors('add');
        }

        // Close Add Contact Modal
        function closeAddContactModal() {
            addContactModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            addContactForm.reset();
            clearFormErrors('add');
        }

        // Open Edit Contact Modal
        function openEditContactModal(contactId) {
            clearFormErrors('edit');
            
            fetch(`/contacts/${contactId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch contact: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const contact = data.contact;
                    document.getElementById('editContactId').value = contact.id;
                    document.getElementById('editFullName').value = contact.name;
                    document.getElementById('editPosition').value = contact.position;
                    document.getElementById('editEmail').value = contact.email;
                    document.getElementById('editPhone').value = contact.phone;
                    document.getElementById('editCountry').value = contact.country;
                    document.getElementById('editInstagram').value = contact.instagram || '';
                    document.getElementById('editFacebook').value = contact.facebook || '';
                    document.getElementById('editWhatsapp').value = contact.whatsapp || '';
                    document.getElementById('editLinkedin').value = contact.linkedin || '';
                    document.getElementById('editNotes').value = contact.notes || '';
                    
                    editContactModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    throw new Error(data.message || 'Failed to load contact');
                }
            })
            .catch(error => {
                console.error('Error loading contact:', error);
                showNotification('Error loading contact data: ' + error.message, 'error');
            });
        }

        // Close Edit Contact Modal
        function closeEditContactModal() {
            editContactModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            clearFormErrors('edit');
        }

        // Clear form errors
        function clearFormErrors(formType) {
            const prefix = formType === 'add' ? '' : 'edit';
            const errorElements = document.querySelectorAll(`[id$="Error"]`);
            errorElements.forEach(element => {
                if (element.id.startsWith(prefix)) {
                    element.classList.add('hidden');
                    element.textContent = '';
                }
            });
        }

        // Show form errors
        function showFormErrors(errors, formType) {
            const prefix = formType === 'add' ? '' : 'edit';
            clearFormErrors(formType);
            
            Object.keys(errors).forEach(field => {
                const errorElement = document.getElementById(`${prefix}${field.charAt(0).toUpperCase() + field.slice(1)}Error`);
                if (errorElement) {
                    errorElement.textContent = errors[field][0];
                    errorElement.classList.remove('hidden');
                }
            });
        }

        // Save New Contact
        function saveNewContact(e) {
            e.preventDefault();
            
            const submitButton = e.target.querySelector('button[type="submit"]');
            const spinner = document.getElementById('addContactSpinner');
            
            // Show loading state
            submitButton.disabled = true;
            spinner.classList.remove('hidden');
            
            // Get form data
            const formData = new FormData(addContactForm);
            
            // Add CSRF token
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("contacts.store") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadContacts();
                    closeAddContactModal();
                    showNotification(data.message || 'Contact added successfully!', 'success');
                } else {
                    if (data.errors) {
                        showFormErrors(data.errors, 'add');
                    } else {
                        throw new Error(data.message || 'Failed to add contact');
                    }
                }
            })
            .catch(error => {
                console.error('Error adding contact:', error);
                showNotification('Error adding contact: ' + error.message, 'error');
            })
            .finally(() => {
                // Restore button state
                submitButton.disabled = false;
                spinner.classList.add('hidden');
            });
        }

        // Update Contact
        function updateContact(e) {
            e.preventDefault();
            
            const contactId = document.getElementById('editContactId').value;
            const submitButton = e.target.querySelector('button[type="submit"]');
            const spinner = document.getElementById('editContactSpinner');
            
            // Show loading state
            submitButton.disabled = true;
            spinner.classList.remove('hidden');
            
            // Get form data
            const formData = new FormData(editContactForm);
            
            // Add CSRF token and method
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');

            fetch(`/contacts/${contactId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadContacts();
                    closeEditContactModal();
                    showNotification(data.message || 'Contact updated successfully!', 'success');
                } else {
                    if (data.errors) {
                        showFormErrors(data.errors, 'edit');
                    } else {
                        throw new Error(data.message || 'Failed to update contact');
                    }
                }
            })
            .catch(error => {
                console.error('Error updating contact:', error);
                showNotification('Error updating contact: ' + error.message, 'error');
            })
            .finally(() => {
                // Restore button state
                submitButton.disabled = false;
                spinner.classList.add('hidden');
            });
        }

        // Delete Contact
        function deleteContact(contactId) {
            if (confirm('Are you sure you want to delete this contact? This action cannot be undone.')) {
                fetch(`/contacts/${contactId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadContacts();
                        showNotification(data.message || 'Contact deleted successfully!', 'success');
                    } else {
                        throw new Error(data.message || 'Failed to delete contact');
                    }
                })
                .catch(error => {
                    console.error('Error deleting contact:', error);
                    showNotification('Error deleting contact: ' + error.message, 'error');
                });
            }
        }

        // Sort Contacts
        function sortContactsHandler() {
            const sortBy = sortContacts.value;
            loadContacts();
        }

        // Show notification
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            document.querySelectorAll('.notification').forEach(notification => {
                notification.remove();
            });
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification fixed bottom-8 right-8 p-6 rounded-[2rem] shadow-2xl z-[100] transform translate-y-20 opacity-0 transition-all duration-500 glass-effect border border-white/20 ${
                type === 'success' ? 'text-emerald-600' : 
                type === 'error' ? 'text-red-600' : 
                'text-blue-600'
            }`;
            notification.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center ${
                        type === 'success' ? 'bg-emerald-50' : 
                        type === 'error' ? 'bg-red-50' : 
                        'bg-blue-50'
                    }">
                        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'} text-sm"></i>
                    </div>
                    <span class="text-[11px] font-black uppercase tracking-widest">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-y-20', 'opacity-0');
            }, 10);
            
            // Remove notification after 4 seconds
            setTimeout(() => {
                notification.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 4000);
        }

        // Initialize the app
        document.addEventListener('DOMContentLoaded', initApp);
    </script>
</body>
</html>

@endsection