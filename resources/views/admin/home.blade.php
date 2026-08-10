<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZynCRM CRM - Transform Your Customer Relationships</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e40af',
                        accent: '#10b981',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        jakarta: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
        }

        /*---------------------------------------------------Features Section CSS --------------------------------------*/

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .illustration-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom pastel colors */
        .bg-pastel-purple {
            background-color: #E8E4F3;
        }

        .bg-pastel-pink {
            background-color: #FFE5EC;
        }

        .bg-pastel-yellow {
            background-color: #FFF8DC;
        }

        .bg-pastel-green {
            background-color: #E8F5E9;
        }

        .bg-pastel-blue {
            background-color: #E3F2FD;
        }

        .bg-pastel-peach {
            background-color: #FFE8D6;
        }

        .icon-bounce {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        @keyframes bounce-subtle {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* Trusted By Logos Loop */
        .logos-row {
            animation: slide-loop 40s linear infinite;
            width: max-content;
        }

        .logos-row:hover {
            animation-play-state: paused;
        }

        @keyframes slide-loop {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-33.33%);
            }
        }

        .logos-container::before,
        .logos-container::after {
            content: "";
            position: absolute;
            top: 0;
            width: 150px;
            height: 100%;
            z-index: 2;
        }

        .logos-container::before {
            left: 0;
            background: linear-gradient(to right, white, transparent);
        }

        .logos-container::after {
            right: 0;
            background: linear-gradient(to left, white, transparent);
        }



        /*-------------------------------------------------------------------------------------------------------------*/

        /* Custom Styles */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: scale(1.03);
            transition: all 0.3s ease;
        }

        .testimonial-shadow {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .dashboard-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .floating {
            animation: floating 8s ease-in-out infinite;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }

        .animate-gradient {
            background-size: 300% 300%;
            animation: gradient-shift 8s ease infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0);
        }

        /* Owl Carousel Custom */
        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            background: white !important;
            color: #4f46e5 !important;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease !important;
            border: 1px solid #f3f4f6 !important;
            font-size: 18px !important;
        }

        .owl-carousel .owl-nav button.owl-prev:hover,
        .owl-carousel .owl-nav button.owl-next:hover {
            background: #4f46e5 !important;
            color: white !important;
            box-shadow: 0 15px 30px rgba(79, 70, 229, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .owl-carousel .owl-nav button.owl-prev {
            left: -25px;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: -25px;
        }

        @media (max-width: 768px) {
            .owl-carousel .owl-nav {
                display: none;
            }
        }

        .owl-carousel .owl-dots {
            margin-top: 40px;
            text-align: center;
        }

        .owl-carousel .owl-dot span {
            background: #cbd5e1 !important;
            width: 10px;
            height: 10px;
            margin: 0 6px;
            transition: all 0.3s ease;
            border-radius: 20px;
        }

        .owl-carousel .owl-dot.active span {
            background: #4f46e5 !important;
            width: 30px;
        }

        /* Navigation Styles */
        .nav-highlight {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            border-radius: 3px 3px 0 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }

        .nav-item:hover .nav-highlight {
            width: 80%;
        }

        .nav-item.active .nav-highlight {
            width: 80%;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Counter animation */
        @keyframes countUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .counter-animate {
            animation: countUp 0.5s ease-out forwards;
        }

        /* Custom Scrollbar for Modal */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="font-sans bg-gray-50 overflow-x-hidden">

    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-gray-100">
        @if(session('error'))
            <div class="bg-red-500 text-white text-center py-2 px-4 text-sm font-bold animate-pulse">
                {{ session('error') }}
            </div>
        @endif
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-0">
                <!-- Logo -->
                <div class="flex items-center space-x-3 group cursor-pointer">
                    <div class="relative">
                        <div
                            class="w-[9rem] h-20 bg-white flex items-center justify-center  transition-all duration-500 overflow-hidden">
                            <img src="{{asset ('assets/logo.png')}}" alt="ZynCRM Logo"
                                class="w-full h-12 object-contain">
                        </div>
                    </div>
                    <!--<div>-->
                    <!--    <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">-->
                    <!--        ZynCRM CRM-->
                    <!--    </h1>-->
                    <!--    <p class="text-xs text-gray-500 -mt-1 font-medium">-->
                    <!--        Community-Driven Platform-->
                    <!--    </p>-->
                    <!--</div>-->
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="#features"
                        class="nav-item group relative px-5 py-3 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300">
                        <span class="relative z-10">Features</span>
                        <div class="nav-highlight"></div>
                    </a>
                    <a href="#dashboard"
                        class="nav-item group relative px-5 py-3 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300">
                        <span class="relative z-10">Dashboard</span>
                        <div class="nav-highlight"></div>
                    </a>
                    <a href="#mobile"
                        class="nav-item group relative px-5 py-3 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300">
                        <span class="relative z-10">Mobile</span>
                        <div class="nav-highlight"></div>
                    </a>
                    <a href="#pricing"
                        class="nav-item group relative px-5 py-3 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300">
                        <span class="relative z-10">Pricing</span>
                        <div class="nav-highlight"></div>
                    </a>
                    <a href="#testimonials"
                        class="nav-item group relative px-5 py-3 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300">
                        <span class="relative z-10">Testimonials</span>
                        <div class="nav-highlight"></div>
                    </a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="{{route('login.show')}}"
                        class="relative px-5 py-2.5 text-gray-700 font-medium group overflow-hidden rounded-lg transition-all duration-300 hover:text-blue-600">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </span>
                        <div
                            class="absolute inset-0 bg-gray-100 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                        </div>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center space-x-3">
                    <a href="{{route('login.show')}}"
                        class="text-gray-600 hover:text-blue-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                    <button id="menu-toggle"
                        class="menu-toggle-btn w-12 h-12 rounded-xl bg-gradient-to-r from-blue-50 to-purple-50 flex flex-col items-center justify-center space-y-1.5 group focus:outline-none transition-all duration-300 hover:shadow-lg">
                        <span
                            class="menu-line w-6 h-0.5 bg-gray-700 group-hover:bg-blue-600 transition-all duration-300"></span>
                        <span
                            class="menu-line w-6 h-0.5 bg-gray-700 group-hover:bg-purple-600 transition-all duration-300"></span>
                        <span
                            class="menu-line w-6 h-0.5 bg-gray-700 group-hover:bg-pink-600 transition-all duration-300"></span>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu"
                class="lg:hidden hidden absolute left-0 right-0 top-full bg-white/98 backdrop-blur-lg border-t border-gray-100 shadow-2xl transform origin-top transition-all duration-300 scale-y-0 opacity-0">
                <div class="container mx-auto px-4 py-6 bg-white">
                    <div class="space-y-1">
                        <a href="#features"
                            class="mobile-nav-item group flex items-center px-4 py-4 text-gray-700 hover:text-blue-600 rounded-xl hover:bg-gradient-to-r from-blue-50 to-white transition-all duration-300 transform hover:translate-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-star text-yellow-500"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-lg">Features</span>
                                <p class="text-xs text-gray-500">Explore our platform</p>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                        </a>

                        <a href="#dashboard"
                            class="mobile-nav-item group flex items-center px-4 py-4 text-gray-700 hover:text-green-600 rounded-xl hover:bg-gradient-to-r from-green-50 to-white transition-all duration-300 transform hover:translate-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-50 to-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-chart-line text-green-500"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-lg">Dashboard</span>
                                <p class="text-xs text-gray-500">View analytics</p>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-400 group-hover:text-green-500 transition-colors"></i>
                        </a>

                        <a href="#mobile"
                            class="mobile-nav-item group flex items-center px-4 py-4 text-gray-700 hover:text-purple-600 rounded-xl hover:bg-gradient-to-r from-purple-50 to-white transition-all duration-300 transform hover:translate-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-mobile-alt text-purple-500"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-lg">Mobile App</span>
                                <p class="text-xs text-gray-500">On-the-go access</p>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-400 group-hover:text-purple-500 transition-colors"></i>
                        </a>

                        <a href="#pricing"
                            class="mobile-nav-item group flex items-center px-4 py-4 text-gray-700 hover:text-orange-600 rounded-xl hover:bg-gradient-to-r from-orange-50 to-white transition-all duration-300 transform hover:translate-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-tag text-orange-500"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-lg">Pricing</span>
                                <p class="text-xs text-gray-500">Choose your plan</p>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                        </a>

                        <a href="#testimonials"
                            class="mobile-nav-item group flex items-center px-4 py-4 text-gray-700 hover:text-pink-600 rounded-xl hover:bg-gradient-to-r from-pink-50 to-white transition-all duration-300 transform hover:translate-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-comments text-pink-500"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-lg">Testimonials</span>
                                <p class="text-xs text-gray-500">Client success stories</p>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-400 group-hover:text-pink-500 transition-colors"></i>
                        </a>

                        <a href="{{route('login.show')}}"
                            class="mobile-nav-item group flex items-center px-4 py-4 text-gray-700 hover:text-blue-600 rounded-xl hover:bg-gradient-to-r from-blue-50 to-white transition-all duration-300 transform hover:translate-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-sign-in-alt text-blue-500"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-lg">Login</span>
                                <p class="text-xs text-gray-500">Access your account</p>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                        </a>
                    </div>

                    <!-- Mobile CTA -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="/start-trial"
                            class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 text-center start-now-btn">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-rocket mr-3"></i>
                                <span>Start Now</span>
                                <i class="fas fa-arrow-right ml-3"></i>
                            </div>
                        </a>

                        <!-- Social Links -->
                        <div class="mt-8">
                            <p class="text-sm text-gray-500 mb-4 text-center">Follow ZynCRM</p>
                            <div class="flex justify-center space-x-4">
                                <a href="#"
                                    class="social-icon w-10 h-10 bg-blue-100 hover:bg-blue-500 text-blue-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#"
                                    class="social-icon w-10 h-10 bg-purple-100 hover:bg-purple-500 text-purple-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#"
                                    class="social-icon w-10 h-10 bg-pink-100 hover:bg-pink-500 text-pink-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#"
                                    class="social-icon w-10 h-10 bg-red-100 hover:bg-red-500 text-red-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-[#edf5ff] py-20 px-2 md:px-10 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <!-- Text Content -->
                <div class="lg:w-1/2 mb-12 lg:mb-0 lg:pr-10">
                    <div class="mb-4">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">All-In-One
                            CRM Solution</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900 leading-tight">Empower Your Business
                        with ZynCRM CRM</h1>
                    <p class="text-xl mb-8 text-gray-600 leading-relaxed">Streamline your sales, HR, project management,
                        and customer support in one unified platform. Designed for growth-focused companies.</p>

                    <div class="mb-8 flex flex-wrap gap-3">
                        <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-sm font-medium">Automated HR & Payroll</span>
                        </div>
                        <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-sm font-medium">Lead & Sales Automation</span>
                        </div>
                        <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-sm font-medium">Seamless Project Management</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="/start-trial"
                            class="start-now-btn bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-bold text-center transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <span>Start Now</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-lg font-bold text-center transition duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Watch Demo
                        </a>
                    </div>

                    <div class="mt-8 flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Join Our CRM Now — Start Managing Smarter
                    </div>
                </div>

                <!-- Laptop and Phone Mockup -->
                <div class="lg:w-1/2 relative mt-12 lg:mt-0">
                    <div class="relative mx-auto w-full max-w-lg lg:max-w-none">
                        <!-- Laptop Mockup -->
                        <div class="relative z-10 animate-fade-in-up">
                            <!-- Screen -->
                            <div
                                class="relative rounded-t-2xl border-x-[8px] border-t-[8px] border-gray-900 bg-gray-900 shadow-2xl overflow-hidden aspect-[16/10]">
                                <img src="{{ asset('assets/view.png') }}" class="w-full h-full object-fill"
                                    alt="Laptop View">
                                <!-- Reflection overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-white/10 to-transparent pointer-events-none">
                                </div>
                            </div>
                            <!-- Base -->
                            <div
                                class="relative h-[12px] w-full md:w-[106%] md:-ml-[3%] rounded-b-xl bg-gradient-to-b from-gray-800 to-gray-900 shadow-xl">
                                <div
                                    class="absolute left-1/2 top-0 h-[3px] w-16 -translate-x-1/2 rounded-b-full bg-gray-700">
                                </div>
                            </div>
                        </div>

                        <!-- Phone Mockup -->
                        <div
                            class="absolute -bottom-10 right-0 md:-right-8 z-20 w-36 md:w-48 animate-float shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div
                                class="relative rounded-[1.5rem] border-[6px] border-gray-900 bg-gray-900 shadow-2xl overflow-hidden aspect-[9/19.5]">
                                <!-- Notch/Dynamic Island area -->
                                <div
                                    class="absolute top-0 left-1/2 -translate-x-1/2 w-1/3 h-2 bg-gray-900 rounded-b-2xl z-30">
                                </div>
                                <img src="{{ asset('assets/C4.jpeg') }}" class="w-full h-full object-fill"
                                    alt="Phone View">
                            </div>
                        </div>

                        <!-- Decorative background glow -->
                        <div
                            class="absolute inset-0 z-0 bg-gradient-to-tr from-blue-500/20 to-purple-500/20 blur-[80px] rounded-full animate-pulse">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By Section -->
    <section class="bg-white pt-8">
        <div class="container mx-auto px-4">
            <p class="text-center text-gray-500 mb-8">Trusted by 10,000+ companies worldwide</p>
            <div class="logos-container relative overflow-hidden">
                <div class="logos-row flex items-center gap-16 opacity-60 whitespace-nowrap will-change-transform">
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-microsoft text-3xl text-gray-700"></i>
                    </div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-google text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-amazon text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-slack text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-spotify text-3xl text-gray-700"></i></div>
                    <!-- Duplicate for infinite loop -->
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-microsoft text-3xl text-gray-700"></i>
                    </div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-google text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-amazon text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-slack text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-spotify text-3xl text-gray-700"></i></div>
                    <!-- Second duplicate for wider screens -->
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-microsoft text-3xl text-gray-700"></i>
                    </div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-google text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-amazon text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-slack text-3xl text-gray-700"></i></div>
                    <div class="h-10 flex items-center mx-6"><i class="fab fa-spotify text-3xl text-gray-700"></i></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section id="features" class="py-20 bg-white relative overflow-hidden font-jakarta">
        <div class="container mx-auto px-4 relative z-10">
            <!-- Header -->
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight">
                    Everything You Need to <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Grow Your
                        Business</span>
                </h2>
                <p class="text-lg text-gray-600 font-medium leading-relaxed">
                    Our comprehensive CRM solution streamlines your workflow, enhances customer relationships, and
                    drives revenue growth
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">

                <!-- Card 1: Lead & Sales Hub -->
                <div class="bg-[#f3f0ff] rounded-[2.5rem] p-8 feature-card border border-purple-100/50">
                    <div class="w-14 h-14 bg-purple-200 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <i class="fas fa-bullseye text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">Lead & Sales Hub</h3>
                    <p class="text-gray-600 mb-6 font-medium leading-relaxed">Convert prospects into customers with a
                        powerful sales pipeline and automated proposal generation.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-purple-500"></i> Visual Sales Pipeline
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-purple-500"></i> Besdex Lead Integration
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-purple-500"></i> Professional Proposals
                        </li>
                    </ul>
                </div>

                <!-- Card 2: HR & Workforce -->
                <div class="bg-[#e0f2fe] rounded-[2.5rem] p-8 feature-card border border-blue-100/50">
                    <div class="w-14 h-14 bg-blue-200 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <i class="fas fa-users-cog text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">HR & Workforce</h3>
                    <p class="text-gray-600 mb-6 font-medium leading-relaxed">Automate your HR operations from
                        attendance tracking to automated salary slip generation.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-blue-500"></i> Attendance & Leaves
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-blue-500"></i> Automated Payroll
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-blue-500"></i> Employee Self-Portal
                        </li>
                    </ul>
                </div>

                <!-- Card 3: Finance & Invoicing -->
                <div class="bg-[#f0fdf4] rounded-[2.5rem] p-8 feature-card border border-green-100/50">
                    <div class="w-14 h-14 bg-green-200 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <i class="fas fa-file-invoice-dollar text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">Finance & Invoicing</h3>
                    <p class="text-gray-600 mb-6 font-medium leading-relaxed">Streamline your billing process with
                        automated invoices and real-time payment tracking.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-green-500"></i> Smart Invoicing
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-green-500"></i> Payment Tracking
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-green-500"></i> Revenue Analytics
                        </li>
                    </ul>
                </div>

                <!-- Card 4: Project Management -->
                <div class="bg-[#fff7ed] rounded-[2.5rem] p-8 feature-card border border-orange-100/50">
                    <div class="w-14 h-14 bg-orange-200 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <i class="fas fa-tasks text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">Project Execution</h3>
                    <p class="text-gray-600 mb-6 font-medium leading-relaxed">Stay on top of every project with
                        collaborative task management and real-time tracking.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-orange-500"></i> Task Management
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-orange-500"></i> Milestone Tracking
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-orange-500"></i> Collaborative Notes
                        </li>
                    </ul>
                </div>

                <!-- Card 5: Support & Communication -->
                <div class="bg-[#fff1f2] rounded-[2.5rem] p-8 feature-card border border-pink-100/50">
                    <div class="w-14 h-14 bg-pink-200 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <i class="fas fa-headset text-2xl text-pink-600"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">Support Desk</h3>
                    <p class="text-gray-600 mb-6 font-medium leading-relaxed">Deliver exceptional service with a
                        dedicated ticketing system and real-time chat.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-pink-500"></i> Ticket Management
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-pink-500"></i> Real-time Chat
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-pink-500"></i> Client History
                        </li>
                    </ul>
                </div>

                <!-- Card 6: Insights & Reporting -->
                <div class="bg-[#f5f3ff] rounded-[2.5rem] p-8 feature-card border border-indigo-100/50">
                    <div class="w-14 h-14 bg-indigo-200 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <i class="fas fa-chart-pie text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 tracking-tight">Advanced Analytics</h3>
                    <p class="text-gray-600 mb-6 font-medium leading-relaxed">Gain actionable insights with
                        comprehensive reports on every aspect of your business.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-indigo-500"></i> Sales Performance
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-indigo-500"></i> Revenue Tracking
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-indigo-500"></i> HR Insights
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature Summary Section -->
            <div class="mt-6 pt-16 border-t border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center group cursor-default">
                        <div
                            class="text-3xl font-black text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors tracking-tight">
                            100+</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Global Integrations</div>
                    </div>
                    <div class="text-center group cursor-default">
                        <div
                            class="text-3xl font-black text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors tracking-tight">
                            24/7</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Expert Support</div>
                    </div>
                    <div class="text-center group cursor-default">
                        <div
                            class="text-3xl font-black text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors tracking-tight">
                            99.9%</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">System Uptime</div>
                    </div>
                    <div class="text-center group cursor-default">
                        <div
                            class="text-3xl font-black text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors tracking-tight">
                            Bank-Level</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Data Security</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section id="dashboard" class="py-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto ">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-5 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium mb-6">DASHBOARD
                    PREVIEW</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Experience the Power of <span
                        class="text-blue-600">ZynCRM CRM</span></h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">See how our intuitive dashboard transforms customer
                    relationship management for modern businesses</p>
            </div>

            <!-- Tablet View Image Container -->
            <div class="mb-16">
                <div class="max-w-6xl mx-auto px-4">
                    <!-- Tablet Frame -->
                    <div
                        class="relative bg-gray-900 rounded-[32px] p-4 md:p-6 shadow-2xl border-4 border-gray-800 mx-auto w-full">
                        <!-- Tablet Top Bar -->
                        <div
                            class="absolute top-2 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gray-700 rounded-full">
                        </div>

                        <!-- Tablet Camera -->
                        <div
                            class="absolute top-3 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-600 rounded-full">
                        </div>

                        <!-- Tablet Screen -->
                        <div class="bg-white rounded-[16px] overflow-hidden border border-gray-800">
                            <!-- Browser Header -->
                            <div class="px-4 md:px-6 py-3 bg-gray-800 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex space-x-1">
                                        <div class="w-1.5 h-1.5 rounded-full bg-red-400"></div>
                                        <div class="w-1.5 h-1.5 rounded-full bg-yellow-400"></div>
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-gray-700 px-3 py-1 rounded text-center max-w-xs mx-auto">
                                            <span class="text-gray-300 text-sm truncate">ZynCRM CRM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-gray-400">
                                    <i class="fas fa-wifi"></i>
                                </div>
                            </div>

                            <!-- Dashboard Image -->
                            <div class="relative w-full overflow-hidden bg-gray-100">
                                <img src="{{ asset('assets/view.png') }}" alt="ZynCRM CRM Dashboard - Tablet View"
                                    class="w-full h-auto object-contain" loading="lazy" />
                            </div>

                            <!-- Tablet Bottom Controls -->
                            <div class="px-4 md:px-6 py-2 bg-gray-800 border-t border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                            <i class="fas fa-home text-gray-400 text-xs"></i>
                                        </div>
                                        <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                            <i class="fas fa-search text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-400">10:24 AM</span>
                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tablet Home Button -->
                        <div
                            class="absolute bottom-2 left-1/2 transform -translate-x-1/2 w-10 h-10 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center">
                            <div class="w-5 h-5 rounded-full border border-gray-600"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits Cards Grid -->
            <div class=" mx-auto bg-[#edf5ff]">
                <div class="max-w-6xl mx-auto px-4 py-12">

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-12">
                        Why Businesses Choose
                        <span class="text-blue-600">Our Platform</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div
                            class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-300 hover:-translate-y-1">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-rocket text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 text-center mb-4">Boost Productivity</h4>
                            <p class="text-gray-600 text-center text-sm leading-relaxed mb-4">
                                Automate repetitive HR and sales tasks to focus on growing your business and closing
                                more deals.
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center text-blue-600">
                                    <i class="fas fa-check-circle text-xs mr-2"></i>
                                    <span class="text-sm">Automated Invoicing</span>
                                </div>
                                <div class="flex items-center text-blue-600">
                                    <i class="fas fa-check-circle text-xs mr-2"></i>
                                    <span class="text-sm">Smart Attendance</span>
                                </div>
                                <div class="flex items-center text-blue-600">
                                    <i class="fas fa-check-circle text-xs mr-2"></i>
                                    <span class="text-sm">Lead Scoring</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div
                            class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-300 hover:-translate-y-1">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 text-center mb-4">Secure & Reliable</h4>
                            <p class="text-gray-600 text-center text-sm leading-relaxed mb-4">
                                Bank-level security and 99.9% uptime ensure your business data is always safe and
                                accessible.
                            </p>
                            <div class="relative pt-4">
                                <div class="text-center mb-2">
                                    <span class="text-2xl font-bold text-purple-600">99.9%</span>
                                    <span class="text-gray-600 ml-2 text-sm">Uptime Guarantee</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-1.5 rounded-full"
                                        style="width: 99%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div
                            class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-300 hover:-translate-y-1">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 text-center mb-4">Scalable Growth</h4>
                            <p class="text-gray-600 text-center text-sm leading-relaxed mb-4">
                                Powerful analytics and modular design that scales with your business needs and team
                                size.
                            </p>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <i class="fas fa-user-check text-green-500 text-sm mb-1"></i>
                                    <p class="text-xs text-gray-700">Team Insights</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <i class="fas fa-bullseye text-blue-500 text-sm mb-1"></i>
                                    <p class="text-xs text-gray-700">Sales Targets</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <i class="fas fa-chart-bar text-purple-500 text-sm mb-1"></i>
                                    <p class="text-xs text-gray-700">Revenue</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <i class="fas fa-handshake text-orange-500 text-sm mb-1"></i>
                                    <p class="text-xs text-gray-700">Retention</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Mobile App Section -->
    <section id="mobile" class="pb-16 px-2 md:px-24 bg-white ">
        <div class="container mx-auto px-4">
            <div class="text-center ">
                <span
                    class="inline-block px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-full text-sm font-medium mb-4 shadow-sm">
                    <i class="fas fa-mobile-alt mr-2"></i>
                    MOBILE APP
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Your Complete CRM
                    <span class="text-purple-600">On The Go</span>
                </h2>
                <p class="text-base text-gray-600 max-w-2xl mx-auto mb-24">
                    Access your leads, manage attendance, and track projects from any device, anywhere with our
                    dedicated mobile application.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Mobile Devices Showcase -->
                <div class="lg:w-1/2">
                    <!-- Replace this div with your image -->
                    <img src="{{ asset('assets/C3.png') }}" alt="Mobile App Dashboard Preview"
                        class="w-1/2 max-w-md mx-auto rounded-3xl ">
                </div>

                <!-- Features Section -->
                <div class="lg:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">
                        Complete Dashboard
                        <span class="text-purple-600">Everywhere You Go</span>
                    </h3>

                    <!-- Compact Features Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <!-- Feature 1 -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800 mb-2">Real-time Analytics</h4>
                            <p class="text-xs text-gray-600">Track performance metrics instantly from anywhere</p>
                        </div>

                        <!-- Feature 2 -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-users text-purple-600"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800 mb-2">Client Management</h4>
                            <p class="text-xs text-gray-600">Manage all client relationships on the go</p>
                        </div>

                        <!-- Feature 3 -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-bullhorn text-green-600"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800 mb-2">Campaign Control</h4>
                            <p class="text-xs text-gray-600">Launch and monitor campaigns anywhere</p>
                        </div>

                        <!-- Feature 4 -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-bell text-yellow-600"></i>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800 mb-2">Instant Notifications</h4>
                            <p class="text-xs text-gray-600">Get alerts for important updates</p>
                        </div>
                    </div>

                    <!-- Mobile Benefits -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Full Dashboard Experience</p>
                                <p class="text-xs text-gray-600">All features available on mobile</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sync-alt text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Real-time Sync</p>
                                <p class="text-xs text-gray-600">Data updates instantly across devices</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Secure Access</p>
                                <p class="text-xs text-gray-600">Bank-level security on all devices</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('app.download') }}" id="download-app-btn"
                            class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white py-3 rounded-lg font-medium text-center transition-all flex items-center justify-center">
                            <i class="fas fa-mobile-alt mr-2"></i>
                            Download App
                        </a>
                        <a href="#"
                            class="flex-1 border border-purple-600 text-purple-600 hover:bg-purple-50 py-3 rounded-lg font-medium text-center transition-colors flex items-center justify-center">
                            <i class="fas fa-play-circle mr-2"></i>
                            Watch Demo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-[#fbeedc]">
        <div class="container mx-auto px-4 flex flex-col justify-center items-center text-center">
            <!-- Title and Description -->
            <div class="max-w-2xl mx-auto my-12 font-jakarta">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight tracking-tight">
                    Grow with Your <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600">CRM
                        Dashboard</span>
                </h2>
                <p class="text-gray-600 text-base md:text-lg font-medium leading-relaxed">
                    Experience exponential growth with a suite of tools designed to optimize your workflow, reduce
                    costs, and accelerate your business implementation.
                </p>
            </div>

            <div class="flex items-end justify-center -space-x-2 md:-space-x-6 font-jakarta overflow-x-hidden">
                <!-- Card 1 -->
                <div
                    class="relative bg-[#d2c5ff] h-[200px] md:h-[250px] w-[110px] md:w-[250px] rounded-t-[150px] flex flex-col justify-center items-center text-center px-4 z-10 shadow-lg">
                    <h3 class="text-2xl md:text-4xl font-bold text-gray-900 tracking-tight"><span class="counter"
                            data-target="27">0</span>%</h3>
                    <p class="text-sm md:text-lg mt-1 font-semibold text-gray-800">Increased productivity</p>
                    <p class="text-[10px] md:text-sm text-gray-700 mt-1">Do more in less time</p>
                    <svg width="30" md:width="45" fill="#8b75ff" viewBox="0 0 24 24" class="mt-4">
                        <path d="M13 5v6h6v2h-8V5h2zm-2 14v-6H5v-2h8v8h-2z" />
                    </svg>
                </div>

                <!-- Card 2 -->
                <div
                    class="relative bg-[#b7ecff] h-[280px] md:h-[350px] w-[110px] md:w-[250px] rounded-t-[150px] flex flex-col justify-center items-center text-center px-4 z-10 shadow-lg">
                    <h3 class="text-2xl md:text-4xl font-bold text-gray-900 tracking-tight"><span class="counter"
                            data-target="50">0</span>%</h3>
                    <p class="text-sm md:text-lg mt-1 font-semibold text-gray-800">Faster implementation</p>
                    <p class="text-[10px] md:text-sm text-gray-700 mt-1">Get started in no time</p>
                    <svg width="40" md:width="55" fill="#88d1df" viewBox="0 0 24 24" class="mt-4">
                        <path d="M12 2L1 21h22L12 2zm0 5l7 12H5l7-12z" />
                    </svg>
                </div>

                <!-- Card 3 -->
                <div
                    class="relative bg-[#ffcaa6] h-[360px] md:h-[450px] w-[110px] md:w-[250px] rounded-t-[150px] flex flex-col justify-start items-center text-center px-4 pt-8 md:pt-16 z-30 shadow-lg">
                    <h3 class="text-2xl md:text-4xl font-bold text-gray-900 tracking-tight"><span class="counter"
                            data-target="71">0</span>%</h3>
                    <p class="text-sm md:text-lg mt-1 font-semibold text-gray-800">Saved on licensing fees</p>
                    <p class="text-[10px] md:text-sm text-gray-700 mt-1">Big savings for a lifetime</p>
                    <svg width="24" height="24" fill="white" viewBox="0 0 24 24" class="mt-4">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    <img src="{{ asset('assets/crm25-removebg-preview.png') }}" alt="CRM Dashboard"
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[5rem] md:w-[12.5rem] sm:w-[10rem]" />

                </div>
            </div>
        </div>
    </section>



    <!-- Dashboard Insights Section -->
    <section id="insights" class="py-20 md:py-8 bg-white relative overflow-hidden">
        <!-- Modern Mesh Gradients -->
        <div
            class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-blue-50 rounded-full blur-[100px] opacity-50 -translate-y-1/2 translate-x-1/4">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-indigo-50 rounded-full blur-[80px] opacity-40 translate-y-1/4 -translate-x-1/4">
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 mb-5 group cursor-default">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 mr-2 animate-pulse"></span>
                    <span class="text-indigo-600 text-[10px] font-bold tracking-widest uppercase">Dashboard
                        Insights</span>
                </div>
                <h2
                    class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-5 leading-[1.1] tracking-tight">
                    Your Complete <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-600 bg-300% animate-gradient">CRM
                        Dashboard</span>
                </h2>
                <p class="text-base md:text-lg text-gray-600 max-w-xl mx-auto leading-relaxed font-medium">
                    Track sales performance, manage client relationships, and automate HR operations from a single,
                    intuitive dashboard.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12 xl:gap-20 px-8">
                <!-- CRM Dashboard Visual with Glassmorphism -->
                <div class="lg:w-1/2 relative px-8">
                    <div class="relative group ">
                        <!-- Decorative backglow -->
                        <div
                            class=" absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-[2rem] opacity-10 blur-2xl group-hover:opacity-20 transition duration-1000">
                        </div>

                        <!-- Dashboard Mockup -->
                        <div
                            class=" relative bg-white rounded-xl shadow-[0_15px_40px_rgba(0,0,0,0.08)] overflow-hidden border border-gray-100 transform group-hover:translate-y-[-3px] transition-all duration-700 ease-out">
                            <!-- Browser Chrome -->
                            <div class="bg-gray-900 px-5 py-3 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="flex space-x-1.5">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#FF5F56]"></div>
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#FFBD2E]"></div>
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#27C93F]"></div>
                                    </div>
                                    <div class="h-4 w-px bg-gray-700 mx-1"></div>
                                    <span
                                        class="text-gray-500 text-[10px] font-medium tracking-wide">zyncrm.in/dashboard</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-500/20 flex items-center justify-center">
                                        <i class="fas fa-user text-indigo-400 text-[8px]"></i>
                                    </div>
                                    <span class="text-gray-400 text-[10px] font-semibold">Admin</span>
                                </div>
                            </div>

                            <!-- Dashboard Content Mockup -->
                            <div class="p-6 bg-gray-50/30">
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="text-base font-bold text-gray-900">Dashboard Overview</h4>
                                        <span
                                            class="text-[9px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded uppercase tracking-wider">Live</span>
                                    </div>
                                    <p class="text-gray-500 text-[10px]">Real-time performance metrics</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Metric Card 1 -->
                                    <div
                                        class="bg-white p-4 rounded-xl shadow-sm border border-gray-100/50 group/card transition-all duration-300">
                                        <div class="flex justify-between items-start mb-3">
                                            <div
                                                class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 group-hover/card:scale-105 transition-transform">
                                                <i class="fas fa-wallet text-xs"></i>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-green-600 flex items-center bg-green-50 px-1.5 py-0.5 rounded-full">
                                                <i class="fas fa-caret-up mr-0.5"></i> 12.5%
                                            </span>
                                        </div>
                                        <p class="text-gray-500 text-[9px] font-bold uppercase tracking-widest mb-0.5">
                                            Revenue</p>
                                        <p class="text-lg font-extrabold text-gray-900">₹41,000</p>
                                    </div>

                                    <!-- Metric Card 2 -->
                                    <div
                                        class="bg-white p-4 rounded-xl shadow-sm border border-gray-100/50 group/card transition-all duration-300">
                                        <div class="flex justify-between items-start mb-3">
                                            <div
                                                class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 group-hover/card:scale-105 transition-transform">
                                                <i class="fas fa-users text-xs"></i>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-green-600 flex items-center bg-green-50 px-1.5 py-0.5 rounded-full">
                                                <i class="fas fa-caret-up mr-0.5"></i> 8.2%
                                            </span>
                                        </div>
                                        <p class="text-gray-500 text-[9px] font-bold uppercase tracking-widest mb-0.5">
                                            Clients</p>
                                        <p class="text-lg font-extrabold text-gray-900">248</p>
                                    </div>

                                    <!-- Metric Card 3 -->
                                    <div
                                        class="bg-white p-4 rounded-xl shadow-sm border border-gray-100/50 group/card transition-all duration-300">
                                        <div class="flex justify-between items-start mb-3">
                                            <div
                                                class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 group-hover/card:scale-105 transition-transform">
                                                <i class="fas fa-bullhorn text-xs"></i>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-indigo-600 flex items-center bg-indigo-50 px-1.5 py-0.5 rounded-full">
                                                <i class="fas fa-caret-up mr-0.5"></i> 15.3%
                                            </span>
                                        </div>
                                        <p class="text-gray-500 text-[9px] font-bold uppercase tracking-widest mb-0.5">
                                            Campaigns</p>
                                        <p class="text-lg font-extrabold text-gray-900">12</p>
                                    </div>

                                    <!-- Metric Card 4 -->
                                    <div
                                        class="bg-white p-4 rounded-xl shadow-sm border border-gray-100/50 group/card transition-all duration-300">
                                        <div class="flex justify-between items-start mb-3">
                                            <div
                                                class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 group-hover/card:scale-105 transition-transform">
                                                <i class="fas fa-chart-line text-xs"></i>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-green-600 flex items-center bg-green-50 px-1.5 py-0.5 rounded-full">
                                                <i class="fas fa-caret-up mr-0.5"></i> 3.1%
                                            </span>
                                        </div>
                                        <p class="text-gray-500 text-[9px] font-bold uppercase tracking-widest mb-0.5">
                                            Avg ROI</p>
                                        <p class="text-lg font-extrabold text-gray-900">24.5%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Glassmorphism Cards -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-white/90 backdrop-blur-xl rounded-xl shadow-[0_15px_30px_rgba(0,0,0,0.1)] p-4 w-44 hidden md:block animate-float">
                            <div class="flex items-center space-x-3 mb-2.5">
                                <div
                                    class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-100">
                                    <i class="fas fa-check text-white text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Efficiency
                                    </p>
                                    <p class="text-base font-extrabold text-gray-900">+45%</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 h-1 rounded-full overflow-hidden">
                                <div class="bg-indigo-600 h-full w-[45%] rounded-full"></div>
                            </div>
                        </div>

                        <div
                            class="absolute -top-8 -right-8 bg-white/90 backdrop-blur-xl rounded-xl shadow-[0_15px_30px_rgba(0,0,0,0.1)] p-4 w-48 hidden md:block animate-float-delayed">
                            <div class="flex items-center space-x-2.5 mb-3">
                                <div class="flex -space-x-1.5">
                                    <img src="https://i.pravatar.cc/150?u=1"
                                        class="w-6 h-6 rounded-full border-2 border-white shadow-sm" alt="">
                                    <img src="https://i.pravatar.cc/150?u=2"
                                        class="w-6 h-6 rounded-full border-2 border-white shadow-sm" alt="">
                                    <img src="https://i.pravatar.cc/150?u=3"
                                        class="w-6 h-6 rounded-full border-2 border-white shadow-sm" alt="">
                                </div>
                                <span class="text-[8px] font-bold text-gray-500 uppercase tracking-widest">Active
                                    Now</span>
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-base font-extrabold text-gray-900">1.2k</p>
                                    <p class="text-[8px] text-gray-500">New leads weekly</p>
                                </div>
                                <div class="flex space-x-0.5 items-end h-6">
                                    <div class="w-1 h-3 bg-blue-100 rounded-full"></div>
                                    <div class="w-1 h-4 bg-blue-200 rounded-full"></div>
                                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                                    <div class="w-1 h-4 bg-blue-300 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Content -->
                <div class="lg:w-1/2">
                    <div class="mb-8">
                        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-5 leading-tight">
                            Everything You Need to
                            <span class="relative inline-block">
                                <span
                                    class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600">Scale
                                    Your Business</span>
                                <span class="absolute bottom-1 left-0 w-full h-2 bg-indigo-50 -z-0"></span>
                            </span>
                        </h3>
                        <p class="text-gray-600 text-base leading-relaxed mb-7 font-medium">
                            ZynCRM CRM gives you complete visibility into your sales performance, client relationships,
                            and HR operations—all in one intuitive dashboard.
                        </p>

                        <div class="grid grid-cols-2 gap-3 mb-8">
                            <div
                                class="flex items-center p-2.5 rounded-lg bg-gray-50 border border-gray-100 group hover:border-indigo-200 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-md bg-green-100 flex items-center justify-center text-green-600 mr-2.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-xs">Real-time Analytics</span>
                            </div>
                            <div
                                class="flex items-center p-2.5 rounded-lg bg-gray-50 border border-gray-100 group hover:border-indigo-200 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-md bg-blue-100 flex items-center justify-center text-blue-600 mr-2.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-xs">Automated Reports</span>
                            </div>
                            <div
                                class="flex items-center p-2.5 rounded-lg bg-gray-50 border border-gray-100 group hover:border-indigo-200 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-md bg-purple-100 flex items-center justify-center text-purple-600 mr-2.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-xs">Custom Dashboards</span>
                            </div>
                            <div
                                class="flex items-center p-2.5 rounded-lg bg-gray-50 border border-gray-100 group hover:border-indigo-200 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-md bg-orange-100 flex items-center justify-center text-orange-600 mr-2.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-xs">24/7 Monitoring</span>
                            </div>
                        </div>
                    </div>

                    <!-- Feature Cards -->
                    <div class="space-y-5 mb-10">
                        <!-- Feature 1 -->
                        <div
                            class="flex items-start group p-5 rounded-xl bg-white border border-gray-100 hover:shadow-[0_15px_30px_rgba(0,0,0,0.04)] hover:border-indigo-100 transition-all duration-300">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 group-hover:scale-105 transition-all duration-500">
                                <i class="fas fa-chart-pie text-indigo-600 text-xl"></i>
                            </div>
                            <div>
                                <h4
                                    class="text-lg font-bold text-gray-900 mb-1.5 group-hover:text-indigo-600 transition-colors">
                                    Comprehensive Analytics</h4>
                                <p class="text-gray-500 text-sm leading-relaxed font-medium">
                                    Track revenue trends, campaign performance, and client metrics with detailed
                                    visualizations and real-time updates.
                                </p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div
                            class="flex items-start group p-5 rounded-xl bg-white border border-gray-100 hover:shadow-[0_15px_30px_rgba(0,0,0,0.04)] hover:border-indigo-100 transition-all duration-300">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 group-hover:scale-105 transition-all duration-500">
                                <i class="fas fa-users text-emerald-600 text-xl"></i>
                            </div>
                            <div>
                                <h4
                                    class="text-lg font-bold text-gray-900 mb-1.5 group-hover:text-emerald-600 transition-colors">
                                    Client Management</h4>
                                <p class="text-gray-500 text-sm leading-relaxed font-medium">
                                    Manage active clients, track interactions, and monitor relationship health with
                                    intuitive client profiles.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Section -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('trial.create', ['plan' => 'plan_basic']) }}" class="group relative flex-1">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-lg blur opacity-20 group-hover:opacity-40 transition duration-300">
                            </div>
                            <div
                                class="relative flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-xl font-bold transition-all duration-300 transform hover:-translate-y-0.5">
                                <i class="fas fa-rocket mr-2.5 text-sm"></i>
                                Get Started Now
                            </div>
                        </a>
                        <a href="#"
                            class="flex-1 flex items-center justify-center bg-white border border-gray-200 hover:border-indigo-600 text-gray-700 hover:text-indigo-600 px-6 py-4 rounded-xl font-bold transition-all duration-300 transform hover:-translate-y-0.5 group">
                            <i
                                class="fas fa-play-circle mr-2.5 text-indigo-500 group-hover:scale-110 transition-transform text-sm"></i>
                            Watch Product Tour
                        </a>
                    </div>

                    <div class="mt-8 flex items-center justify-center lg:justify-start space-x-5 text-gray-400">
                        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest">
                            <i class="fas fa-shield-alt text-indigo-500/60 mr-2"></i>
                            Enterprise Grade
                        </div>
                        <div class="w-1 h-1 rounded-full bg-gray-200"></div>
                        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest">
                            <i class="fas fa-lock text-indigo-500/60 mr-2"></i>
                            Secure & Encrypted
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Testimonials Section with Owl Carousel -->
    <section id="testimonials"
        class="py-16 px-4 md:px-16 bg-gradient-to-b from-[#f8fbff] to-[#edf5ff] relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-0 left-0 w-48 h-48 bg-blue-50 rounded-full blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-40 translate-x-1/3 translate-y-1/3">
        </div>

        <div class="container mx-auto relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6 md:gap-0">
                <div class="text-left">
                    <span
                        class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold tracking-wider uppercase mb-3 border border-indigo-100">
                        Testimonials
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-tight">
                        Trusted by <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600">Industry
                            Leaders</span>
                    </h2>
                    <p class="text-base text-gray-600 max-w-xl leading-relaxed">
                        Join thousands of professionals who have transformed their business operations with ZynCRM.
                    </p>
                </div>
                <!-- Custom Navigation Buttons -->
                <div class="flex space-x-3 mb-2">
                    <button id="prev-testimonial"
                        class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white hover:shadow-md transition-all duration-300">
                        <i class="fas fa-chevron-left text-sm md:text-base"></i>
                    </button>
                    <button id="next-testimonial"
                        class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white hover:shadow-md transition-all duration-300">
                        <i class="fas fa-chevron-right text-sm md:text-base"></i>
                    </button>
                </div>
            </div>

            <!-- Owl Carousel Container -->
            <div class="owl-carousel owl-theme testimonials-carousel">
                <!-- Testimonial 1 -->
                <div class="item p-3">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative group h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-indigo-50 shadow-sm">
                                    <img src="https://plus.unsplash.com/premium_photo-1691030254390-aa56b22e6a45?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0"
                                        alt="Sarah Johnson" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-bold text-gray-900 text-sm">Sarah Johnson</h4>
                                <p class="text-indigo-600 font-medium text-[10px]">GrowthLabs</p>
                            </div>
                            <div class="ml-auto text-yellow-400 flex space-x-0.5">
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm italic leading-relaxed flex-grow">
                            "ZynCRM has completely transformed our business operations. We've seen productivity increase
                            by 65% and saved over 15 hours per week on HR tasks."
                        </p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="item p-3">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative group h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-indigo-50 shadow-sm">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                        alt="Michael Rodriguez" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-bold text-gray-900 text-sm">Michael Rodriguez</h4>
                                <p class="text-indigo-600 font-medium text-[10px]">Creative Agency</p>
                            </div>
                            <div class="ml-auto text-yellow-400 flex space-x-0.5">
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm italic leading-relaxed flex-grow">
                            "The analytics and reporting features have given us insights we never had before. We can now
                            prove ROI to our clients with clear, data-driven reports."
                        </p>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="item p-3">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative group h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-indigo-50 shadow-sm">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                        alt="Jessica Lee" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-bold text-gray-900 text-sm">Jessica Lee</h4>
                                <p class="text-indigo-600 font-medium text-[10px]">TechStart Inc</p>
                            </div>
                            <div class="ml-auto text-yellow-400 flex space-x-0.5">
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm italic leading-relaxed flex-grow">
                            "Our team collaboration has improved dramatically. The approval workflows and content
                            calendar keep everyone aligned and efficient."
                        </p>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="item p-3">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative group h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-indigo-50 shadow-sm">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                        alt="David Chen" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-bold text-gray-900 text-sm">David Chen</h4>
                                <p class="text-indigo-600 font-medium text-[10px]">E-commerce Brand</p>
                            </div>
                            <div class="ml-auto text-yellow-400 flex space-x-0.5">
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm italic leading-relaxed flex-grow">
                            "ZynCRM helped us grow our Instagram following from 5K to 50K in just 6 months. The audience
                            insights are incredibly valuable."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('admin.partials.pricing')

    
    <!-- FAQ Section -->
    <section class="py-8 bg-[#edf5ff]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span
                    class="inline-block px-5 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium mb-4">FAQ</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Frequently Asked
                    <span class="text-purple-600">Questions</span>
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Get answers to common questions about ZynCRM CRM
                </p>
            </div>

            <!-- FAQ Accordion -->
            <div class="max-w-3xl mx-auto">
                <!-- FAQ Item 1 -->
                <div class="mb-4">
                    <button
                        class="faq-question w-full text-left bg-gray-50 hover:bg-gray-100 rounded-lg p-6 flex justify-between items-center transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-users-cog text-purple-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">How does ZynCRM handle HR and Payroll
                                management?</h3>
                        </div>
                        <div class="faq-icon text-purple-600">
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div
                        class="faq-answer bg-white rounded-b-lg px-6 overflow-hidden max-h-0 transition-all duration-300">
                        <div class="py-6 border-t border-gray-100">
                            <p class="text-gray-600 mb-4">ZynCRM provides a comprehensive HR suite including automated
                                attendance tracking, leave management, and one-click salary slip generation. It
                                streamlines your entire workforce management in one place.</p>
                            <div class="bg-purple-50 rounded-lg p-4">
                                <p class="text-sm text-purple-700 font-medium">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Automate your monthly payroll and attendance reports effortlessly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="mb-4">
                    <button
                        class="faq-question w-full text-left bg-gray-50 hover:bg-gray-100 rounded-lg p-6 flex justify-between items-center transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-bullseye text-blue-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Can I manage my sales pipeline and leads in
                                ZynCRM?</h3>
                        </div>
                        <div class="faq-icon text-blue-600">
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div
                        class="faq-answer bg-white rounded-b-lg px-6 overflow-hidden max-h-0 transition-all duration-300">
                        <div class="py-6 border-t border-gray-100">
                            <p class="text-gray-600 mb-4">Yes, ZynCRM features a visual sales pipeline, integrated lead
                                management through Besdex, and professional proposal generation to help you convert
                                prospects into customers faster.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <i class="fas fa-chart-line text-blue-600 mr-3"></i>
                                    <p class="text-sm font-medium text-blue-700">Visual Pipeline</p>
                                </div>
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <i class="fas fa-file-contract text-blue-600 mr-3"></i>
                                    <p class="text-sm font-medium text-blue-700">Smart Proposals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="mb-4">
                    <button
                        class="faq-question w-full text-left bg-gray-50 hover:bg-gray-100 rounded-lg p-6 flex justify-between items-center transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-tasks text-green-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Can I track projects and collaborate with my
                                team?</h3>
                        </div>
                        <div class="faq-icon text-green-600">
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div
                        class="faq-answer bg-white rounded-b-lg px-6 overflow-hidden max-h-0 transition-all duration-300">
                        <div class="py-6 border-t border-gray-100">
                            <p class="text-gray-600 mb-4">Absolutely. ZynCRM includes a robust project management module
                                where you can assign tasks, set deadlines, track milestones, and communicate with your
                                team via real-time comments and shared notes.</p>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-700">Collaborative Task Management</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-flag text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-700">Milestone & Deadline Tracking</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-comments text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-700">Real-time Team Communication</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="mb-4">
                    <button
                        class="faq-question w-full text-left bg-gray-50 hover:bg-gray-100 rounded-lg p-6 flex justify-between items-center transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-orange-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Do you offer a free trial?</h3>
                        </div>
                        <div class="faq-icon text-orange-600">
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div
                        class="faq-answer bg-white rounded-b-lg px-6 overflow-hidden max-h-0 transition-all duration-300">
                        <div class="py-6 border-t border-gray-100">
                            <p class="text-gray-600 mb-4">Yes! We offer a 15-days full-access free trial. You can explore
                                every feature of ZynCRM CRM without entering any credit card information.</p>
                            <div class="flex items-center text-orange-700 font-bold">
                                <i class="fas fa-gift mr-2"></i>
                                Start your 15-days journey today for free!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modern Footer -->
    <footer class="bg-[#0b0f19] text-white pt-24 pb-8 relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent">
        </div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-600/5 rounded-full blur-[120px]"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 mb-12">
                <!-- Brand Identity -->
                <div class="lg:col-span-4">
                    <div class="flex items-center space-x-3 mb-8 group cursor-pointer">
                        <div
                            class="w-[12rem] h-14 bg-white rounded-2xl flex items-center justify-center shadow-[0_10px_30px_rgba(255,255,255,0.1)]  transition-all duration-500 overflow-hidden">
                            <img src="{{asset ('assets/logo.png') }}" alt="ZynCRM Logo"
                                class="w-full h-14 object-contain px-1 py-1">
                        </div>
                        
                    </div>
                    <p class="text-gray-400 text-lg leading-relaxed mb-10 max-w-sm">
                        The premier CRM platform designed exclusively for community leaders and movement builders.
                        Foster deeper connections and streamline your management.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-11 h-11 bg-gray-800/50 hover:bg-indigo-600 border border-gray-700 hover:border-indigo-500 rounded-xl flex items-center justify-center text-white transition-all duration-500 group">
                            <i class="fab fa-twitter group-hover:scale-110 transition-transform"></i>
                        </a>
                        <a href="#"
                            class="w-11 h-11 bg-gray-800/50 hover:bg-indigo-600 border border-gray-700 hover:border-indigo-500 rounded-xl flex items-center justify-center text-white transition-all duration-500 group">
                            <i class="fab fa-facebook-f group-hover:scale-110 transition-transform"></i>
                        </a>
                        <a href="#"
                            class="w-11 h-11 bg-gray-800/50 hover:bg-indigo-600 border border-gray-700 hover:border-indigo-500 rounded-xl flex items-center justify-center text-white transition-all duration-500 group">
                            <i class="fab fa-linkedin-in group-hover:scale-110 transition-transform"></i>
                        </a>
                        <a href="#"
                            class="w-11 h-11 bg-gray-800/50 hover:bg-indigo-600 border border-gray-700 hover:border-indigo-500 rounded-xl flex items-center justify-center text-white transition-all duration-500 group">
                            <i class="fab fa-instagram group-hover:scale-110 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="lg:col-span-2">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-8">Platform</h3>
                    <ul class="space-y-4">
                        <li><a href="#features"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Features</a>
                        </li>
                        <li><a href="#pricing"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Pricing</a>
                        </li>
                        <li><a href="#testimonials"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Testimonials</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Updates</a>
                        </li>
                    </ul>
                </div>

                <!-- Support & Resources -->
                <div class="lg:col-span-2">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-8">Resources</h3>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Documentation</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Help
                                Center</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>API
                                Reference</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></span>Community</a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="lg:col-span-4">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-8">Stay Updated</h3>
                    <p class="text-gray-400 mb-6">Join our newsletter to get the latest community building insights.</p>
                    <form class="relative group">
                        <input type="email" placeholder="email@example.com"
                            class="w-full bg-gray-900/50 border border-gray-700 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <button
                            class="absolute right-2 top-2 bottom-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 rounded-xl font-bold transition-all flex items-center">
                            Subscribe
                        </button>
                    </form>
                    <div class="mt-6 flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-check text-indigo-500"></i>
                            <span class="text-xs text-gray-500 font-medium">Privacy Guaranteed</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-bolt text-indigo-500"></i>
                            <span class="text-xs text-gray-500 font-medium">Weekly Updates</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="pt-4 border-t border-gray-800/50 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center space-x-8">
                    <p class="text-gray-500 text-sm font-medium">
                        &copy; 2026 ZynCRM. Made in India 
                        <i class="fas fa-heart text-red-500 animate-pulse mx-1"></i>   
                    </p>
                    <div
                        class="hidden md:flex items-center space-x-6 text-xs font-bold text-gray-500 uppercase tracking-widest">
                        <a href="#" class="hover:text-white transition-colors">Privacy</a>
                        <a href="#" class="hover:text-white transition-colors">Terms</a>
                        <a href="#" class="hover:text-white transition-colors">Cookies</a>
                    </div>
                </div>

                <!-- Trust & Security -->
                <div
                    class="flex items-center gap-6 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <div
                        class="flex items-center space-x-2 bg-gray-800/30 px-3 py-1.5 rounded-lg border border-gray-700">
                        <i class="fas fa-lock text-[10px] text-indigo-400"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-300">SSL Secure</span>
                    </div>
                    <div
                        class="flex items-center space-x-2 bg-gray-800/30 px-3 py-1.5 rounded-lg border border-gray-700">
                        <i class="fas fa-shield-alt text-[10px] text-indigo-400"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-300">GDPR Ready</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        // Initialize Owl Carousel
        $(document).ready(function () {
            var owl = $('.testimonials-carousel');
            owl.owlCarousel({
                loop: true,
                margin: 15,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 800,
                responsive: {
                    0: {
                        items: 1
                    },
                    640: {
                        items: 2
                    },
                    1024: {
                        items: 3
                    },
                    1280: {
                        items: 4
                    }
                }
            });

            // Custom Navigation Events
            $('#next-testimonial').click(function () {
                owl.trigger('next.owl.carousel');
            });
            $('#prev-testimonial').click(function () {
                owl.trigger('prev.owl.carousel');
            });
        });

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuLines = document.querySelectorAll('.menu-line');

            menuToggle.addEventListener('click', function (e) {
                e.stopPropagation();

                // Toggle mobile menu visibility
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('scale-y-0');
                mobileMenu.classList.toggle('opacity-0');

                // Toggle hamburger animation
                menuToggle.classList.toggle('active');
                menuLines.forEach(line => {
                    if (menuToggle.classList.contains('active')) {
                        line.style.transform = 'rotate(45deg)';
                        line.style.backgroundColor = '#3b82f6';
                    } else {
                        line.style.transform = 'rotate(0)';
                        line.style.backgroundColor = '';
                    }
                });
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target) && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden', 'scale-y-0', 'opacity-0');
                    menuToggle.classList.remove('active');
                    menuLines.forEach(line => {
                        line.style.transform = 'rotate(0)';
                        line.style.backgroundColor = '';
                    });
                }
            });

            // Close mobile menu when clicking a link
            const mobileLinks = document.querySelectorAll('.mobile-nav-item');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function () {
                    mobileMenu.classList.add('hidden', 'scale-y-0', 'opacity-0');
                    menuToggle.classList.remove('active');
                    menuLines.forEach(line => {
                        line.style.transform = 'rotate(0)';
                        line.style.backgroundColor = '';
                    });
                });
            });

            // Counter animation
            const counters = document.querySelectorAll('.counter');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.getAttribute('data-target'));
                        let current = 0;
                        const duration = 600;
                        const stepTime = 20;
                        const steps = duration / stepTime;
                        const increment = target / steps;

                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                counter.textContent = target;
                                clearInterval(timer);
                            } else {
                                counter.textContent = Math.floor(current);
                            }
                        }, stepTime);

                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => {
                observer.observe(counter);
            });

            // FAQ Accordion
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', function () {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('.faq-icon i');

                    // Close all other FAQ items
                    document.querySelectorAll('.faq-answer').forEach(item => {
                        if (item !== answer) {
                            item.classList.remove('active');
                            item.style.maxHeight = null;
                        }
                    });

                    document.querySelectorAll('.faq-icon i').forEach(item => {
                        if (item !== icon) {
                            item.style.transform = 'rotate(0deg)';
                        }
                    });

                    // Toggle current FAQ item
                    if (answer.classList.contains('active')) {
                        answer.classList.remove('active');
                        answer.style.maxHeight = null;
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        answer.classList.add('active');
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });

            // Open first FAQ by default
            const firstQuestion = document.querySelector('.faq-question');
            if (firstQuestion) {
                const firstAnswer = firstQuestion.nextElementSibling;
                const firstIcon = firstQuestion.querySelector('.faq-icon i');

                firstAnswer.classList.add('active');
                firstAnswer.style.maxHeight = firstAnswer.scrollHeight + 'px';
                firstIcon.style.transform = 'rotate(180deg)';
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Highlight active navigation
            const sections = document.querySelectorAll('section[id]');
            const navItems = document.querySelectorAll('.nav-item');

            function highlightNav() {
                let scrollY = window.pageYOffset;

                sections.forEach(section => {
                    const sectionHeight = section.offsetHeight;
                    const sectionTop = section.offsetTop - 100;
                    const sectionId = section.getAttribute('id');

                    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                        navItems.forEach(item => {
                            item.classList.remove('active');
                            if (item.getAttribute('href') === `#${sectionId}`) {
                                item.classList.add('active');
                            }
                        });
                    }
                });
            }

            window.addEventListener('scroll', highlightNav);
        });
    </script>
    <!-- Enterprise Inquiry Modal -->
    <div id="enterprise-modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 flex items-center justify-center p-2 sm:p-4">
            <div
                class="bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-2xl w-full max-w-2xl transform transition-all flex flex-col max-h-[95vh] sm:max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 md:px-8 md:py-6 flex justify-between items-center shrink-0">
                    <h3 class="text-xl md:text-2xl font-bold text-white tracking-tight">Enterprise Inquiry</h3>
                    <button id="close-modal-btn"
                        class="text-white/80 hover:text-white transition-colors p-2 rounded-full hover:bg-white/10">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="overflow-y-auto px-4 sm:px-6 md:px-8 custom-scrollbar flex-grow">
                    <form class="space-y-5 pt-6 pb-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Full
                                    Name</label>
                                <input type="text"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-800 font-medium"
                                    placeholder="John Doe" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Work
                                    Email</label>
                                <input type="email"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-800 font-medium"
                                    placeholder="john@company.com" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Company
                                    Name</label>
                                <input type="text"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-800 font-medium"
                                    placeholder="Your Organization" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Team
                                    Size</label>
                                <div class="relative">
                                    <select
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-800 font-medium appearance-none bg-white">
                                        <option>10 - 50 Employees</option>
                                        <option>51 - 200 Employees</option>
                                        <option>201 - 500 Employees</option>
                                        <option>500+ Employees</option>
                                    </select>
                                    <div
                                        class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Modules of
                                Interest</label>
                            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Sales
                                        & Lead Hub</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">HR
                                        & Payroll</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Attendance
                                        Records</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Project
                                        Management</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Task
                                        Tracking</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Finance
                                        & Invoicing</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors text-xs sm:text-sm">Support
                                        Desk</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors text-xs sm:text-sm">Chat
                                        & Comm</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Client
                                        Portal</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Reporting</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Campaigns</span>
                                </label>
                                <label
                                    class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Emp
                                        Portal</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Specific
                                Requirements</label>
                            <textarea rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-800 font-medium resize-none"
                                placeholder="Tell us about your organization's unique needs..."></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-blue-200 transform transition-all hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                                <span>Submit Inquiry</span>
                                <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const enterpriseModal = document.getElementById('enterprise-modal');
            const openModalBtn = document.getElementById('contact-sales-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');

            // Open modal
            if (openModalBtn) {
                openModalBtn.addEventListener('click', function () {
                    enterpriseModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                });
            }

            // Close modal
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', function () {
                    enterpriseModal.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                });
            }

            // Close on outside click
            enterpriseModal.addEventListener('click', function (e) {
                if (e.target === enterpriseModal.firstElementChild || e.target === enterpriseModal.children[1]) {
                    enterpriseModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>

</html>