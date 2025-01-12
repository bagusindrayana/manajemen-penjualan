<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Print styles */
        @media print {
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .print-container {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-6" onload="window.print()">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md print-container">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-700">Invoice</h1>
                <p class="text-sm text-gray-500">{{$sale->invoice_number}}</p>
                <p class="text-sm text-gray-500">{{$sale->date}}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{env("APP_NAME")}}</h2>
                <p class="text-sm text-gray-500">123 Main Street</p>
                <p class="text-sm text-gray-500">City, Country</p>
                <p class="text-sm text-gray-500">Email: info@company.com</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mt-8">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-200 p-2 text-left text-sm font-semibold text-gray-700">Item</th>
                        <th class="border border-gray-200 p-2 text-left text-sm font-semibold text-gray-700">Qty</th>
                        <th class="border border-gray-200 p-2 text-right text-sm font-semibold text-gray-700">Price</th>
                        <th class="border border-gray-200 p-2 text-right text-sm font-semibold text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->items as $item)
                        <tr>
                            <td class="border border-gray-200 p-2 text-sm text-gray-600">{{$item->product->name}}</td>
                            <td class="border border-gray-200 p-2 text-sm text-gray-600">{{$item->quantity}}</td>
                            <td class="border border-gray-200 p-2 text-right text-sm text-gray-600">Rp {{number_format($item->price,0,',','.')}}</td>
                            <td class="border border-gray-200 p-2 text-right text-sm text-gray-600">RP {{number_format($item->subtotal,0,',','.')}}</td>
                        </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>
        </div>

        <!-- Totals Section -->
        <div class="mt-6 flex justify-end">
            <div class="w-1/2">
                
                
                <div class="flex justify-between font-semibold text-gray-700">
                    <p>Total:</p>
                    <p>
                        Rp {{number_format($sale->total_amount,0,',','.')}}
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
