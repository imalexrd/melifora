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
            <div class="flex space-x-2">
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Imprimir
                </button>
                <a href="{{ route('hives.downloadPdf', ['hive_ids' => request('hive_ids')]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Descargar PDF
                </a>
                <a href="{{ route('hives.downloadSvgs', ['hive_ids' => request('hive_ids')]) }}" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Descargar SVGs (.zip)
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($hives as $hive)
                <div class="qr-container bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="mb-4 flex justify-center">
                        {!! QrCode::size(150)->generate(route('hives.show', $hive)) !!}
                    </div>
                    <p class="font-semibold text-sm text-center">{{ $hive->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
