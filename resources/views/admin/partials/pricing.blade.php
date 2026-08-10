{{-- resources/views/admin/partials/pricing.blade.php --}}
<section id="pricing" class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Simple, Transparent Pricing</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Start for free, upgrade as you grow. No hidden fees, no long-term contracts.</p>
        </div>

        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- Basic Plan --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 pricing-card flex flex-col">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Basic</h3>
                        <div class="flex justify-center items-baseline mb-4">
                            <span class="text-3xl font-bold text-gray-800">₹1999</span>
                            <span class="text-gray-600 ml-1">/month</span>
                        </div>
                        <p class="text-gray-600">Essential tools for small teams</p>
                        <p class="text-primary font-bold mt-2">15-days free trial</p>
                    </div>
                    <ul class="text-gray-600 space-y-3 mb-6 flex-grow">
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Up to 10 users</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Lead & Client Management</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>HR & Payroll Suite</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Attendance & Leave Tracking</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Task & Project Management</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Invoice & Proposal Generator</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>24/7 Customer Support</span>
                        </li>
                    </ul>
                    <button onclick="selectPlan('plan_basic')" class="block w-full bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white text-center py-3 rounded-lg font-medium transition duration-300">Start Now</button>
                </div>

                {{-- Pro Plan --}}
                <div class="bg-white rounded-xl shadow-lg border-2 border-primary p-6 pricing-card relative flex flex-col scale-105 z-10">
                    <div class="absolute top-0 right-0 bg-primary text-white px-4 py-1 rounded-bl-lg rounded-tr-lg text-sm font-medium">Most Popular</div>
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pro</h3>
                        <div class="flex justify-center items-baseline mb-4">
                            <span class="text-3xl font-bold text-gray-800">₹4999</span>
                            <span class="text-gray-600 ml-1">/month</span>
                        </div>
                        <p class="text-gray-600">Advanced features for growing teams</p>
                        <p class="text-primary font-bold mt-2">15-days free trial</p>
                    </div>
                    <ul class="text-gray-600 space-y-3 mb-6 flex-grow">
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Up to 30 users</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Lead & Client Management</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>HR & Payroll Suite</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Attendance & Leave Tracking</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Task & Project Management</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Invoice & Proposal Generator</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Priority 24/7 Support</span>
                        </li>
                    </ul>
                    <button onclick="selectPlan('plan_pro')" class="block w-full bg-primary hover:bg-secondary text-white text-center py-3 rounded-lg font-medium transition duration-300 shadow-lg">Start Now</button>
                </div>

                {{-- Enterprise Plan --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 pricing-card flex flex-col">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Enterprise</h3>
                        <div class="flex justify-center items-baseline mb-4">
                            <span class="text-3xl font-bold text-gray-800">Custom</span>
                        </div>
                        <p class="text-gray-600">Tailored solutions for large organizations</p>
                    </div>
                    <ul class="text-gray-600 space-y-3 mb-6 flex-grow">
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Unlimited Users</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>All Business & Pro features</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Custom API Integration</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Dedicated Account Manager</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>White-label Solution</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>On-premise deployment</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-accent mt-1 mr-2"></i>
                            <span>Enterprise-grade security</span>
                        </li>
                    </ul>
                    <button id="contact-sales-btn" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-3 rounded-lg font-medium transition duration-300">Contact Sales</button>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-600 italic">All plans include a 15-days free trial. Auto-pay enabled for seamless monthly renewals.</p>
            </div>
        </div>
    </div>
</section>

{{-- Razorpay Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function selectPlan(planId) {
        @auth
            // If already logged in, redirect to checkout/upgrade page directly
            window.location.href = "{{ route('subscriptions.checkout') }}?plan=" + planId;
        @else
            // If guest, go to the 3-step registration flow
            window.location.href = "{{ route('trial.create') }}?plan=" + planId;
        @endauth
    }

    function payNow(planId, amount) {
        @auth
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Initializing...';
            btn.disabled = true;

            // 1. Create Subscription on Backend
            fetch("{{ route('subscriptions.create') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ plan_id: planId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) throw new Error(data.error);

                // 2. Open Razorpay Checkout
                const options = {
                    "key": data.razorpay_key,
                    "subscription_id": data.subscription_id,
                    "name": "ZynCRM",
                    "description": planId === 'plan_basic' ? "Basic Monthly Subscription" : "Pro Monthly Subscription",
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
                    "handler": function (response) {
                        // 3. Handle Success
                        verifyPayment(response, planId, amount);
                    },
                    "theme": { "color": "#4f46e5" }
                };
                const rzp = new Razorpay(options);
                rzp.open();
                
                btn.innerHTML = originalText;
                btn.disabled = false;
            })
            .catch(err => {
                alert("Error: " + err.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        @else
            window.location.href = "{{ route('login') }}?redirect=pricing";
        @endauth
    }

    function verifyPayment(response, planId, amount) {
        fetch("{{ route('subscriptions.handle-payment') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                razorpay_subscription_id: response.razorpay_subscription_id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_signature: response.razorpay_signature,
                plan_name: planId === 'plan_basic' ? 'Basic' : 'Pro',
                amount: amount
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Subscription activated successfully!");
                window.location.href = "{{ route('dashboard') }}";
            } else {
                alert("Payment verification failed. Please contact support.");
            }
        });
    }
</script>
