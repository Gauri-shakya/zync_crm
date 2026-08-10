<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Subscription - ZynCRM</title>
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}?v={{ time() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Complete Your Subscription
        </h1>
        <p class="mt-4 text-xl text-gray-600">
            You're just one step away from unlocking the full power of ZynCRM.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Left: Plan Details -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $plan['name'] }}</h2>
                            <p class="text-gray-500">Perfect for growing businesses</p>
                        </div>
                        <div class="text-right">
                            <span class="text-4xl font-extrabold text-indigo-600">₹{{ number_format($plan['amount']) }}</span>
                            <span class="text-gray-500 font-medium">/month</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600">Up to {{ $planId === 'plan_pro' ? '30' : '10' }} Users</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600">Advanced Analytics Dashboard</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600">Client Management System</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600">24/7 Priority Support</p>
                        </div>
                    </div>

                    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                        <div class="flex items-center space-x-3 text-indigo-700 font-bold mb-2">
                            <i class="fas fa-gift text-xl"></i>
                            <span>5-Minute Free Trial Activated!</span>
                        </div>
                        <p class="text-sm text-indigo-600 leading-relaxed">
                            Your trial period begins today. You won't be charged until <strong>{{ now()->addMinutes(5)->format('H:i:s') }}</strong>. 
                            Cancel anytime before then to avoid charges.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <i class="fas fa-lock text-gray-400 text-xl"></i>
                    <span class="text-sm font-medium text-gray-600">SSL Encrypted</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <i class="fas fa-check-circle text-gray-400 text-xl"></i>
                    <span class="text-sm font-medium text-gray-600">Verified by Razorpay</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <i class="fas fa-undo text-gray-400 text-xl"></i>
                    <span class="text-sm font-medium text-gray-600">Easy Cancellation</span>
                </div>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-8">
                <div class="p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-600">
                            <span>{{ $plan['name'] }}</span>
                            <span>₹{{ number_format($plan['amount']) }}</span>
                        </div>
                        <div class="flex justify-between text-green-600 font-medium">
                            <span>Trial Discount</span>
                            <span>-₹{{ number_format($plan['amount']) }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-gray-900 font-bold">Due Today</span>
                            <span class="text-2xl font-extrabold text-gray-900">₹0</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button id="rzp-button" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                            Authorize & Start Trial
                        </button>
                        
                        <div class="flex items-center justify-center space-x-2">
                            <img src="https://razorpay.com/assets/razorpay-logo-white.svg" alt="Razorpay" class="h-4 opacity-50 filter invert">
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Secure Checkout</span>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100 text-center">
                            <form action="{{ route('logout') }}" method="GET">
                                <button type="submit" class="text-xs text-gray-400 hover:text-red-500 font-medium transition-colors">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout & Try Later
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
                    <p class="text-[10px] text-gray-400 leading-relaxed text-center">
                        By authorizing, you agree to our Terms of Service. A small verification amount (₹1-₹5) may be temporarily held and refunded by Razorpay to verify your payment method.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('rzp-button').onclick = function(e) {
        const btn = this;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Initializing...';
        btn.disabled = true;

        fetch("{{ route('subscriptions.create') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ plan_id: "{{ $planId }}" })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) throw new Error(data.error);

            const options = {
                "key": data.razorpay_key,
                "subscription_id": data.subscription_id,
                "name": "ZynCRM",
                "description": "{{ $plan['name'] }} Authorization",
                "image": "/favicon_io/android-chrome-192x192.png",
                "config": {
                    "display": {
                        "blocks": {
                            "upi": {
                                "name": "Pay via UPI ID",
                                "instruments": [
                                    {
                                        "method": "upi",
                                        "apps": ["google_pay", "phonepe", "paytm"]
                                    }
                                ]
                            }
                        },
                        "sequence": ["block.upi"],
                        "preferences": {
                            "show_default_blocks": true
                        }
                    }
                },
                "prefill": {
                    "name": data.company_name,
                    "email": data.company_email,
                    "contact": data.company_phone
                },
                "handler": function (response) {
                    verifyMandate(response);
                },
                "theme": { "color": "#4f46e5" },
                "modal": {
                    "ondismiss": function() {
                        btn.innerHTML = 'Authorize & Start Trial';
                        btn.disabled = false;
                    }
                }
            };
            const rzp = new Razorpay(options);
            rzp.open();
            
            // Reset button text after opening modal
            btn.innerHTML = 'Authorize & Start Trial';
            btn.disabled = false;
        })
        .catch(err => {
            alert("Error: " + err.message);
            btn.innerHTML = 'Authorize & Start Trial';
            btn.disabled = false;
        });
    };

    function verifyMandate(response) {
        fetch("{{ route('subscriptions.handle-payment') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                razorpay_subscription_id: response.razorpay_subscription_id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_signature: response.razorpay_signature
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = "{{ route('dashboard') }}?trial_started=true";
            } else {
                alert("Authorization failed: " + (data.error || "Please try again."));
            }
        })
        .catch(err => {
            console.error(err);
            alert("An error occurred during verification. Please refresh and try again.");
        });
    }
</script>
</body>
</html>
