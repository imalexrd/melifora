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
            background-color: #f7f5e6;
            border: 2px solid #d4cba7;
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
            background-image: url('https://www.transparenttextures.com/patterns/old-paper.png');
            opacity: 0.3;
            pointer-events: none;
        }
        .passport-header {
            background-color: #4a5568; /* A darker, more official color */
            color: #f7f5e6;
            padding: 10px;
            text-align: center;
            font-size: 1.25rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #d4cba7;
        }
        .passport-body {
            padding: 20px;
            color: #333;
        }
        .passport-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: #e2e8f0;
            font-size: 0.7rem;
            text-align: center;
            color: #4a5568;
        }
        .qr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border: 1px dashed #4a5568;
        }
        .info-field {
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: bold;
            color: #4a5568;
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 1rem;
            color: #1a202c;
        }
    </style>
</head>
<body class="bg-gray-200 dark:bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="passport">
        <div class="passport-header">
            Pase de Colmena
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
