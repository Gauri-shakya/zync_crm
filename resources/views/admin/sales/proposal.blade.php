@extends('components.layout')

@section('content')
    <div class="flex-1 overflow-auto bg-slate-50 relative" style="background-image: radial-gradient(circle at 15% 50%, rgba(99, 102, 241, 0.05) 0%, transparent 25%), radial-gradient(circle at 85% 30%, rgba(168, 85, 247, 0.05) 0%, transparent 25%);">
        <div class="max-w-7xl mx-auto space-y-6 px-4 py-6">

            {{-- External Libraries --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.14/mammoth.browser.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/docx/7.1.0/docx.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

                /* Custom Scrollbar */
                ::-webkit-scrollbar {
                    width: 6px;
                    height: 6px;
                }
                ::-webkit-scrollbar-track {
                    background: transparent;
                }
                ::-webkit-scrollbar-thumb {
                    background: #cbd5e1;
                    border-radius: 10px;
                }
                ::-webkit-scrollbar-thumb:hover {
                    background: #94a3b8;
                }

                /* Glassmorphism & Blurs */
                .glass-panel {
                    background: rgba(255, 255, 255, 0.7);
                    backdrop-filter: blur(20px);
                    -webkit-backdrop-filter: blur(20px);
                    border: 1px solid rgba(255, 255, 255, 0.5);
                    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
                }

                /* Card Hover Effects */
                .proposal-card {
                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    cursor: pointer;
                    position: relative;
                    overflow: hidden;
                    background: rgba(255, 255, 255, 0.8);
                    border: 1px solid rgba(255, 255, 255, 0.6);
                    backdrop-filter: blur(10px);
                }
                .proposal-card:hover {
                    transform: translateY(-5px) scale(1.01);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                    border-color: #818cf8;
                    background: rgba(255, 255, 255, 0.95);
                }
                
                /* Create New Card Special Style */
                .create-card {
                    background: linear-gradient(135deg, rgba(255,255,255,0.6) 0%, rgba(248,250,252,0.6) 100%);
                    border: 2px dashed #cbd5e1;
                }
                .create-card:hover {
                    border-color: #6366f1;
                    background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
                }

                /* Editor Styles */
                .document-editor {
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
                    min-height: 1056px; /* A4 height approx */
                    width: 100%;
                    max-width: 896px; /* Match toolbar width (max-w-4xl) */
                    margin: 0 auto;
                    background: white;
                    padding: 40px; 
                    transition: box-shadow 0.3s ease;
                    border: 1px solid rgba(0,0,0,0.02);
                    transform-origin: top center;
                }
                .document-editor:focus-within {
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
                    border-color: rgba(99, 102, 241, 0.1);
                }

                [contenteditable="true"]:focus {
                    outline: none;
                }

                /* Toolbar */
                .editor-toolbar {
                    position: sticky;
                    top: 1rem;
                    z-index: 50;
                    backdrop-filter: blur(16px);
                    -webkit-backdrop-filter: blur(16px);
                    background-color: rgba(255, 255, 255, 0.8);
                    border: 1px solid rgba(255, 255, 255, 0.5);
                    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
                    max-width: 100%;
                }

                @media (max-width: 768px) {
                    .document-editor {
                        padding: 15px;
                        min-height: auto;
                        font-size: 13px;
                        width: 100% !important;
                        max-width: 100% !important;
                        min-width: unset !important;
                        transform: none !important;
                    }
                    .editor-toolbar {
                        top: 0;
                        border-radius: 0;
                        margin-bottom: 1rem;
                        overflow-x: auto;
                        justify-content: flex-start !important;
                        padding: 0.5rem;
                        white-space: nowrap;
                        -webkit-overflow-scrolling: touch;
                        display: flex !important;
                        flex-wrap: nowrap !important;
                    }
                    .editor-toolbar::-webkit-scrollbar {
                        display: none;
                    }
                    .editor-toolbar > div {
                        flex-shrink: 0 !important;
                        display: flex !important;
                        flex-wrap: nowrap !important;
                        align-items: center;
                    }
                    #fullEditorView {
                        padding-bottom: 2rem;
                    }
                    .document-container {
                        overflow-x: hidden;
                        padding: 0 5px;
                    }
                }

                /* Insert Button & Menu */
                .insert-block-wrap {
                    position: absolute;
                    bottom: -14px;
                    left: 0; 
                    right: 0;
                    height: 28px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 10;
                    opacity: 0;
                    transition: opacity 0.2s;
                    pointer-events: none;
                }
                .editable-block {
                    position: relative; /* Ensure relative positioning */
                    margin-bottom: 20px;
                }
                .editable-block:hover .insert-block-wrap {
                    opacity: 1;
                    pointer-events: auto;
                }
                .insert-block-btn {
                    width: 28px;
                    height: 28px;
                    background: #fff;
                    border: 1px solid #e5e7eb;
                    border-radius: 50%;
                    color: #6b7280;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                    transition: all 0.2s;
                }
                .insert-block-btn:hover {
                    background: #6366f1;
                    color: white;
                    border-color: #6366f1;
                    transform: scale(1.1);
                }
                
                .insert-menu {
                    position: fixed; /* Fixed to avoid overflow clipping */
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
                    padding: 6px;
                    display: none;
                    flex-direction: column;
                    width: 180px;
                    z-index: 100;
                    animation: fadeIn 0.15s ease-out;
                }
                .insert-menu.show {
                    display: flex;
                }
                .insert-menu-item {
                    padding: 10px 12px;
                    text-align: left;
                    font-size: 13px;
                    color: #374151;
                    border-radius: 8px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    font-weight: 500;
                    transition: all 0.1s;
                }
                .insert-menu-item:hover {
                    background: #f3f4f6;
                    color: #4f46e5;
                }
                .insert-menu-item i {
                    font-size: 14px;
                    color: #9ca3af;
                    width: 20px;
                    text-align: center;
                    transition: color 0.1s;
                }
                .insert-menu-item:hover i {
                    color: #6366f1;
                }

                /* Animations */
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fade-in {
                    animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }

                /* Template List */
                .template-item {
                    transition: all 0.2s ease;
                    border-radius: 12px;
                    border: 1px solid transparent;
                    position: relative;
                    overflow: hidden;
                }
                .template-item::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 4px;
                    height: 100%;
                    background: #4f46e5;
                    transform: scaleY(0);
                    transition: transform 0.2s ease;
                    transform-origin: center;
                }
                .template-item:hover {
                    background-color: rgba(248, 250, 252, 0.8);
                    border-color: #e2e8f0;
                }
                .template-active {
                    background-color: #eef2ff;
                    color: #4f46e5;
                    border-color: #c7d2fe;
                }
                .template-active::before {
                    transform: scaleY(1);
                }

                /* Utilities */
                
                /* Gradient Text */
                .text-gradient {
                    background-clip: text;
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-image: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%);
                }
            </style>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-full">
                
                <!-- Left Sidebar: Templates -->
                <div class="lg:col-span-3">
                    <div class="glass-panel rounded-2xl p-3 sticky top-4 h-[calc(100vh-6rem)] flex flex-col transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/10">
                        <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-200/50">
                            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2 tracking-tight">
                                <span class="bg-indigo-500/10 text-indigo-600 p-1.5 rounded-xl shadow-sm"><i class="fa-solid fa-layer-group text-xs"></i></span>
                                Templates
                            </h2>
                            <button id="addTemplateBtn" class="w-6 h-6 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 transition-all active:scale-95 shadow-sm border border-indigo-100" title="Add Template">
                                <i class="fas fa-plus text-[10px]"></i>
                            </button>
                        </div>
                        
                        <div id="templateList" class="space-y-2 overflow-y-auto flex-1 pr-2 custom-scrollbar">
                            <!-- Templates injected via JS -->
                            <div class="text-center py-6 text-gray-400 text-xs flex flex-col items-center">
                                <div class="w-5 h-5 border-2 border-indigo-100 border-t-indigo-500 rounded-full animate-spin mb-2"></div>
                                <span class="font-medium text-gray-500">Loading...</span>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-9">
                    
                    <!-- View: Proposal Cards -->
                    <div id="proposalCardsView" class="animate-fade-in pb-6">
                        <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
                            <div>
                                <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-700 tracking-tight mb-1">Proposals</h1>
                                <p class="text-gray-500 font-medium text-sm">Create, manage, and track your professional proposals.</p>
                            </div>
                            <div class="w-full md:w-auto">
                                <div class="relative group">
                                    <input type="text" placeholder="Search proposals..." class="pl-9 pr-4 py-2 border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 w-full md:w-64 text-xs shadow-sm transition-all group-hover:shadow-md bg-white/80 backdrop-blur-sm font-medium">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 group-hover:text-indigo-500 transition-colors text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Create New Section -->
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="text-indigo-500 bg-indigo-50 p-1.5 rounded-lg"><i class="fa-solid fa-wand-magic-sparkles"></i></span> Start New
                        </h3>
                        <div id="proposalCardsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <!-- Create New Card -->
                            <div class="create-card proposal-card blank-card rounded-2xl p-4 flex flex-col items-center justify-center text-center group h-48 transition-all duration-500">
                                <div class="w-12 h-12 bg-white text-indigo-500 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-indigo-500/30 group-hover:scale-110 border border-indigo-50">
                                    <i class="fas fa-plus text-lg"></i>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 mb-1 group-hover:text-indigo-600 transition-colors tracking-tight">Create Blank</h3>
                                <p class="text-[10px] text-gray-500 px-2 mb-3 leading-relaxed font-medium">Start from scratch or upload your own document to begin.</p>
                                <button id="openUploadModal" class="px-4 py-1.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-[10px] font-bold hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm hover:shadow-lg hover:-translate-y-1 group-hover:bg-indigo-50">
                                    Select
                                </button>
                            </div>
                            
                            <!-- Dynamic content will replace this -->
                        </div>

                        <!-- Saved Proposals Section -->
                        <div id="savedProposalsSection" class="mt-8 mb-8 hidden">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <span class="text-indigo-500 bg-indigo-50 p-1.5 rounded-lg"><i class="fa-regular fa-folder-open"></i></span> Recent Work
                            </h3>
                            <div id="savedProposalsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                <!-- Saved proposals injected here -->
                            </div>
                        </div>
                    </div>

                    <!-- View: Editor -->
                    <div id="fullEditorView" class="hidden animate-fade-in relative pb-12">
                        
                        <!-- Editor Header -->
                        <div class="glass-panel sticky top-4 z-40 rounded-2xl mb-6 p-3 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-lg shadow-gray-200/50 transition-all duration-300">
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <button id="backToCards" class="w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-xl bg-white text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all shadow-sm border border-gray-200 hover:border-indigo-200 group">
                                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform text-sm"></i>
                                </button>
                                <div class="min-w-0 flex-1">
                                    <input type="text" value="Untitled Proposal" class="text-base sm:text-lg font-bold text-gray-800 border-none focus:ring-0 p-0 hover:bg-gray-50/50 rounded px-2 transition-colors w-full truncate bg-transparent placeholder-gray-400 focus:bg-white focus:shadow-sm">
                                    <p class="text-[10px] text-gray-500 px-2 mt-0.5 flex items-center gap-1.5 font-medium">
                                        <i class="fa-regular fa-clock text-indigo-400"></i> Last saved: <span id="lastSavedTime" class="text-gray-700">Just now</span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                <div class="flex items-center gap-1.5">
                                    <button id="toggleQuickEdit" class="px-3 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition-all shadow-sm flex items-center gap-1.5 hover:border-gray-300 active:scale-95" title="Edit Proposal Details">
                                        <i class="fa-solid fa-sliders text-gray-400"></i> <span class="hidden sm:inline">Details</span>
                                    </button>
                                    <button id="saveProposal" class="px-3 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition-all shadow-sm flex items-center gap-1.5 hover:border-gray-300 active:scale-95">
                                        <i class="fas fa-save text-gray-400"></i> <span class="hidden sm:inline">Save</span>
                                    </button>
                                </div>
                                <div class="h-6 w-px bg-gray-200 mx-1"></div>
                                <div class="flex items-center gap-1.5">
                                    <button id="exportDOC" class="w-10 h-10 sm:w-auto sm:px-4 sm:py-2 flex items-center justify-center bg-blue-50 text-blue-600 border border-blue-100 rounded-xl text-xs font-bold hover:bg-blue-100 transition-all gap-1.5 active:scale-95 shadow-sm hover:shadow-blue-100">
                                        <i class="fas fa-file-word"></i> <span class="hidden sm:inline">Word</span>
                                    </button>
                                    <button id="exportPDF" class="w-10 h-10 sm:w-auto sm:px-4 sm:py-2 hidden flex items-center justify-center bg-red-50 text-red-600 border border-red-100 rounded-xl text-xs font-bold hover:bg-red-100 transition-all gap-1.5 active:scale-95 shadow-sm hover:shadow-red-100">
                                        <i class="fas fa-file-pdf"></i> <span class="hidden sm:inline">PDF</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Editor Toolbar -->
                        <div id="formattingToolbar" class="editor-toolbar rounded-2xl mb-6 p-1.5 flex flex-nowrap gap-1.5 items-center justify-start sm:justify-center mx-auto max-w-4xl transition-all duration-300">
                            <div class="flex flex-nowrap flex-shrink-0 items-center gap-1.5 bg-white/50 p-1 rounded-xl border border-gray-100/50">
                                <!-- Font Style -->
                                <div class="flex bg-gray-50 rounded-lg p-0.5 border border-gray-200/60 shadow-inner">
                                    <button onclick="formatText('bold')" title="Bold" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-bold text-xs"></i></button>
                                    <button onclick="formatText('italic')" title="Italic" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-italic text-xs"></i></button>
                                    <button onclick="formatText('underline')" title="Underline" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-underline text-xs"></i></button>
                                </div>

                                <!-- Headings -->
                                <div class="h-6 w-px bg-gray-200"></div>
                                <select onchange="formatBlock(this.value)" class="bg-gray-50 border-gray-200 rounded-lg text-xs text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-transparent py-2 pl-2 pr-6 shadow-sm hover:bg-white transition-colors cursor-pointer font-medium h-8">
                                    <option value="p">Normal Text</option>
                                    <option value="h1">Heading 1</option>
                                    <option value="h2">Heading 2</option>
                                    <option value="h3">Heading 3</option>
                                </select>

                                <!-- Alignment -->
                                <div class="h-6 w-px bg-gray-200"></div>
                                <div class="flex bg-gray-50 rounded-lg p-0.5 border border-gray-200/60 shadow-inner">
                                    <button onclick="formatText('justifyLeft')" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-align-left text-xs"></i></button>
                                    <button onclick="formatText('justifyCenter')" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-align-center text-xs"></i></button>
                                    <button onclick="formatText('justifyRight')" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-align-right text-xs"></i></button>
                                </div>
                            
                                <!-- Actions -->
                                <div class="h-6 w-px bg-gray-200"></div>
                                 <div class="flex bg-gray-50 rounded-lg p-0.5 border border-gray-200/60 shadow-inner">
                                    <button onclick="formatText('undo')" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-rotate-left text-xs"></i></button>
                                    <button onclick="formatText('redo')" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-indigo-600 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-500"><i class="fa-solid fa-rotate-right text-xs"></i></button>
                                    <button onclick="formatText('removeFormat')" class="p-1.5 hover:bg-white hover:shadow-sm hover:text-red-500 rounded-md transition-all w-8 h-8 flex items-center justify-center text-gray-400"><i class="fa-solid fa-eraser text-xs"></i></button>
                                </div>
                                

                            </div>
                        </div>

                        <!-- Document Canvas -->
                        <div class="flex justify-center px-4 document-container">
                            <div id="proposalContent" class="document-editor rounded-sm text-gray-800 leading-relaxed" contenteditable="true">
                                <h1 class="text-3xl font-bold mb-4 text-gray-900">Project Proposal</h1>
                                <p class="text-gray-600 mb-2 text-base">Start typing your proposal here...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Modal -->
            <div id="uploadModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md flex items-center justify-center z-50 hidden transition-all duration-300 opacity-0" style="transition: opacity 0.3s;">
                <div class="glass-panel bg-white/95 rounded-2xl shadow-2xl max-w-lg w-full mx-4 p-6 transform scale-95 transition-transform duration-300 border border-white/40" id="uploadModalContent">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
                            <span class="bg-indigo-50 text-indigo-500 p-1.5 rounded-lg shadow-sm"><i class="fas fa-cloud-upload-alt"></i></span>
                            Upload Document
                        </h2>
                        <button onclick="closeModal('uploadModal')" class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors border border-transparent hover:border-gray-200">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                    </div>
                    
                    <div class="border-2 border-dashed border-indigo-200/70 rounded-2xl p-8 text-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/30 transition-all relative group bg-white/50" id="dropZone">
                        <input type="file" id="fileInput" accept=".pdf,.docx,.xlsx,.xls" class="hidden">
                        <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-indigo-100 transition-all duration-300 shadow-sm border border-indigo-100">
                            <i class="fas fa-file-import text-3xl"></i>
                        </div>
                        <p class="text-xl font-bold text-gray-800 mb-2">Click to upload</p>
                        <p class="text-gray-500 mb-6 text-sm">or drag and drop your file here</p>
                        <div class="inline-flex gap-2 flex-wrap justify-center">
                            <span class="px-2.5 py-1 bg-gray-100 rounded-md text-xs text-gray-500 font-semibold border border-gray-200">PDF</span>
                            <span class="px-2.5 py-1 bg-gray-100 rounded-md text-xs text-gray-500 font-semibold border border-gray-200">DOCX</span>
                            <span class="px-2.5 py-1 bg-gray-100 rounded-md text-xs text-gray-500 font-semibold border border-gray-200">XLSX</span>
                        </div>
                    </div>

                    <div id="fileDisplay" class="mt-6 p-4 bg-emerald-50/80 border border-emerald-100 rounded-xl hidden flex items-center justify-between shadow-sm backdrop-blur-sm">
                         <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-check text-lg"></i>
                            </div>
                            <div class="text-left overflow-hidden">
                                <p id="fileNameDisplay" class="font-bold text-gray-800 text-sm truncate max-w-[200px]"></p>
                                <p id="fileSizeDisplay" class="text-xs text-emerald-600 font-medium bg-emerald-100/50 px-2 py-0.5 rounded-full inline-block mt-1"></p>
                            </div>
                        </div>
                        <button onclick="clearFileSelection()" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors border border-transparent hover:border-red-100">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <button id="cancelUpload" class="flex-1 px-6 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm active:scale-95">Cancel</button>
                        <button id="processFileBtn" class="flex-1 px-6 py-3.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span>Import File</span> <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Edit Panel -->
            <div id="quickEditPanel"
                class="fixed right-0 top-0 h-full w-full sm:w-[380px] bg-white/95 backdrop-blur-2xl shadow-2xl border-l border-white/50 transform translate-x-full transition-transform duration-300 z-50 flex flex-col">
                <div class="p-6 h-full overflow-y-auto flex flex-col">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
                             <span class="bg-indigo-50 text-indigo-500 p-1.5 rounded-lg shadow-sm"><i class="fa-solid fa-pen-to-square text-sm"></i></span>
                             Quick Edit
                        </h3>
                        <button id="closeQuickEdit" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors border border-transparent hover:border-gray-200">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-6 flex-1">
                        <div class="bg-indigo-50/50 p-5 rounded-2xl border border-indigo-100/50">
                            <h4 class="text-xs font-bold text-indigo-900 uppercase tracking-wider mb-3 opacity-70">Client Details</h4>
                            <div class="space-y-5">
                                <div class="group">
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Client Name</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"><i class="fa-regular fa-user text-sm"></i></span>
                                        <input id="editClientName" type="text" placeholder="Enter client name"
                                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium text-gray-800 shadow-sm text-sm">
                                    </div>
                                </div>
                                <div class="group">
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Company Name</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"><i class="fa-regular fa-building text-sm"></i></span>
                                        <input id="editClientCompany" type="text" placeholder="Enter company name"
                                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium text-gray-800 shadow-sm text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="bg-amber-50/50 p-5 rounded-2xl border border-amber-100/50">
                            <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-3 opacity-70">Proposal Info</h4>
                            <div class="space-y-5">
                                 <div class="group">
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Proposal Date</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-gray-400 group-focus-within:text-amber-500 transition-colors"><i class="fa-regular fa-calendar text-sm"></i></span>
                                        <input id="editProposalDate" type="date"
                                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none font-medium text-gray-800 shadow-sm text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-100">
                        <button id="applyQuickEdits"
                            class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-2 text-base">
                            <i class="fa-solid fa-check"></i> Apply Changes
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Template Modal -->
            <div id="addTemplateModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md flex items-center justify-center z-50 hidden transition-all duration-300 opacity-0">
                <div class="glass-panel bg-white/95 rounded-2xl shadow-2xl max-w-lg w-full mx-4 p-6 transform scale-95 transition-transform duration-300 border border-white/40" id="addTemplateModalContent">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
                            <span class="bg-indigo-50 text-indigo-500 p-1.5 rounded-lg shadow-sm"><i class="fa-solid fa-layer-group text-sm"></i></span>
                            Create New Template
                        </h2>
                        <button onclick="closeModal('addTemplateModal')" class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors border border-transparent hover:border-gray-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="relative group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Select Preset</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-3.5 text-gray-400 z-10 pointer-events-none"><i class="fa-solid fa-list text-sm"></i></span>
                                <select id="templatePreset" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none text-gray-700 font-medium cursor-pointer shadow-sm text-sm">
                                    <option value="">-- Choose Preset --</option>
                                    <option value="social">Social Media Marketing</option>
                                    <option value="website">Website Development</option>
                                    <option value="ads">Google Ads Campaign</option>
                                    <option value="seo">SEO Proposal</option>
                                    <option value="others">Others (Custom)</option>
                                </select>
                                <div class="absolute right-3.5 top-[0.8rem] pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div id="customFields" class="hidden space-y-5 animate-fade-in">
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Template Name</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-3.5 text-gray-400 z-10 pointer-events-none"><i class="fa-solid fa-tag text-sm"></i></span>
                                    <input id="customName" type="text" placeholder="e.g. SEO Proposal"
                                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium text-gray-800 shadow-sm text-sm">
                                </div>
                            </div>
                            
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Description</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-3.5 text-gray-400 z-10 pointer-events-none"><i class="fa-solid fa-align-left text-sm"></i></span>
                                    <textarea id="customDesc" rows="3" placeholder="Brief description of this template..."
                                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium resize-none text-gray-800 shadow-sm text-sm"></textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Icon</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-gray-400 z-10 pointer-events-none"><i class="fa-solid fa-icons text-sm"></i></span>
                                        <select id="customIcon" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none text-gray-700 font-medium cursor-pointer shadow-sm text-sm">
                                            <option value="hashtag">Social Media</option>
                                            <option value="globe">Website</option>
                                            <option value="ad">Google Ads</option>
                                            <option value="search">SEO</option>
                                            <option value="palette">Design</option>
                                            <option value="briefcase">Consulting</option>
                                            <option value="chart-line">Analytics</option>
                                        </select>
                                        <div class="absolute right-3.5 top-[0.8rem] pointer-events-none text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Color Theme</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-gray-400 z-10 pointer-events-none"><i class="fa-solid fa-palette text-sm"></i></span>
                                        <select id="customColor" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none text-gray-700 font-medium cursor-pointer shadow-sm text-sm">
                                            <option value="indigo">Indigo</option>
                                            <option value="blue">Blue</option>
                                            <option value="green">Green</option>
                                            <option value="purple">Purple</option>
                                            <option value="pink">Pink</option>
                                            <option value="red">Red</option>
                                            <option value="yellow">Yellow</option>
                                        </select>
                                        <div class="absolute right-3.5 top-[0.8rem] pointer-events-none text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-5 mt-2 border-t border-gray-100">
                        <button onclick="closeModal('addTemplateModal')"
                            class="flex-1 bg-white text-gray-700 py-2.5 rounded-xl hover:bg-gray-50 hover:text-gray-900 font-bold transition-all border border-gray-200 hover:border-gray-300 shadow-sm active:scale-95 text-sm">Cancel</button>
                            <button id="saveTemplate"
                                class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl hover:bg-indigo-700 font-bold shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-save"></i> Save Template
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Preview Modal -->
            <div id="templatePreviewModal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-md flex items-center justify-center z-50 hidden transition-all duration-300 opacity-0">
                <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl w-11/12 h-5/6 max-w-6xl mx-4 flex flex-col transform scale-95 transition-transform duration-300 border border-white/20" id="previewModalContent">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-white/50 backdrop-blur-sm rounded-t-2xl">
                        <div>
                            <h2 id="previewModalTitle" class="text-xl font-bold text-gray-800">Template Preview</h2>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                Preview mode - Click "Use Template" to begin editing
                            </p>
                        </div>
                        <button id="closePreviewModal" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-all">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <!-- Modal Content (Scrollable) -->
                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50/50 custom-scrollbar">
                        <div id="previewContent" class="bg-white rounded-xl shadow-lg ring-1 ring-gray-200/50 p-10 max-w-4xl mx-auto transform transition-all hover:shadow-xl"
                            style="transform: scale(0.9); transform-origin: top center; min-height: 800px;">
                            <!-- Template content will be injected here -->
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-between p-5 border-t border-gray-100 bg-white/50 backdrop-blur-sm rounded-b-2xl">
                        <button id="closePreviewBtn"
                            class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-300 font-semibold transition-all shadow-sm text-sm">
                            Close Preview
                        </button>
                        <button id="useTemplateFromPreview"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform active:scale-95 font-semibold hidden flex items-center gap-2 text-sm">
                            <i class="fas fa-check"></i> Use This Template
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save Confirmation Toast -->
            <div id="saveToast" class="fixed bottom-8 right-8 z-50 hidden transform transition-all duration-500 translate-y-full opacity-0">
                <div class="bg-white/90 backdrop-blur-md border border-green-100 text-gray-800 px-5 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Success</h4>
                        <p class="text-xs text-gray-600">Proposal saved successfully!</p>
                    </div>
                </div>
            </div>


            <style>
                /* Editable block styles */
                .editable-block {
                    position: relative;
                    padding: 20px;
                    margin-bottom: 20px;
                    border: 2px dashed transparent;
                    transition: all 0.2s;
                    border-radius: 8px;
                }

                .editable-block:hover {
                    border-color: #e5e7eb !important;
                    background-color: #f9fafb;
                }

                .delete-block-btn {
                    position: absolute;
                    top: 8px;
                    right: 8px;
                    background-color: #dc2626;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    padding: 4px 12px;
                    cursor: pointer;
                    opacity: 0;
                    transition: opacity 0.2s, background-color 0.2s;
                    font-size: 12px;
                    font-weight: 600;
                    z-index: 10;
                }

                .editable-block:hover .delete-block-btn {
                    opacity: 1 !important;
                }

                .delete-block-btn:hover {
                    background-color: #b91c1c !important;
                }

                /* Editable client name styles */
                .editable-client-name {
                    padding: 4px 8px;
                    border-radius: 4px;
                    cursor: text;
                    transition: background-color 0.2s;
                }

                .editable-client-name:hover {
                    background-color: #f3f4f6;
                }

                .editable-client-name:focus {
                    outline: 2px solid #6366f1;
                    outline-offset: 2px;
                    background-color: #f3f4f6;
                }
            </style>

            <script>
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                // Blank template for custom proposals
                const blankTemplate = `
                                                                                                                                        <div class="pdf-export-container">
                                                                                                                                            <div class="pdf-section" contenteditable="true">
                                                                                                                                                <p><br></p>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        `;

                // Professional proposal templates wi            th PDF-friendly styling
                // Professional proposal templates with PDF-friendly styling
                const proposalTemplates = {
                    social: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">Social Media Marketing Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#SMM-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Service Overview</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>This proposal outlines our comprehensive social media marketing services designed to increase your brand visibility, engage your target audience, and drive measurable results for your business.</p>
                                                                                                <p style="margin-top: 15px;">Our approach combines strategic planning, creative content development, and data-driven optimization to ensure your social media presence aligns with your business objectives.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Scope of Work</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Social media strategy development</li>
                                                                                                <li>Content calendar creation and management</li>
                                                                                                <li>Platform setup and optimization (Facebook, Instagram, LinkedIn, Twitter)</li>
                                                                                                <li>Monthly content creation (30 posts per platform)</li>
                                                                                                <li>Community management and engagement</li>
                                                                                                <li>Performance tracking and monthly reporting</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Deliverables</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Comprehensive social media strategy document</li>
                                                                                                <li>3-month content calendar</li>
                                                                                                <li>Branded graphics and video content</li>
                                                                                                <li>Monthly performance reports with insights</li>
                                                                                                <li>Competitor analysis and hashtag research</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Timeline</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Week 1-2:</strong> Strategy development and platform setup</p>
                                                                                                <p><strong>Week 3-4:</strong> Content creation and calendar implementation</p>
                                                                                                <p><strong>Month 2-3:</strong> Ongoing management, optimization, and reporting</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Monthly Management</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Full social media handling</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">$2,499 / month</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total (3 months)</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Minimum commitment</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">$7,497</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Terms & Conditions</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p>Payment: 50% upfront, 50% after first month.</p>
                                                                                                <p style="margin-top: 10px;">Valid for 30 days. Minimum 3-month engagement.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,

                    website: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">Website Development Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#WEB-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Project Overview</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>We propose a modern, responsive website that reflects your brand identity and converts visitors into customers. Our team specializes in creating high-performance websites that are secure, scalable, and easy to manage.</p>
                                                                                                <p style="margin-top: 15px;">This project will focus on user experience (UX), mobile responsiveness, and search engine visibility to ensure your digital presence drives business growth.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Scope of Work</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Custom UI/UX Design & Prototyping</li>
                                                                                                <li>Responsive Front-end Development (HTML5, CSS3, JS)</li>
                                                                                                <li>Content Management System (CMS) Integration</li>
                                                                                                <li>E-commerce Functionality (if required)</li>
                                                                                                <li>Basic SEO Setup & Performance Optimization</li>
                                                                                                <li>Security Configuration (SSL, Firewall)</li>
                                                                                                <li>Testing & Launch</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Deliverables</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Fully functional, mobile-responsive website</li>
                                                                                                <li>Source code and database access</li>
                                                                                                <li>User training for CMS management</li>
                                                                                                <li>1 month of post-launch support</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Timeline</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Week 1-2:</strong> Discovery & Design Phase</p>
                                                                                                <p><strong>Week 3-5:</strong> Development & Integration</p>
                                                                                                <p><strong>Week 6:</strong> Testing, Content Entry & Launch</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Website Design & Dev</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Complete site build</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Rs3,500</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">One-time cost</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">Rs3,500</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Terms & Conditions</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p>Payment: 50% deposit, 50% upon completion.</p>
                                                                                                <p style="margin-top: 10px;">Additional features billed at hourly rate.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,

                    ads: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">Google Ads Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#PPC-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Campaign Strategy</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>Maximize your ROI with targeted PPC campaigns designed to capture high-intent traffic. Our data-driven approach ensures your ad spend is utilized efficiently to generate quality leads and sales.</p>
                                                                                                <p style="margin-top: 15px;">We focus on crafting compelling ad copy, optimizing landing pages, and continuous bid management to outperform competitors.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Services Included</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Keyword Research & Competitor Analysis</li>
                                                                                                <li>Account Setup & Campaign Structuring</li>
                                                                                                <li>Ad Copywriting & A/B Testing</li>
                                                                                                <li>Bid Management & Budget Optimization</li>
                                                                                                <li>Conversion Tracking Setup</li>
                                                                                                <li>Weekly Performance Reporting</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">PPC Management Fee</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Monthly optimization & reporting</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">$1,200 / month</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total (3 months)</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Minimum term</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">$3,600</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">*Note: Ad spend is paid directly to the ad platform (Google/Facebook) and is not included in the management fee.</p>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,

                    seo: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">SEO Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#SEO-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Organic Growth Strategy</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>Improve your search engine rankings and drive organic traffic with our comprehensive SEO services. We focus on sustainable, white-hat techniques to build long-term authority for your domain.</p>
                                                                                                <p style="margin-top: 15px;">Our strategy encompasses technical optimization, high-quality content creation, and authoritative link building.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Scope of Services</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Comprehensive Site Audit & Error Fixes</li>
                                                                                                <li>On-Page Optimization (Meta tags, Headings, Images)</li>
                                                                                                <li>Technical SEO (Schema, Speed, Mobile-friendliness)</li>
                                                                                                <li>Content Strategy & Keyword Mapping</li>
                                                                                                <li>Off-Page SEO & Link Building</li>
                                                                                                <li>Google My Business Optimization</li>
                                                                                                <li>Monthly Progress Reporting</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Deliverables & Timeline</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Month 1:</strong> Audit, Keyword Research, and Technical Fixes</p>
                                                                                                <p><strong>Month 2:</strong> On-Page Optimization and Content Creation</p>
                                                                                                <p><strong>Month 3+:</strong> Link Building, Ongoing Optimization, and Reporting</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">SEO Retainer</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Monthly optimization & link building</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">$1,800 / month</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total (6 months)</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Recommended period</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">$10,800</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`
                };



                // Default templates (cannot be deleted)
                const defaultTemplates = [
                    { id: 1, name: "Social Media Marketing Proposal", description: "Complete social media strategy, content calendar, and performance tracking", key: "social", icon: "hashtag", color: "indigo", isDefault: true },
                    { id: 2, name: "Website Development Proposal", description: "Custom website design, development, and ongoing maintenance", key: "website", icon: "globe", color: "blue", isDefault: true },
                    { id: 3, name: "Google Ads Proposal", description: "PPC campaign setup, management, and optimization for maximum ROI", key: "ads", icon: "ad", color: "green", isDefault: true },
                    { id: 4, name: "SEO Proposal", description: "Search engine optimization strategy to improve organic rankings", key: "seo", icon: "search", color: "purple", isDefault: true }
                ];

                let customTemplates = [];
                let nextId = 5;
                const iconMap = { hashtag: "fas fa-hashtag", globe: "fas fa-globe", ad: "fas fa-ad", search: "fas fa-search", palette: "fas fa-palette", briefcase: "fas fa-briefcase", "chart-line": "fas fa-chart-line" };

                const proposalCardsGrid = document.getElementById('proposalCardsGrid');
                const fullEditorView = document.getElementById('fullEditorView');
                const proposalContent = document.getElementById('proposalContent');
                let currentTemplate = null;
                let selectedFile = null;
                let currentProposal = null;
                let savedProposals = [];

                // Inject Company ID for multi-tenancy scoping
                const companyId = {{ Auth::user()->company_id }};

                // localStorage functions
                function saveTemplates() {
                    const customOnly = customTemplates.filter(t => !t.isDefault);
                    localStorage.setItem(`proposalCustomTemplates_${companyId}`, JSON.stringify(customOnly));
                    localStorage.setItem(`proposalNextId_${companyId}`, nextId.toString());
                }

                async function loadTemplates() {
                    try {
                        const saved = localStorage.getItem(`proposalCustomTemplates_${companyId}`);
                        const savedNextId = localStorage.getItem(`proposalNextId_${companyId}`);

                        // Fetch hidden templates from backend
                        let hiddenTemplates = [];
                        try {
                            const response = await fetch('{{ route('proposals.hidden-templates') }}', {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await response.json();
                            hiddenTemplates = data.hidden_templates || [];
                        } catch (e) {
                            console.error('Error fetching hidden templates:', e);
                        }

                        let currentTemplates = [];

                        // Filter out hidden default templates (from backend)
                        const activeDefaults = defaultTemplates.filter(t => !hiddenTemplates.includes(t.key));

                        if (saved) {
                            const customOnly = JSON.parse(saved);
                            currentTemplates = [...activeDefaults, ...customOnly];
                        } else {
                            currentTemplates = [...activeDefaults];
                        }

                        customTemplates = currentTemplates;

                        if (savedNextId) {
                            nextId = parseInt(savedNextId);
                        }

                        // Render templates after loading
                        renderTemplates();
                    } catch (e) {
                        console.error('Error loading templates:', e);
                        customTemplates = [...defaultTemplates];
                        // Still render even if there was an error
                        renderTemplates();
                    }
                }

                async function deleteTemplate(templateId) {
                    const templateIndex = customTemplates.findIndex(t => t.id === templateId);
                    if (templateIndex === -1) return;
                    const template = customTemplates[templateIndex];

                    if (!confirm(`Are you sure you want to delete "${template.name}"? This will hide it from the list.`)) {
                        return;
                    }

                    if (template.isDefault) {
                        // For default templates, hide them via backend
                        try {
                            const response = await fetch('{{ route('proposals.hide-template') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ template_key: template.key })
                            });

                            if (!response.ok) {
                                throw new Error('Failed to hide template');
                            }
                        } catch (e) {
                            console.error('Error hiding template:', e);
                            alert('Failed to hide template. Please try again.');
                            return;
                        }
                        // Remove default template from local array as it is hidden on backend
                        customTemplates.splice(templateIndex, 1);
                    } else {
                        // Soft delete for custom templates: mark as deleted
                        template.deleted = true;
                    }

                    // Check if the deleted template is the currently active one
                    if (currentTemplate && currentTemplate.id === templateId) {
                        currentTemplate = null;
                        
                        // If we are in editor mode, exit to cards view
                        if (!document.getElementById('fullEditorView').classList.contains('hidden')) {
                            const backToCardsBtn = document.getElementById('backToCards');
                            if (backToCardsBtn) {
                                backToCardsBtn.click();
                            } else {
                                // Fallback manual switch
                                document.getElementById('fullEditorView').classList.add('hidden');
                                document.getElementById('formattingToolbar')?.classList.add('hidden');
                                document.getElementById('proposalCardsView').classList.remove('hidden');
                                renderSavedProposals();
                            }
                        }
                    }

                    saveTemplates();
                    renderTemplates();
                }

                async function switchTemplate(t) {
                    if (!fullEditorView.classList.contains('hidden')) {
                        // User is currently editing a proposal
                        if (confirm('Do you want to save your current proposal draft before switching templates?')) {
                            // User wants to save
                            await saveProposalToServer();
                            // Proceed to switch after saving
                        } else {
                            // User chose not to save, confirm discard
                            if (!confirm('Are you sure you want to discard unsaved changes and switch templates?')) {
                                return; // Cancel switch
                            }
                        }
                        
                        // Close editor and return to cards view
                        fullEditorView.classList.add('hidden');
                        const formattingToolbar = document.getElementById('formattingToolbar');
                        if (formattingToolbar) {
                            formattingToolbar.style.display = 'none';
                            formattingToolbar.classList.add('hidden');
                        }
                        document.getElementById('proposalCardsView').classList.remove('hidden');
                        renderSavedProposals();
                    }

                    // Switch to new template
                    currentTemplate = t;
                    showProposalCards(t);
                }

                // Blank Card HTML Constant
                const blankCardHTML = `
                            <div class="create-card proposal-card blank-card rounded-2xl p-4 flex flex-col items-center justify-center text-center group h-48 transition-all duration-500">
                                <div class="w-12 h-12 bg-white text-indigo-500 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-indigo-500/30 group-hover:scale-110 border border-indigo-50">
                                    <i class="fas fa-plus text-lg"></i>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 mb-1 group-hover:text-indigo-600 transition-colors tracking-tight">Create Blank</h3>
                                <p class="text-[10px] text-gray-500 px-2 mb-3 leading-relaxed font-medium">Start from scratch or upload your own document to begin.</p>
                                <button id="openUploadModal" class="px-4 py-1.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-[10px] font-bold hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm hover:shadow-lg hover:-translate-y-1 group-hover:bg-indigo-50">
                                    Select
                                </button>
                            </div>
                `;

                // Render Outer Templates (Main List)
                function renderTemplates() {
                    const list = document.getElementById('templateList');
                    list.innerHTML = '';

                    const visibleTemplates = customTemplates.filter(t => !t.deleted);

                    visibleTemplates.forEach(t => {
                        const templateItem = document.createElement('div');
                        templateItem.className = 'template-item p-4 mb-3 border border-gray-100 bg-white shadow-sm';

                        // Always show delete button
                        const deleteBtn = `
                            <button class="delete-template text-xs text-red-400 hover:text-red-600 font-medium transition-colors" onclick="deleteTemplate(${t.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;

                        templateItem.innerHTML = `
                            <h3 class="text-sm font-bold text-gray-800 mb-1 leading-tight tracking-tight">${t.name}</h3>
                            <p class="text-[11px] text-gray-500 mb-3 leading-relaxed line-clamp-2">${t.description}</p>

                            <div class="flex items-center justify-between mt-auto">
                                <button class="use-template text-[10px] bg-indigo-50 text-indigo-600 py-1.5 px-3 rounded-lg font-bold hover:bg-indigo-100 transition-all border border-indigo-100 shadow-sm flex items-center gap-1.5 group">
                                    <i class="fas fa-plus text-[9px] group-hover:scale-110 transition-transform"></i> Use
                                </button>
                                ${deleteBtn}
                            </div>
                        `;

                        templateItem.querySelector('.use-template').onclick = () => {
                            switchTemplate(t);
                        };



                        // Add delete event listener if not a default template
                        if (!t.isDefault) {
                            const delBtn = templateItem.querySelector('.delete-template');
                            if(delBtn) {
                                delBtn.onclick = (e) => {
                                    e.stopPropagation();
                                    deleteTemplate(t.id);
                                };
                            }
                        }

                        list.appendChild(templateItem);
                    });

                    // Ensure we have a valid template selected
                    if (!currentTemplate && visibleTemplates.length > 0) {
                        currentTemplate = visibleTemplates[0];
                        showProposalCards(currentTemplate);
                    } else if (visibleTemplates.length === 0) {
                        // Handle empty state - clear right side but keep blank card
                        currentTemplate = null;
                        document.getElementById('proposalCardsGrid').innerHTML = blankCardHTML + `
                            <div class="col-span-full md:col-span-1 xl:col-span-2 flex flex-col items-center justify-center text-center py-10 text-gray-400">
                                <i class="fa-regular fa-folder-open text-4xl mb-4 text-gray-300"></i>
                                <p>No templates available. Create one or start blank.</p>
                            </div>
                        `;
                        // Re-attach event listener for upload modal
                        const openUploadModalBtn = document.getElementById('openUploadModal');
                        if (openUploadModalBtn) openUploadModalBtn.onclick = () => openModal('uploadModal');
                    }
                }

                // Modal Animation Helpers
                function openModal(modalId) {
                    const modal = document.getElementById(modalId);
                    const content = modal.querySelector('div[id$="Content"]') || modal.firstElementChild;
                    
                    modal.classList.remove('hidden');
                    // Force reflow
                    void modal.offsetWidth;
                    
                    modal.classList.remove('opacity-0');
                    if(content) {
                        content.classList.remove('scale-95');
                        content.classList.add('scale-100');
                    }
                    document.body.style.overflow = 'hidden';
                }

                function closeModal(modalId) {
                    const modal = document.getElementById(modalId);
                    const content = modal.querySelector('div[id$="Content"]') || modal.firstElementChild;
                    
                    modal.classList.add('opacity-0');
                    if(content) {
                        content.classList.remove('scale-100');
                        content.classList.add('scale-95');
                    }
                    
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }, 300);
                }

                // Template Preview Modal Functions
                let currentPreviewTemplate = null;

                function showTemplatePreview(template) {
                    currentPreviewTemplate = template;
                    const modal = document.getElementById('templatePreviewModal');
                    const previewContent = document.getElementById('previewContent');
                    const modalTitle = document.getElementById('previewModalTitle');

                    // Set modal title
                    modalTitle.textContent = `${template.name} - Preview`;

                    // Get template content
                    let templateHTML = '';
                    if (template.isDefault && proposalTemplates[template.key]) {
                        // For default templates, use the predefined template
                        templateHTML = proposalTemplates[template.key];
                    } else {
                        // For custom templates, show a placeholder or blank template
                        templateHTML = blankTemplate;
                    }

                    // Inject content with sample data
                    let previewHTML = templateHTML
                        .replace(/\$\{new Date\(\)\.toLocaleDateString[^}]+\}/g, new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }))
                        .replace(/<span id="clientName"[^>]*>.*?<\/span>/g, '<span style="font-weight: 500;">Sample Client</span>')
                        .replace(/<span id="clientCompany"[^>]*>.*?<\/span>/g, '<span style="font-weight: 500;">Sample Company</span>');

                    // Remove contenteditable attributes
                    previewHTML = previewHTML.replace(/contenteditable="true"/g, '');

                    previewContent.innerHTML = previewHTML;

                    // Show modal
                    openModal('templatePreviewModal');
                }

                function closeTemplatePreview() {
                    closeModal('templatePreviewModal');
                    currentPreviewTemplate = null;
                }

                // Event Listeners for Preview Modal
                document.getElementById('closePreviewModal').onclick = closeTemplatePreview;
                document.getElementById('closePreviewBtn').onclick = closeTemplatePreview;

                // Click outside modal to close
                const templatePreviewModal = document.getElementById('templatePreviewModal');
                if (templatePreviewModal) {
                    templatePreviewModal.onclick = (e) => {
                        if (e.target.id === 'templatePreviewModal') {
                            closeTemplatePreview();
                        }
                    };
                }

                // ESC key to close
                document.addEventListener('keydown', (e) => {
                    const modal = document.getElementById('templatePreviewModal');
                    if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                        closeTemplatePreview();
                    }
                });

                // Use template from preview
                const useTemplateBtn = document.getElementById('useTemplateFromPreview');
                if (useTemplateBtn) {
                    useTemplateBtn.onclick = () => {
                        if (currentPreviewTemplate) {
                            closeTemplatePreview();
                            currentTemplate = currentPreviewTemplate;
                            showProposalCards(currentPreviewTemplate);
                        }
                    };
                }

                // Render Inner Templates (Quick Start Cards & Create New)
                function showProposalCards(template) {
                    const grid = document.getElementById('proposalCardsGrid');
                    
                    // Reset grid to show Blank Card first
                    grid.innerHTML = blankCardHTML;

                    // Re-attach event listener for upload modal since we overwrote the HTML
                    const openUploadModalBtn = document.getElementById('openUploadModal');
                    if (openUploadModalBtn) openUploadModalBtn.onclick = () => openModal('uploadModal');

                    // Create a single card for creating a new proposal with this template
                    const card = document.createElement('div');
                    card.className = "proposal-card bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-indigo-100 hover:border-indigo-500 transition-all cursor-pointer";
                    card.innerHTML = `<div class="p-4 text-center flex flex-col items-center justify-center h-full" > 
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-3 text-indigo-600">
                        <i class="${iconMap[template.icon] || 'fas fa-file-alt'} text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">Create ${template.name}</h3>
                        <p class="text-gray-500 mb-3 text-[10px]">${template.description || 'Start a new proposal using this template'}</p>
                        <button class="open-editor w-full bg-indigo-600 text-white py-1.5 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i> Create Proposal
                        </button>
                        </div>`;

                    card.onclick = () => {
                        // Prompt for client details or start with defaults
                        const clientName = prompt("Enter Client Name:", "New Client");
                        if (clientName === null) return; // Msg: Cancelled

                        const companyName = prompt("Enter Company Name:", "New Company");
                        if (companyName === null) return;

                        openFullEditor(template, { name: clientName, company: companyName });
                    };

                    proposalCardsGrid.appendChild(card);

                    // Inner Templates: Example Clients for Quick Start
                    // These are the specific instances the user sees after selecting a main category
                    // Only show for default templates, not custom templates
                    if (template.isDefault) {
                        const innerTemplates = [
                            { name: "Rahul Sharma", company: "Trendy Fashion" },
                            { name: "Priya Singh", company: "TechVision Solutions" },
                            { name: "Amit Patel", company: "HealthFirst Clinic" }
                        ];

                        innerTemplates.forEach(client => {
                            const clientCard = document.createElement('div');
                            clientCard.className = "proposal-card bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-transparent hover:border-indigo-600 transition-all cursor-pointer";
                            clientCard.innerHTML = `<div class="p-4">
                                                        <div class="flex justify-between items-start mb-3">
                                                            <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                                                                <i class="${iconMap[template.icon] || 'fas fa-file-alt'} text-base"></i>
                                                            </div>
                                                            <span class="bg-green-100 text-green-800 text-[10px] font-semibold px-2 py-0.5 rounded-full">New</span>
                                                        </div>
                                                        <h3 class="text-sm font-bold text-gray-800 mb-1">${template.name}</h3>
                                                        <div class="space-y-1.5 mb-3">
                                                            <div>
                                                                <p class="text-[9px] text-gray-500 uppercase tracking-wider font-semibold">Client</p>
                                                                <p class="font-medium text-gray-800 text-[10px]">${client.name}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-[9px] text-gray-500 uppercase tracking-wider font-semibold">Company</p>
                                                                <p class="font-medium text-gray-800 text-[10px]">${client.company}</p>
                                                            </div>
                                                        </div>
                                                        <button class="open-editor w-full bg-white border-2 border-indigo-600 text-indigo-600 py-1.5 rounded-lg text-xs font-semibold hover:bg-indigo-50 transition-colors">
                                                            Open & Edit
                                                        </button>
                                                    </div>`;

                            clientCard.onclick = () => {
                                openFullEditor(template, client);
                            };

                            proposalCardsGrid.appendChild(clientCard);
                        });
                    }
                }

                function openFullEditor(template, client) {
                    document.getElementById('proposalCardsView').classList.add('hidden');
                    fullEditorView.classList.remove('hidden');

                    // Show formatting toolbar
                    showFormattingToolbar();

                    // Check if we have a saved proposal for this client and template
                    const savedProposal = savedProposals.find(p =>
                        p.client.name === client.name &&
                        p.client.company === client.company &&
                        p.template.key === template.key
                    );

                    if (savedProposal) {
                        // Wrap saved content in editable blocks if not already wrapped
                        // Check if content already has editable-block wrappers
                        if (!savedProposal.content.includes('editable-block')) {
                            const wrappedContent = wrapContentInEditableBlocks(savedProposal.content);
                            proposalContent.innerHTML = wrappedContent;
                            savedProposal.content = wrappedContent; // Update saved version
                        } else {
                            proposalContent.innerHTML = savedProposal.content;
                        }
                        currentProposal = savedProposal;
                    } else {
                        // Wrap content in editable blocks before setting
                        const templateContent = proposalTemplates[template.key] || blankTemplate;
                        const wrappedContent = wrapContentInEditableBlocks(templateContent);
                        proposalContent.innerHTML = wrappedContent;
                        currentProposal = {
                            template: template,
                            client: client,
                            content: wrappedContent,
                            lastSaved: new Date()
                        };
                    }
                    document.querySelectorAll('#clientName').forEach(el => el.textContent = client.name);
                    document.querySelectorAll('#clientCompany').forEach(el => el.textContent = client.company);

                    document.getElementById('quickEditPanel').classList.remove('translate-x-full');
                    document.getElementById('editClientName').value = client.name;
                    document.getElementById('editClientCompany').value = client.company;
                }

                // File upload functionality
                const fileInput = document.getElementById('fileInput');
                const dropZone = document.getElementById('dropZone');
                const processFileBtn = document.getElementById('processFileBtn');
                const fileDisplay = document.getElementById('fileDisplay');
                const fileNameDisplay = document.getElementById('fileNameDisplay');
                const fileSizeDisplay = document.getElementById('fileSizeDisplay');

                function showFileName(file) {
                    selectedFile = file;
                    if (fileDisplay) fileDisplay.classList.remove('hidden');
                    if (fileNameDisplay) fileNameDisplay.textContent = file.name;
                    if (fileSizeDisplay) {
                        const size = (file.size / 1024 / 1024).toFixed(2) + " MB";
                        fileSizeDisplay.textContent = size;
                    }
                    if (processFileBtn) processFileBtn.classList.remove('hidden');
                }


                function clearFileSelection() {
                    selectedFile = null;
                    if (fileInput) fileInput.value = "";
                    if (fileDisplay) fileDisplay.classList.add('hidden');
                    if (processFileBtn) processFileBtn.classList.add('hidden');
                }

                if (dropZone) {
                    dropZone.addEventListener('click', () => { if (fileInput) fileInput.click(); });
                    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-indigo-600', 'bg-indigo-50'); });
                    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-indigo-600', 'bg-indigo-50'));
                    dropZone.addEventListener('drop', e => {
                        e.preventDefault(); dropZone.classList.remove('border-indigo-600', 'bg-indigo-50');
                        if (e.dataTransfer.files[0]) {
                            if (fileInput) fileInput.files = e.dataTransfer.files;
                            showFileName(e.dataTransfer.files[0]);
                        }
                    });
                }
                
                if (fileInput) {
                    fileInput.addEventListener('change', () => {
                        if (fileInput.files[0]) showFileName(fileInput.files[0]);
                    });
                }

                if (processFileBtn) {
                    processFileBtn.onclick = () => {
                        if (selectedFile) extractAndCreateProposal(selectedFile);
                    };
                }

                // ============================================
                // FORMATTING TOOLBAR FUNCTIONS
                // ============================================

                // Show/hide formatting toolbar
                function showFormattingToolbar() {
                    document.getElementById('formattingToolbar').style.display = 'block';
                }

                function hideFormattingToolbar() {
                    document.getElementById('formattingToolbar').style.display = 'none';
                }

                // Text formatting using execCommand
                function formatText(command) {
                    document.execCommand(command, false, null);
                }

                // Format block (heading, paragraph)
                function formatBlock(tag) {
                    if (!tag) return;
                    document.execCommand('formatBlock', false, tag);

                    // Apply inline styles based on tag
                    setTimeout(() => {
                        const selection = window.getSelection();
                        if (selection.rangeCount > 0) {
                            let element = selection.anchorNode;
                            if (element.nodeType === 3) element = element.parentElement;

                            while (element && element.tagName && element.tagName.toLowerCase() !== tag) {
                                element = element.parentElement;
                                if (!element || element.id === 'proposalContent') break;
                            }

                            if (element && element.tagName && element.tagName.toLowerCase() === tag) {
                                applyInlineStyleToElement(element, tag);
                            }
                        }
                    }, 50);
                }

                // Apply inline styles to match template pattern
                function applyInlineStyleToElement(element, tag) {
                    const styles = {
                        'h1': 'font-size: 28px; font-weight: bold; color: #1f2937; margin: 20px 0 10px 0;',
                        'h2': 'font-size: 20px; font-weight: bold; color: #1f2937; margin: 18px 0 10px 0;',
                        'h3': 'font-size: 18px; font-weight: 600; color: #374151; margin: 16px 0 8px 0;',
                        'p': 'color: #374151; margin: 10px 0; line-height: 1.6;'
                    };

                    if (styles[tag]) {
                        element.setAttribute('style', styles[tag]);
                        element.setAttribute('contenteditable', 'true');
                    }
                }

                // Font size
                function formatFontSize(size) {
                    if (!size) return;
                    document.execCommand('fontSize', false, size);
                }

                // Text color
                function formatTextColor(color) {
                    document.execCommand('foreColor', false, color);
                }

                // Background color (highlight)
                function formatBackgroundColor(color) {
                    document.execCommand('backColor', false, color);
                }

                // ============================================
                // BLOCK MANAGEMENT FUNCTIONS
                // ============================================

                let blockIdCounter = 0;

                // Add Insert Menu to DOM if not present
                if (!document.getElementById('globalInsertMenu')) {
                    const menu = document.createElement('div');
                    menu.id = 'globalInsertMenu';
                    menu.className = 'insert-menu';
                    menu.innerHTML = `
                        <div class="insert-menu-item" onclick="insertNewBlock('text')">
                            <i class="fa-solid fa-paragraph"></i> Text Block
                        </div>
                        <div class="insert-menu-item" onclick="insertNewBlock('heading')">
                            <i class="fa-solid fa-heading"></i> Heading
                        </div>
                        <div class="insert-menu-item" onclick="insertNewBlock('field')">
                            <i class="fa-solid fa-code"></i> Field Placeholder
                        </div>
                        <div class="insert-menu-item" onclick="insertNewBlock('divider')">
                            <i class="fa-solid fa-minus"></i> Divider
                        </div>
                    `;
                    document.body.appendChild(menu);
                    
                    // Close menu on click outside
                    document.addEventListener('click', (e) => {
                        if (!e.target.closest('.insert-block-btn') && !e.target.closest('.insert-menu')) {
                            menu.classList.remove('show');
                        }
                    });
                }

                let activeInsertBlockId = null;

                function openInsertMenu(btn, blockId) {
                    activeInsertBlockId = blockId;
                    const menu = document.getElementById('globalInsertMenu');
                    const rect = btn.getBoundingClientRect();
                    
                    // Position menu below the button
                    menu.style.top = (rect.bottom + 5) + 'px';
                    menu.style.left = (rect.left - (180 / 2) + 14) + 'px'; // Center relative to button
                    menu.classList.add('show');
                }

                function insertNewBlock(type) {
                    const menu = document.getElementById('globalInsertMenu');
                    menu.classList.remove('show');
                    
                    if (!activeInsertBlockId) return;
                    
                    const targetBlock = document.querySelector(`[data-block-id="${activeInsertBlockId}"]`);
                    if (!targetBlock) return;
                    
                    // Create new content based on type
                    let newContent = '';
                    if (type === 'text') {
                        newContent = `
                            <div class="pdf-section">
                                <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                    <p>New text section. Click to edit.</p>
                                </div>
                            </div>
                        `;
                    } else if (type === 'heading') {
                        newContent = `
                            <div class="pdf-section">
                                <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;" contenteditable="true">New Heading</h2>
                                <div style="color: #374151;" contenteditable="true">
                                    <p>Section content...</p>
                                </div>
                            </div>
                        `;
                    } else if (type === 'field') {
                         newContent = `
                            <div class="pdf-section">
                                <div style="color: #374151; padding: 10px; background: #f9fafb; border-radius: 8px; border: 1px dashed #d1d5db;" contenteditable="true">
                                    <p><strong>Field:</strong> @{{Field Name}}</p>
                                </div>
                            </div>
                        `;
                    } else if (type === 'divider') {
                        newContent = `
                            <div class="pdf-section">
                                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e5e7eb;">
                            </div>
                        `;
                    }
                    
                    // Create wrapper
                    const wrapper = document.createElement('div');
                    wrapper.className = 'editable-block';
                    const newBlockId = `block_${blockIdCounter++}`;
                    wrapper.setAttribute('data-block-id', newBlockId);
                    
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'delete-block-btn';
                    deleteBtn.innerHTML = '<span>×</span> Delete';
                    deleteBtn.setAttribute('onclick', `deleteBlock('${newBlockId}')`);
                    
                    const insertWrap = document.createElement('div');
                    insertWrap.className = 'insert-block-wrap';
                    insertWrap.innerHTML = `
                        <button class="insert-block-btn" onclick="openInsertMenu(this, '${newBlockId}')" title="Insert New Block">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    `;
                    
                    const temp = document.createElement('div');
                    temp.innerHTML = newContent;
                    const sectionContent = temp.firstElementChild;
                    
                    wrapper.appendChild(deleteBtn);
                    wrapper.appendChild(sectionContent);
                    wrapper.appendChild(insertWrap);
                    
                    // Insert after target block
                    targetBlock.parentNode.insertBefore(wrapper, targetBlock.nextSibling);
                    
                    // Update proposal content state
                    updateProposalContent();
                }

                function deleteBlock(blockId) {
                    if (confirm('Are you sure you want to delete this block? This action cannot be undone.')) {
                        const block = document.querySelector(`[data-block-id="${blockId}"]`);
                        if (block) {
                            block.remove();
                            updateProposalContent();
                        }
                    }
                }

                function updateProposalContent() {
                    const proposalContent = document.getElementById('proposalContent');
                    if (proposalContent && currentProposal) {
                        currentProposal.content = proposalContent.innerHTML;
                        currentProposal.lastSaved = new Date();
                    }
                }

                // Wrap content sections in editable blocks
                function wrapContentInEditableBlocks(html) {
                    // Wrap each pdf-section in an editable block
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    const sections = tempDiv.querySelectorAll('.pdf-section');
                    sections.forEach((section) => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'editable-block';
                        const blockId = `block_${blockIdCounter++}`;
                        wrapper.setAttribute('data-block-id', blockId);

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'delete-block-btn';
                        deleteBtn.innerHTML = '<span>×</span> Delete';
                        deleteBtn.setAttribute('onclick', `deleteBlock('${blockId}')`);

                        const insertWrap = document.createElement('div');
                        insertWrap.className = 'insert-block-wrap';
                        insertWrap.innerHTML = `
                            <button class="insert-block-btn" onclick="openInsertMenu(this, '${blockId}')" title="Insert New Block">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        `;

                        // Clone the section
                        const sectionClone = section.cloneNode(true);

                        // Replace original section with wrapped version
                        section.parentNode.replaceChild(wrapper, section);
                        wrapper.appendChild(deleteBtn);
                        wrapper.appendChild(sectionClone);
                        wrapper.appendChild(insertWrap);
                    });

                    return tempDiv.innerHTML;
                }

                // Helper Functions for Document Extraction

                // Group PDF text items by Y-coordinate to detect lines
                function groupItemsByLine(items) {
                    const lines = [];
                    let currentLine = [];
                    let lastY = null;

                    items.forEach(item => {
                        if (!item.transform || typeof item.transform[5] === 'undefined') return;

                        const y = Math.round(item.transform[5]);

                        if (lastY === null || Math.abs(y - lastY) < 5) {
                            currentLine.push(item);
                        } else {
                            if (currentLine.length > 0) lines.push([...currentLine]);
                            currentLine = [item];
                        }
                        lastY = y;
                    });

                    if (currentLine.length > 0) lines.push(currentLine);
                    return lines;
                }

                // Get average font height from line items
                function getAverageHeight(line) {
                    const heights = line.filter(item => item.height && item.height > 0).map(item => item.height);
                    return heights.length > 0 ? heights.reduce((sum, h) => sum + h, 0) / heights.length : 12;
                }

                // Check if text appears to be bold based on font name
                function isFontBold(line) {
                    return line.some(item => {
                        const fontName = item.fontName || '';
                        return fontName.includes('Bold') || fontName.includes('Heavy') || fontName.includes('Black');
                    });
                }

                // Detect if items form a table based on X-positions
                function detectTables(items) {
                    // Simple table detection: look for consistent X-positions across multiple lines
                    const tables = [];
                    // This is a simplified version - full implementation would be more complex
                    return tables;
                }

                // Convert detected table to HTML with inline styles
                function convertTableToHTML(tableData) {
                    let html = '<table style="border-collapse: collapse; width: 100%; margin: 15px 0; border: 1px solid #d1d5db;">\n';

                    tableData.forEach((row, rowIndex) => {
                        const isHeader = rowIndex === 0;
                        html += '  <tr>\n';

                        row.forEach(cell => {
                            const tag = isHeader ? 'th' : 'td';
                            const style = isHeader
                                ? 'padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border: 1px solid #d1d5db;'
                                : 'padding: 10px; border: 1px solid #d1d5db; color: #374151;';
                            const editable = isHeader ? '' : ' contenteditable="true"';

                            html += `    < ${tag} style = "${style}"${editable}> ${cell}</${tag}>\n`;
                        });

                        html += '  </tr>\n';
                    });

                    html += '</table>\n';
                    return html;
                }

                // Add inline styles to HTML elements
                function addInlineStylesToHTML(html) {
                    // Parse and add inline styles to match template pattern
                    let styled = html;

                    // Style headings
                    styled = styled.replace(/<h1>/gi, '<h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin: 20px 0 10px 0;" contenteditable="true">');
                    styled = styled.replace(/<h2>/gi, '<h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin: 18px 0 10px 0;" contenteditable="true">');
                    styled = styled.replace(/<h3>/gi, '<h3 style="font-size: 18px; font-weight: 600; color: #374151; margin: 16px 0 8px 0;" contenteditable="true">');
                    styled = styled.replace(/<h4>/gi, '<h4 style="font-size: 16px; font-weight: 600; color: #4b5563; margin: 14px 0 8px 0;" contenteditable="true">');

                    // Style paragraphs
                    styled = styled.replace(/<p>/gi, '<p style="color: #374151; margin: 10px 0; line-height: 1.6;" contenteditable="true">');

                    // Style lists
                    styled = styled.replace(/<ul>/gi, '<ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6; margin: 12px 0;">');
                    styled = styled.replace(/<ol>/gi, '<ol style="list-style-type: decimal; padding-left: 20px; color: #374151; line-height: 1.6; margin: 12px 0;">');
                    styled = styled.replace(/<li>/gi, '<li style="margin: 6px 0;" contenteditable="true">');

                    // Style tables
                    styled = styled.replace(/<table>/gi, '<table style="border-collapse: collapse; width: 100%; margin: 15px 0; border: 1px solid #d1d5db;">');
                    styled = styled.replace(/<th>/gi, '<th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border: 1px solid #d1d5db;">');
                    styled = styled.replace(/<td>/gi, '<td style="padding: 10px; border: 1px solid #d1d5db; color: #374151;" contenteditable="true">');

                    // Style strong/em
                    styled = styled.replace(/<strong>/gi, '<strong style="font-weight: bold; color: #1f2937;">');
                    styled = styled.replace(/<em>/gi, '<em style="font-style: italic;">');

                    return styled;
                }

                // Enhanced PDF extraction with formatting
                async function extractPDFWithFormatting(arrayBuffer) {
                    const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                    let htmlContent = '';

                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        const page = await pdf.getPage(pageNum);
                        const textContent = await page.getTextContent();

                        // Group items into lines
                        const lines = groupItemsByLine(textContent.items);

                        // Convert lines to HTML with formatting
                        lines.forEach(line => {
                            const text = line.map(item => item.str || '').join(' ').trim();
                            if (!text) return;

                            const avgHeight = getAverageHeight(line);
                            const isBold = isFontBold(line);

                            // Detect heading levels based on font size
                            if (avgHeight > 18) {
                                htmlContent += `<h1 style = "font-size: 28px; font-weight: bold; color: #1f2937; margin: 20px 0 10px 0;" contenteditable = "true" > ${text}</h1 >\n`;
                            } else if (avgHeight > 15) {
                                htmlContent += `<h2 style = "font-size: 20px; font-weight: bold; color: #1f2937; margin: 18px 0 10px 0;" contenteditable = "true" > ${text}</h2 >\n`;
                            } else if (avgHeight > 13) {
                                htmlContent += `<h3 style = "font-size: 18px; font-weight: 600; color: #374151; margin: 16px 0 8px 0;" contenteditable = "true" > ${text}</h3 >\n`;
                            } else if (isBold) {
                                htmlContent += `<p style = "font-weight: bold; color: #1f2937; margin: 10px 0; line-height: 1.6;" contenteditable = "true" > ${text}</p >\n`;
                            } else {
                                htmlContent += `<p style = "color: #374151; margin: 10px 0; line-height: 1.6;" contenteditable = "true" > ${text}</p >\n`;
                            }
                        });

                        // Add page separator
                        if (pageNum < pdf.numPages) {
                            htmlContent += '<hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">\n';
                        }
                    }

                    return htmlContent;
                }

                // Text and Field Insertion Functions
                function insertText() {
                    const selection = window.getSelection();
                    if (!selection.rangeCount) return;
                    
                    const range = selection.getRangeAt(0);
                    const p = document.createElement('p');
                    p.className = "text-gray-600 mb-2 text-base";
                    p.textContent = "New text block...";
                    
                    // Check if selection is inside proposalContent
                    if (!document.getElementById('proposalContent').contains(range.commonAncestorContainer)) {
                        document.getElementById('proposalContent').appendChild(p);
                    } else {
                        range.deleteContents();
                        range.insertNode(p);
                        // Move cursor after the new paragraph
                        range.setStartAfter(p);
                        range.setEndAfter(p);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                }

                function insertField(fieldName) {
                    const selection = window.getSelection();
                    const editor = document.getElementById('proposalContent');
                    let range;

                    if (selection.rangeCount > 0) {
                        range = selection.getRangeAt(0);
                        // Check if selection is inside proposalContent
                        if (!editor.contains(range.commonAncestorContainer)) {
                            range = null;
                        }
                    }

                    const span = document.createElement('span');
                    span.className = "bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded border border-indigo-100 font-medium text-sm select-none";
                    span.contentEditable = "false"; // Make the placeholder itself non-editable
                    // Use @ to escape Blade curly braces
                    span.textContent = `@{{` + fieldName + `}}`;
                    span.dataset.field = fieldName;

                    // Add a space after the field for easier typing
                    const space = document.createTextNode("\u00A0");

                    if (range) {
                        range.deleteContents();
                        range.insertNode(span);
                        
                        range.setStartAfter(span);
                        range.setEndAfter(span);
                        range.insertNode(space);
                        
                        // Move cursor after the space
                        range.setStartAfter(space);
                        range.setEndAfter(space);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    } else {
                        // Append to end if no valid selection
                        editor.appendChild(span);
                        editor.appendChild(space);
                        
                        // Set cursor to end
                        range = document.createRange();
                        range.setStartAfter(space);
                        range.setEndAfter(space);
                        selection.removeAllRanges();
                        selection.addRange(range);
                        editor.focus();
                    }
                }

                // Enhanced DOCX extraction with inline styles
                async function extractDOCXWithInlineStyles(arrayBuffer) {
                    const options = {
                        styleMap: [
                            "p[style-name='Heading 1'] => h1:fresh",
                            "p[style-name='Heading 2'] => h2:fresh",
                            "p[style-name='Heading 3'] => h3:fresh",
                            "p[style-name='Heading 4'] => h4:fresh",
                            "p[style-name='Normal'] => p:fresh",
                            "r[style-name='Strong'] => strong",
                            "r[style-name='Emphasis'] => em"
                        ].join("\n"),
                        convertImage: mammoth.images.imgElement(function (image) {
                            return image.read("base64").then(function (imageBuffer) {
                                return {
                                    src: "data:" + image.contentType + ";base64," + imageBuffer,
                                    style: "max-width: 100%; height: auto; margin: 20px 0;"
                                };
                            });
                        })
                    };

                    const result = await mammoth.convertToHtml({ arrayBuffer }, options);

                    // Add inline styles to the generated HTML
                    let styledHTML = addInlineStylesToHTML(result.value);

                    // Log any warnings
                    if (result.messages.length > 0) {
                        console.log("DOCX conversion messages:", result.messages);
                    }

                    return styledHTML;
                }

                // Enhanced Excel extraction with styling
                async function extractExcelWithStyling(arrayBuffer) {
                    const workbook = XLSX.read(arrayBuffer, { type: "array" });
                    const worksheet = workbook.Sheets[workbook.SheetNames[0]];

                    if (!worksheet['!ref']) return '<p style="color: #374151;">Empty spreadsheet</p>';

                    const range = XLSX.utils.decode_range(worksheet['!ref']);
                    let tableHTML = '<table style="border-collapse: collapse; width: 100%; margin: 15px 0; border: 1px solid #d1d5db;">\n';

                    for (let row = range.s.r; row <= range.e.r; row++) {
                        const isHeader = row === range.s.r;
                        tableHTML += '  <tr' + (row % 2 === 1 && !isHeader ? ' style="background-color: #f9fafb;"' : '') + '>\n';

                        for (let col = range.s.c; col <= range.e.c; col++) {
                            const cellAddress = XLSX.utils.encode_cell({ r: row, c: col });
                            const cell = worksheet[cellAddress];
                            const cellValue = cell ? (cell.v || '') : '';

                            const tag = isHeader ? 'th' : 'td';
                            const style = isHeader
                                ? 'padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border: 1px solid #d1d5db;'
                                : 'padding: 10px; border: 1px solid #d1d5db; color: #374151;';
                            const editable = isHeader ? '' : ' contenteditable="true"';

                            tableHTML += `    < ${tag} style = "${style}"${editable}> ${cellValue}</${tag}>\n`;
                        }

                        tableHTML += '  </tr>\n';
                    }

                    tableHTML += '</table>\n';
                    return tableHTML;
                }

                // Main extraction function
                async function extractAndCreateProposal(file) {
                    let extractedHTML = "<p>No content found.</p>";

                    try {
                        if (file.type === "application/pdf") {
                            const arrayBuffer = await file.arrayBuffer();
                            extractedHTML = await extractPDFWithFormatting(arrayBuffer);

                        } else if (file.name.endsWith('.docx') || file.name.endsWith('.doc')) {
                            const arrayBuffer = await file.arrayBuffer();
                            extractedHTML = await extractDOCXWithInlineStyles(arrayBuffer);

                        } else if (file.name.match(/\.(xlsx|xls)$/)) {
                            const arrayBuffer = await file.arrayBuffer();
                            extractedHTML = await extractExcelWithStyling(arrayBuffer);
                        }
                    } catch (e) {
                        console.error("Document extraction error:", e);
                        extractedHTML = "<p style='color: #dc2626;'>Error processing file: " + (e.message || "Unknown error") + "</p>";
                    }

                    document.getElementById('proposalCardsView').classList.add('hidden');
                    fullEditorView.classList.remove('hidden');
                    document.getElementById('uploadModal').classList.add('hidden');

                    // Show formatting toolbar
                    showFormattingToolbar();

                    const today = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                    // Wrap extracted content in editable blocks
                    const wrappedContent = wrapContentInEditableBlocks(extractedHTML);
                    proposalContent.innerHTML = `
                                                                                                    <div class="pdf-export-container" >
                                                                                                        <div style="text-align: center; padding: 40px 0;">
                                                                                                            <h1 contenteditable="true" style="font-size: 36px; font-weight: bold; color: #1f2937; margin-bottom: 20px;">Custom Proposal - ${file.name.split('.').slice(0, -1).join('.')}</h1>
                                                                                                            <p style="font-size: 20px; color: #374151; margin-bottom: 15px;">Prepared for <span id="clientName" class="editable-client-name" contenteditable="true" style="font-weight: bold; color: #6366f1;">Client Name</span></p>
                                                                                                            <p style="font-size: 18px; color: #6b7280;">Date: <span style="font-weight: bold;">${today}</span></p>
                                                                                                            <div contenteditable="true" style="margin-top: 40px; text-align: left;">
                                                                                                                ${wrappedContent}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                                                                                                                                            </div >
                                                                                                    `;

                    currentProposal = {
                        template: { name: "Custom Proposal", key: "custom" },
                        client: { name: "Client Name", company: "Company Name" },
                        content: proposalContent.innerHTML,
                        lastSaved: new Date()
                    };

                    document.getElementById('quickEditPanel').classList.remove('translate-x-full');
                    document.getElementById('editClientName').value = "";
                    document.getElementById('editClientCompany').value = "";
                }

                const templatePreset = document.getElementById('templatePreset');
                if (templatePreset) templatePreset.onchange = function () {
                    document.getElementById('customFields').classList.toggle('hidden', this.value !== 'others');
                };

                const addTemplateBtn = document.getElementById('addTemplateBtn');
                if (addTemplateBtn) addTemplateBtn.onclick = () => {
                    openModal('addTemplateModal');
                    if (templatePreset) templatePreset.value = '';
                    const customFields = document.getElementById('customFields');
                    if (customFields) customFields.classList.add('hidden');
                };

                const saveTemplateBtn = document.getElementById('saveTemplate');
                if (saveTemplateBtn) saveTemplateBtn.onclick = () => {
                    if (!templatePreset) return;
                    const preset = templatePreset.value;
                    if (!preset) return alert("Please select a preset");

                    let name, key = preset, icon = "hashtag", color = "indigo", description = "";

                    if (preset === 'others') {
                        name = document.getElementById('customName').value.trim();
                        if (!name) return alert("Template name required!");
                        
                        // Check if template exists
                        const existingTemplateIndex = customTemplates.findIndex(t => t.name.toLowerCase() === name.toLowerCase());
                        
                        if (existingTemplateIndex !== -1) {
                            const existing = customTemplates[existingTemplateIndex];
                            if (existing.deleted) {
                                // Restore soft-deleted template
                                if (confirm(`Template "${name}" was previously deleted. Do you want to restore it?`)) {
                                    existing.deleted = false;
                                    existing.description = document.getElementById('customDesc').value.trim();
                                    existing.icon = document.getElementById('customIcon').value;
                                    existing.color = document.getElementById('customColor').value;
                                    saveTemplates();
                                    renderTemplates();
                                    closeModal('addTemplateModal');
                                    return;
                                } else {
                                    return; // User cancelled restore
                                }
                            } else {
                                return alert("Template already exists!");
                            }
                        }
                        
                        description = document.getElementById('customDesc').value.trim();
                        icon = document.getElementById('customIcon').value;
                        color = document.getElementById('customColor').value;
                        key = "custom_" + Date.now();
                    } else {
                        const presets = {
                            social: { name: "Social Media Marketing Proposal", description: "Complete social media strategy, content calendar, and performance tracking", icon: "hashtag", color: "indigo" },
                            website: { name: "Website Development Proposal", description: "Custom website design, development, and ongoing maintenance", icon: "globe", color: "blue" },
                            ads: { name: "Google Ads Proposal", description: "PPC campaign setup, management, and optimization for maximum ROI", icon: "ad", color: "green" },
                            seo: { name: "SEO Proposal", description: "Search engine optimization strategy to improve organic rankings", icon: "search", color: "purple" }
                        };
                        const p = presets[preset];
                        
                        // Check if preset template exists
                        const existingTemplateIndex = customTemplates.findIndex(t => t.name === p.name);
                        
                        if (existingTemplateIndex !== -1) {
                            const existing = customTemplates[existingTemplateIndex];
                            if (existing.deleted) {
                                // Restore soft-deleted template
                                if (confirm(`Template "${p.name}" was previously deleted. Do you want to restore it?`)) {
                                    existing.deleted = false;
                                    saveTemplates();
                                    renderTemplates();
                                    closeModal('addTemplateModal');
                                    return;
                                } else {
                                    return;
                                }
                            } else {
                                return alert("This template already exists!");
                            }
                        }
                        
                        name = p.name;
                        description = p.description;
                        icon = p.icon;
                        color = p.color;
                    }

                    customTemplates.push({ id: nextId++, name, description, key, icon, color, isDefault: false });
                    saveTemplates();
                    renderTemplates();
                    closeModal('addTemplateModal');
                };

                const openUploadModalBtn = document.getElementById('openUploadModal');
                if (openUploadModalBtn) openUploadModalBtn.onclick = () => openModal('uploadModal');

                const cancelUploadBtn = document.getElementById('cancelUpload');
                if (cancelUploadBtn) cancelUploadBtn.onclick = () => {
                    closeModal('uploadModal');
                    setTimeout(clearFileSelection, 300);
                };

                const backToCardsBtn = document.getElementById('backToCards');
                if (backToCardsBtn) backToCardsBtn.onclick = () => {
                    fullEditorView.classList.add('hidden');
                    const formattingToolbar = document.getElementById('formattingToolbar');
                    if (formattingToolbar) {
                        formattingToolbar.style.display = 'none'; // Ensure hidden
                        formattingToolbar.classList.add('hidden'); // Double safety
                    }
                    document.getElementById('proposalCardsView').classList.remove('hidden');

                    // Also ensure saved proposals are visible if they exist
                    renderSavedProposals();
                };
                const toggleQuickEdit = document.getElementById('toggleQuickEdit');
                if (toggleQuickEdit) toggleQuickEdit.onclick = () => document.getElementById('quickEditPanel').classList.remove('translate-x-full');

                const closeQuickEdit = document.getElementById('closeQuickEdit');
                if (closeQuickEdit) closeQuickEdit.onclick = () => document.getElementById('quickEditPanel').classList.add('translate-x-full');

                const applyQuickEdits = document.getElementById('applyQuickEdits');
                if (applyQuickEdits) applyQuickEdits.onclick = () => {
                    const name = document.getElementById('editClientName').value.trim();
                    const company = document.getElementById('editClientCompany').value.trim();

                    document.querySelectorAll('#clientName').forEach(el => el.textContent = name || "Client Name");
                    document.querySelectorAll('#clientCompany').forEach(el => el.textContent = company || "Company Name");

                    document.getElementById('quickEditPanel').classList.add('translate-x-full');
                };

                // Save Proposal Function
                const saveProposalBtn = document.getElementById('saveProposal');
                if (saveProposalBtn) saveProposalBtn.onclick = () => saveProposalToServer();

                async function saveProposalToServer() {
                    const saveBtn = document.getElementById('saveProposal');
                    const originalText = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

                    const content = proposalContent.innerHTML;
                    const title = currentProposal.template ? currentProposal.template.name : 'Custom Proposal';
                    const clientName = document.getElementById('editClientName').value || "Client Name";
                    const companyName = document.getElementById('editClientCompany').value || "Company Name";

                    try {
                        const response = await fetch("{{ route('proposals.background-save') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                proposal_id: currentProposal.id,
                                content: content,
                                title: title,
                                client_name: clientName,
                                client_company: companyName,
                                template_key: currentProposal.template ? currentProposal.template.key : null,
                                settings: { key: currentProposal.template ? currentProposal.template.key : null }
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            currentProposal.id = data.proposal_id;

                            // Update UI list dynamically
                            const updatedProposalItem = {
                                id: currentProposal.id,
                                title: title,
                                content: content,
                                updated_at: new Date().toISOString(),
                                client: {
                                    contact_person: clientName,
                                    company_name: companyName
                                },
                                settings: { key: currentProposal.template ? currentProposal.template.key : null }
                            };

                            const idx = serverProposals.findIndex(p => p.id === currentProposal.id);
                            if (idx !== -1) {
                                serverProposals[idx] = updatedProposalItem;
                            } else {
                                serverProposals.unshift(updatedProposalItem);
                            }
                            renderSavedProposals();
                            // Show toast
                            const saveToast = document.getElementById('saveToast');
                            saveToast.classList.remove('hidden');
                            void saveToast.offsetWidth; // Force reflow
                            saveToast.classList.remove('translate-y-full', 'opacity-0');
                            
                            setTimeout(() => {
                                saveToast.classList.add('translate-y-full', 'opacity-0');
                                setTimeout(() => {
                                    saveToast.classList.add('hidden');
                                }, 500); // Wait for transition to complete
                            }, 3000);
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Failed to save proposal');
                    } finally {
                        saveBtn.innerHTML = originalText;
                    }
                }

                // Improved DOC Export Function
                const exportDOCBtn = document.getElementById('exportDOC');
                if (exportDOCBtn) exportDOCBtn.onclick = () => {
                    // First save the proposal
                    const saveProp = document.getElementById('saveProposal');
                    if (saveProp) saveProp.click();

                    // Get the proposal content
                    const element = document.getElementById('proposalContent').cloneNode(true);

                    // Remove edit icons and other non-printable elements
                    const editIcons = element.querySelectorAll('.edit-icon');
                    editIcons.forEach(icon => icon.remove());

                    // Remove delete buttons
                    const deleteButtons = element.querySelectorAll('.delete-block-btn');
                    deleteButtons.forEach(btn => btn.remove());

                    // Remove contenteditable attributes
                    const editableElements = element.querySelectorAll('[contenteditable="true"]');
                    editableElements.forEach(el => {
                        el.removeAttribute('contenteditable');
                    });

                    // Get properly formatted HTML content
                    const htmlContent = element.innerHTML;

                    // Create proper Word document with Microsoft Word HTML format
                    const wordDocument = `
                            <html xmlns:o='urn:schemas-microsoft-com:office:office' 
                                  xmlns:w='urn:schemas-microsoft-com:office:word' 
                                  xmlns='http://www.w3.org/TR/REC-html40'>
                            <head>
                                <meta charset='utf-8'>
                                <title>Proposal Document</title>
                                <!--[if gte mso 9]>
                                <xml>
                                    <w:WordDocument>
                                        <w:View>Print</w:View>
                                        <w:Zoom>100</w:Zoom>
                                        <w:DoNotOptimizeForBrowser/>
                                    </w:WordDocument>
                                </xml>
                                <![endif]-->
                                <style>
                                    @page {
                                        size: A4;
                                        margin: 1in;
                                    }
                                    body {
                                        font-family: 'Calibri', 'Arial', sans-serif;
                                        font-size: 11pt;
                                        line-height: 1.5;
                                        color: #000000;
                                    }
                                    h1 {
                                        font-size: 24pt;
                                        font-weight: bold;
                                        margin: 12pt 0;
                                    }
                                    h2 {
                                        font-size: 18pt;
                                        font-weight: bold;
                                        margin: 10pt 0;
                                    }
                                    h3 {
                                        font-size: 14pt;
                                        font-weight: bold;
                                        margin: 8pt 0;
                                    }
                                    p {
                                        margin: 6pt 0;
                                    }
                                    table {
                                        border-collapse: collapse;
                                        width: 100%;
                                        margin: 10pt 0;
                                    }
                                    th, td {
                                        border: 1pt solid #000000;
                                        padding: 6pt;
                                    }
                                    th {
                                        background-color: #f3f4f6;
                                        font-weight: bold;
                                    }
                                    ul, ol {
                                        margin: 6pt 0;
                                        padding-left: 20pt;
                                    }
                                    li {
                                        margin: 3pt 0;
                                    }
                                </style>
                            </head>
                            <body>
                                ${htmlContent}
                            </body>
                            </html>
                        `;

                    // Create a Blob with proper Word document format
                    const blob = new Blob(['\ufeff', wordDocument], {
                        type: 'application/msword'
                    });

                    // Create a download link
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'proposal.doc';

                    // Trigger download
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Clean up the URL object
                    URL.revokeObjectURL(link.href);
                };


                // Fixed PDF Export Function
                const exportPDFBtn = document.getElementById('exportPDF');
                if (exportPDFBtn) exportPDFBtn.onclick = () => {
                    // First save the proposal
                    const saveProp = document.getElementById('saveProposal');
                    if (saveProp) saveProp.click();

                    // Create a clone of the proposal content to avoid affecting the original
                    const contentElement = document.getElementById('proposalContent');
                    if (!contentElement) return;
                    
                    const element = contentElement.cloneNode(true);

                    // Remove edit icons and other non-printable elements
                    const editIcons = element.querySelectorAll('.edit-icon');
                    editIcons.forEach(icon => icon.remove());

                    // Remove contenteditable attributes for PDF
                    const editableElements = element.querySelectorAll('[contenteditable="true"]');
                    editableElements.forEach(el => {
                        el.removeAttribute('contenteditable');
                    });

                    // Configure PDF options with proper margins and scaling
                    const opt = {
                        margin: [0.5, 0.5, 0.5, 0.5], // Top, Right, Bottom, Left margins
                        filename: 'proposal.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: {
                            scale: 2,
                            useCORS: true,
                            logging: false,
                            letterRendering: true,
                            width: element.scrollWidth,
                            height: element.scrollHeight
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'a4',
                            orientation: 'portrait'
                        },
                        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                    };

                    // Generate and save PDF
                    html2pdf().set(opt).from(element).save();
                };

                // Initialize the app
                (async () => {
                    await loadTemplates(); // loadTemplates now calls renderTemplates internally
                })();

                // Initialize Saved Proposals from Server
                const serverProposals = @json($proposals);
                renderSavedProposals();

                function renderSavedProposals() {
                    const grid = document.getElementById('savedProposalsGrid');
                    const section = document.getElementById('savedProposalsSection');

                    if (serverProposals.length === 0) {
                        section.classList.add('hidden');
                        return;
                    }

                    section.classList.remove('hidden');
                    grid.innerHTML = '';

                    serverProposals.forEach(p => {
                        const date = new Date(p.updated_at).toLocaleDateString();
                        const card = document.createElement('div');
                        card.className = "bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-indigo-100 hover:border-indigo-300 transition-all";
                        card.innerHTML = `
                                                                                                    <div class="p-4" >
                                                                                                                                                        <div class="flex justify-between items-start mb-3">
                                                                                                                                                            <span class="bg-indigo-100 text-indigo-800 text-[10px] font-medium px-2 py-0.5 rounded">Saved</span>
                                                                                                                                                            <button class="delete-proposal text-gray-400 hover:text-red-500 transition-colors" data-id="${p.id}">
                                                                                                                                                                <i class="fas fa-trash text-xs"></i>
                                                                                                                                                            </button>
                                                                                                                                                        </div>
                                                                                                                                                        <h3 class="text-sm font-bold text-gray-800 mb-1 truncate" title="${p.title}">${p.title}</h3>
                                                                                                                                                        <div class="space-y-1 mb-3">
                                                                                                                                                            <p class="text-xs text-gray-600 flex items-center">
                                                                                                                                                                <i class="fas fa-user-tie w-4 text-indigo-500"></i>
                                                                                                                                                                ${p.client ? p.client.contact_person : 'Unknown Client'}
                                                                                                                                                            </p>
                                                                                                                                                            <p class="text-xs text-gray-600 flex items-center">
                                                                                                                                                                <i class="fas fa-building w-4 text-indigo-500"></i>
                                                                                                                                                                 ${p.client ? p.client.company_name : 'Unknown Company'}
                                                                                                                                                            </p>
                                                                                                                                                            <p class="text-xs text-gray-500 flex items-center">
                                                                                                                                                                <i class="fas fa-clock w-4 text-gray-400"></i>
                                                                                                                                                                ${date}
                                                                                                                                                            </p>
                                                                                                                                                        </div>
                                                                                                                                                        <button class="open-saved-proposal w-full bg-indigo-600 text-white py-1.5 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-colors flex items-center justify-center">
                                                                                                                                                            <i class="fas fa-edit mr-1"></i> Continue Editing
                                                                                                                                                        </button>
                                                                                                                                                    </div >
                                                                                                    `;

                        card.querySelector('.open-saved-proposal').onclick = () => loadSavedProposal(p);
                        card.querySelector('.delete-proposal').onclick = (e) => deleteSavedProposal(e, p.id);

                        grid.appendChild(card);
                    });
                }

                function loadSavedProposal(proposal) {
                    proposalContent.innerHTML = proposal.content;
                    currentProposal = {
                        id: proposal.id,
                        template: { key: proposal.settings?.key || 'custom', name: proposal.title },
                        client: {
                            name: proposal.client ? proposal.client.contact_person : '',
                            company: proposal.client ? proposal.client.company_name : ''
                        },
                        content: proposal.content,
                        lastSaved: new Date(proposal.updated_at)
                    };

                    // Update toolbar
                    document.getElementById('editClientName').value = currentProposal.client.name;
                    document.getElementById('editClientCompany').value = currentProposal.client.company;

                    // Show editor
                    document.getElementById('proposalCardsView').classList.add('hidden');
                    document.getElementById('savedProposalsSection').classList.add('hidden');
                    fullEditorView.classList.remove('hidden');
                    
                    // Show formatting toolbar
                    showFormattingToolbar();
                }

                function deleteSavedProposal(e, id) {
                    e.stopPropagation();
                    if (!confirm('Are you sure you want to delete this proposal?')) return;

                    fetch(`/proposals/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                }
            </script>



        </div>
    </div>
@endsection