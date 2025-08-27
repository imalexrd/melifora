<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR de la Colmena: {{ $hive->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');
        body {
            font-family: 'Share Tech Mono', monospace;
        }
        .passport {
            background-color: #FFFBEB; /* Light creamy yellow, like fresh beeswax */
            border: 2px solid #FBBF24; /* Amber-500 */
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            width: 350px;
            height: 500px;
        }
        .passport::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://www.transparenttextures.com/patterns/honeycomb-dark.png');
            opacity: 0.05;
            pointer-events: none;
        }
        .passport-header {
            background-color: #D97706; /* Amber-600 */
            color: #FFFBEB;
            padding: 12px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 2px solid #FBBF24;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        .passport-body {
            padding: 20px;
            color: #92400E; /* Amber-800 */
        }
        .passport-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: #FEF3C7; /* Amber-100 */
            font-size: 0.7rem;
            text-align: center;
            color: #92400E; /* Amber-800 */
            border-top: 1px solid #FBBF24;
        }
        .qr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border: 2px dashed #D97706; /* Amber-600 */
            border-radius: 8px;
        }
        .info-field {
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: bold;
            color: #B45309; /* Amber-700 */
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 1.1rem; /* Slightly larger for better readability */
            color: #92400E; /* Amber-800 */
        }
    </style>
</head>
<body class="bg-gray-200 dark:bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="passport">
        <div class="passport-header">
            {{ $hive->name }}
        </div>
        <div class="passport-body">
            <div class="info-field">
                <span class="info-label">Nombre</span>
                <span class="info-value">{{ $hive->name }}</span>
            </div>
            <div class="info-field">
                <span class="info-label">Apiario</span>
                <span class="info-value">{{ $hive->apiary->name }}</span>
            </div>
            <div class="info-field">
                <span class="info-label">Tipo</span>
                <span class="info-value">{{ $hive->type }}</span>
            </div>
            <div class="info-field">
                <span class="info-label">Origen</span>
                <span class="info-value">{{ $hive->birth_date ? $hive->birth_date->format('d/m/Y') : 'N/A' }}</span>
            </div>

            <div class="qr-container">
                {!! QrCode::size(200)->generate(route('hives.show', $hive)) !!}
            </div>
        </div>
        <div class="passport-footer">
            ID: {{ $hive->slug }}
        </div>
    </div>
</body>
</html>
