<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Canceled</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-red-100 to-white">

    <div class="max-w-md p-10 text-center bg-white shadow-2xl rounded-2xl">
        <div class="mb-4 text-5xl text-red-600">
            ❌
        </div>
        <h1 class="mb-2 text-2xl font-bold text-gray-800">Payment Canceled</h1>
        <p class="mb-6 text-gray-600">
            Unfortunately, your payment could not be completed.<br>Please try again or contact support if the problem persists.
        </p>

        <a href="{{ route('patient.home') }}"
           class="inline-block px-6 py-2 text-white transition bg-red-600 rounded-lg shadow hover:bg-red-700">
           Home
        </a>
    </div>

</body>
</html>
