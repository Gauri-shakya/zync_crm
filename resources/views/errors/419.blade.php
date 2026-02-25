<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Page Expired</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-2xl w-full mx-4 text-center">
        <div class="mb-6">
            <i class="fas fa-hourglass-end text-6xl text-yellow-500 animate-pulse"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">419 Page Expired</h1>
        <p class="text-gray-600 text-lg mb-6">Sorry, your session has expired.</p>
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
            <p class="text-yellow-700">Please refresh and try again.</p>
        </div>

        <div class="mt-8">
            <a href="{{ url('/') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                <i class="fas fa-home mr-2"></i> Return Home
            </a>
            <button onclick="window.location.reload()" class="ml-4 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out">
                <i class="fas fa-redo mr-2"></i> Refresh Page
            </button>
        </div>
        
        <div class="mt-8 text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Social Cults. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
