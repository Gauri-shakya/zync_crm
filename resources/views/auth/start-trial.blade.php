<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start 15-Day Free Trial</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .slider-container {
            width: 200%;
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .step {
            width: 50%;
            padding: 0 12px;
        }
        .form-slide {
            overflow: hidden;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-input {
            transition: all 0.2s ease;
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
        }
        .step-indicator {
            transition: all 0.3s ease;
        }

    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl fade-in">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Start Your 15-Day Free Trial</h1>
            <p class="text-gray-500 mb-6">No credit card required • Get started in seconds</p>
            
            <!-- Step Indicator -->
            <div class="flex justify-center items-center space-x-4 mb-8">
                <div class="flex items-center step-indicator" id="step1-indicator">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold border-2 border-indigo-600">1</div>
                    <div class="ml-3 text-sm font-semibold text-gray-800">Company Details</div>
                </div>
                
                <div class="w-20 h-1 bg-gray-300 rounded-full mx-2">
                    <div class="h-full bg-indigo-600 rounded-full transition-all duration-500" id="progress-bar" style="width: 0%"></div>
                </div>
                
                <div class="flex items-center step-indicator" id="step2-indicator">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-semibold border-2 border-gray-300">2</div>
                    <div class="ml-3 text-sm font-medium text-gray-500">Admin Account</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8">
                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('trial.store') }}" id="trialForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-slide">
                        <div class="slider-container" id="slider">
                            {{-- STEP 1: COMPANY DETAILS --}}
                            <div class="step">
                                <div class="mb-8">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Company Information</h3>
                                    <p class="text-gray-500">Tell us about your company to get started</p>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name *</label>
                                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                                               class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                               placeholder="Enter your company name" required id="company_name">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Address *</label>
                                        <textarea name="address" rows="3"
                                                  class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                                  placeholder="Enter company address" required id="address">{{ old('address') }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Company Email *</label>
                                            <input type="email" name="company_email" value="{{ old('company_email') }}"
                                                   class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                                   placeholder="company@example.com" required id="company_email">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                   class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                                   placeholder="+1 (555) 000-0000" required id="phone">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Company Logo</label>
                                            <input type="file" name="logo" accept="image/*"
                                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 text-sm">
                                            <p class="text-xs text-gray-500 mt-2">Upload your brand logo (PNG, JPG)</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">GSTIN (Optional)</label>
                                            <input type="text" name="gstin" value="{{ old('gstin') }}"
                                                   class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                                   placeholder="Enter GSTIN number">
                                            <p class="text-xs text-gray-500 mt-2">Only required if you have a GST number</p>
                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                        onclick="nextStep()"
                                        class="w-full mt-10 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center group">
                                    Continue to Admin Setup
                                    <svg class="w-6 h-6 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- STEP 2: ADMIN DETAILS --}}
                            <div class="step">
                                <div class="mb-8">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Admin Account Setup</h3>
                                    <p class="text-gray-500">Create your administrator credentials</p>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Your Full Name *</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                               class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                               placeholder="Enter your full name" required id="admin_name">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Admin Email *</label>
                                        <input type="email" name="admin_email" value="{{ old('admin_email') }}"
                                               class="w-full border border-gray-300 rounded-xl px-4 py-3.5 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                               placeholder="admin@gmail.com" required id="admin_email">
                                        <p class="text-xs text-gray-500 mt-2">This will be your login email</p>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                                            <div class="relative">
                                                <input type="password" name="password"
                                                       class="w-full border border-gray-300 rounded-xl px-4 py-3.5 pr-12 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                                       placeholder="Create a strong password" required id="password"
                                                       oninput="checkPasswordStrength()">
                                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                                                    <svg id="password-eye" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <svg id="password-eye-off" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <!-- Password Strength Meter -->
                                            <div class="mt-3">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-xs font-medium text-gray-500">Password Strength</span>
                                                    <span id="strength-text" class="text-xs font-bold text-gray-400 uppercase">Too Short</span>
                                                </div>
                                                <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden flex gap-1">
                                                    <div id="strength-bar-1" class="h-full w-1/4 bg-gray-300 transition-colors duration-300"></div>
                                                    <div id="strength-bar-2" class="h-full w-1/4 bg-gray-300 transition-colors duration-300"></div>
                                                    <div id="strength-bar-3" class="h-full w-1/4 bg-gray-300 transition-colors duration-300"></div>
                                                    <div id="strength-bar-4" class="h-full w-1/4 bg-gray-300 transition-colors duration-300"></div>
                                                </div>
                                                <p id="password-hint" class="text-[10px] text-gray-500 mt-1.5 leading-relaxed">
                                                    Use 8+ characters with a mix of letters, numbers & symbols.
                                                </p>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                                            <div class="relative">
                                                <input type="password" name="password_confirmation"
                                                       class="w-full border border-gray-300 rounded-xl px-4 py-3.5 pr-12 form-input focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700"
                                                       placeholder="Re-enter your password" required id="password_confirmation">
                                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                                                    <svg id="password_confirmation-eye" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <svg id="password_confirmation-eye-off" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mt-4">
                                        <div class="flex">
                                            <svg class="h-5 w-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm text-blue-700 font-medium">Your trial includes:</p>
                                                <ul class="text-xs text-blue-600 mt-1 list-disc pl-5">
                                                    <li>Full access to all features</li>
                                                    <li>15 days free, no credit card required</li>
                                                    <li>Support during trial period</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-4 mt-10">
                                    <button type="button"
                                            onclick="prevStep()"
                                            class="w-full sm:w-1/2 border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 py-4 rounded-xl font-bold text-lg transition-all duration-300 flex items-center justify-center group order-2 sm:order-1">
                                        <svg class="w-6 h-6 mr-3 group-hover:-translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Go Back
                                    </button>

                                    <button type="submit"
                                            class="w-full sm:w-1/2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center group order-1 sm:order-2">
                                        Start Free Trial
                                        <svg class="w-6 h-6 ml-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-bold hover:underline ml-1 transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-xs text-gray-500">
                By clicking "Start Free Trial", you agree to our 
                <a href="#" class="text-indigo-600 hover:underline font-medium">Terms of Service</a> and 
                <a href="#" class="text-indigo-600 hover:underline font-medium">Privacy Policy</a>
            </p>
        </div>
    </div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById(inputId + '-eye');
        const eyeOffIcon = document.getElementById(inputId + '-eye-off');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }

    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthText = document.getElementById('strength-text');
        const hintText = document.getElementById('password-hint');
        const bars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3'),
            document.getElementById('strength-bar-4')
        ];

        let strength = 0;
        let hint = "";

        if (password.length >= 8) strength += 1;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;

        // Reset bars
        bars.forEach(bar => {
            bar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500');
            bar.classList.add('bg-gray-300');
        });

        if (password.length === 0) {
            strengthText.textContent = "Too Short";
            strengthText.className = "text-xs font-bold text-gray-400 uppercase";
            hintText.textContent = "Use 8+ characters with a mix of letters, numbers & symbols.";
            hintText.className = "text-[10px] text-gray-500 mt-1.5 leading-relaxed";
            return;
        }

        if (password.length < 8) {
            strengthText.textContent = "Too Short";
            strengthText.className = "text-xs font-bold text-red-500 uppercase";
            bars[0].classList.remove('bg-gray-300');
            bars[0].classList.add('bg-red-500');
            hintText.textContent = "Password must be at least 8 characters long.";
            hintText.className = "text-[10px] text-red-500 mt-1.5 leading-relaxed";
            return;
        }

        switch (strength) {
            case 1:
                strengthText.textContent = "Weak";
                strengthText.className = "text-xs font-bold text-red-500 uppercase";
                bars[0].classList.remove('bg-gray-300');
                bars[0].classList.add('bg-red-500');
                hintText.textContent = "Add numbers or symbols to make it stronger.";
                hintText.className = "text-[10px] text-red-500 mt-1.5 leading-relaxed";
                break;
            case 2:
                strengthText.textContent = "Fair";
                strengthText.className = "text-xs font-bold text-yellow-500 uppercase";
                bars[0].classList.remove('bg-gray-300');
                bars[1].classList.remove('bg-gray-300');
                bars[0].classList.add('bg-yellow-500');
                bars[1].classList.add('bg-yellow-500');
                hintText.textContent = "Good start! Use symbols and mixed case for better security.";
                hintText.className = "text-[10px] text-yellow-600 mt-1.5 leading-relaxed";
                break;
            case 3:
                strengthText.textContent = "Good";
                strengthText.className = "text-xs font-bold text-blue-500 uppercase";
                bars[0].classList.remove('bg-gray-300');
                bars[1].classList.remove('bg-gray-300');
                bars[2].classList.remove('bg-gray-300');
                bars[0].classList.add('bg-blue-500');
                bars[1].classList.add('bg-blue-500');
                bars[2].classList.add('bg-blue-500');
                hintText.textContent = "Strong password! You can make it even better with special characters.";
                hintText.className = "text-[10px] text-blue-600 mt-1.5 leading-relaxed";
                break;
            case 4:
                strengthText.textContent = "Strong";
                strengthText.className = "text-xs font-bold text-green-500 uppercase";
                bars.forEach(bar => {
                    bar.classList.remove('bg-gray-300');
                    bar.classList.add('bg-green-500');
                });
                hintText.textContent = "Perfect! Your password is very secure.";
                hintText.className = "text-[10px] text-green-600 mt-1.5 leading-relaxed";
                break;
        }
    }

    function nextStep() {
        document.getElementById('slider').style.transform = 'translateX(-50%)';
        document.getElementById('step1-indicator').classList.remove('text-gray-800');
        document.getElementById('step1-indicator').classList.add('text-gray-600');
        document.getElementById('step2-indicator').classList.remove('text-gray-500');
        document.getElementById('step2-indicator').classList.add('text-gray-800');
        
        document.querySelector('#step1-indicator .w-10').classList.remove('bg-indigo-600', 'border-indigo-600');
        document.querySelector('#step1-indicator .w-10').classList.add('bg-gray-200', 'border-gray-300');
        
        document.querySelector('#step2-indicator .w-10').classList.remove('bg-gray-200', 'border-gray-300');
        document.querySelector('#step2-indicator .w-10').classList.add('bg-indigo-600', 'border-indigo-600', 'text-white');
        
        document.getElementById('progress-bar').style.width = '100%';
    }

    function prevStep() {
        document.getElementById('slider').style.transform = 'translateX(0%)';
        document.getElementById('step1-indicator').classList.remove('text-gray-600');
        document.getElementById('step1-indicator').classList.add('text-gray-800');
        document.getElementById('step2-indicator').classList.remove('text-gray-800');
        document.getElementById('step2-indicator').classList.add('text-gray-500');
        
        document.querySelector('#step1-indicator .w-10').classList.remove('bg-gray-200', 'border-gray-300');
        document.querySelector('#step1-indicator .w-10').classList.add('bg-indigo-600', 'border-indigo-600', 'text-white');
        
        document.querySelector('#step2-indicator .w-10').classList.remove('bg-indigo-600', 'border-indigo-600', 'text-white');
        document.querySelector('#step2-indicator .w-10').classList.add('bg-gray-200', 'border-gray-300');
        
        document.getElementById('progress-bar').style.width = '0%';
    }

    // Form validation
    document.getElementById('trialForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long.');
            document.getElementById('password').focus();
            return;
        }
        
        if (password !== passwordConfirmation) {
            e.preventDefault();
            alert('Passwords do not match.');
            document.getElementById('password_confirmation').focus();
            return;
        }

        let strength = 0;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;

        if (strength < 2) {
            if (!confirm('Your password is weak. We recommend using a stronger password with numbers and symbols. Do you want to continue anyway?')) {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        }
    });
</script>

</body>
</html>