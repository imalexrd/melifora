<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Códigos QR de Colmenas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
            .qr-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-8">
        <div class="flex justify-between items-center mb-8 no-print">
            <h1 class="text-3xl font-bold">Códigos QR de Colmenas</h1>
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Imprimir
            </button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($hives as $hive)
                <div class="qr-container bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="mb-4">
                        {!! QrCode::size(150)->generate(route('hives.show', $hive)) !!}
                    </div>
                    <p class="font-semibold">{{ $hive->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
