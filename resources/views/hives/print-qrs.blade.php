<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Códigos QR de Colmenas</title>
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
        <div class="no-print mb-8">
            <h1 class="text-3xl font-bold">Reporte de Códigos QR</h1>
            <p class="text-gray-600">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="flex justify-between items-center mb-8 no-print">
            <div></div>
            <div class="flex space-x-2">
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Imprimir
                </button>
                <form action="{{ route('hives.downloadSvgs') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="hive_slugs" value="{{ $hives->pluck('slug')->implode(',') }}">
                    <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                        Descargar SVGs (.zip)
                    </button>
                </form>
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
