<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-100 to-white">

    <div class="max-w-md p-10 text-center bg-white shadow-2xl rounded-2xl">
        <div class="mb-4 text-5xl text-green-600">
            ✅
        </div>
        <h1 class="mb-2 text-2xl font-bold text-gray-800">Payment Successful</h1>
        <p class="mb-6 text-gray-600">
            Thank you for your purchase. Your transaction was completed successfully.
        </p>

        <div class="p-4 mb-6 text-sm text-left rounded-lg bg-gray-50">
            <p><strong>Transaction ID:</strong> {{ $transaction['id'] ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $transaction['status'] ?? 'N/A' }}</p>
            <p><strong>Amount:</strong>
                {{ $transaction['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? '' }}
                {{ $transaction['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? '' }}
            </p>
        </div>

        <a href="{{ route('patient.home') }}"
           class="inline-block px-6 py-2 text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700">
            Home
        </a>
    </div>

</body>
</html>
