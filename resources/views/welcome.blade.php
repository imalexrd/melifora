<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Apicultura</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/bee.ico') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos para animaciones y fondo dinámico de hexágonos -->
    <style>
        /* Animación para que el formulario aparezca sutilmente */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        /* Contenedor para los hexágonos animados */
        .background-hexagons {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1; /* Lo pone detrás de todo el contenido */
        }

        .background-hexagons li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            /* Forma de hexágono usando clip-path */
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            animation: floatUp 25s linear infinite;
            bottom: -150px; /* Inician fuera de la pantalla */
        }

        /* Definimos la animación para que floten hacia arriba */
        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        /* "Randomizamos" las propiedades de cada hexágono para un efecto orgánico */
        .background-hexagons li:nth-child(1) { left: 25%; width: 80px; height: 80px; animation-delay: 0s; background-color: rgba(255, 215, 0, 0.15); } /* primary-light */
        .background-hexagons li:nth-child(2) { left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; background-color: rgba(255, 193, 7, 0.2); } /* primary */
        .background-hexagons li:nth-child(3) { left: 70%; width: 20px; height: 20px; animation-delay: 4s; background-color: rgba(255, 160, 0, 0.1); } /* primary-dark */
        .background-hexagons li:nth-child(4) { left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; background-color: rgba(255, 215, 0, 0.2); } /* primary-light */
        .background-hexagons li:nth-child(5) { left: 65%; width: 20px; height: 20px; animation-delay: 0s; background-color: rgba(255, 193, 7, 0.25); } /* primary */
        .background-hexagons li:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; background-color: rgba(255, 160, 0, 0.15); } /* primary-dark */
        .background-hexagons li:nth-child(7) { left: 35%; width: 150px; height: 150px; animation-delay: 7s; background-color: rgba(255, 215, 0, 0.1); } /* primary-light */
        .background-hexagons li:nth-child(8) { left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; background-color: rgba(255, 193, 7, 0.2); } /* primary */
        .background-hexagons li:nth-child(9) { left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; background-color: rgba(255, 160, 0, 0.25); } /* primary-dark */
        .background-hexagons li:nth-child(10) { left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s; background-color: rgba(255, 215, 0, 0.15); } /* primary-light */
    </style>
</head>
<body class="antialiased bg-background text-text-dark">
    
    <!-- Contenedor para los hexágonos animados -->
    <ul class="background-hexagons">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    {{-- Contenedor principal con Flexbox para centrar el formulario --}}
    <div class="relative flex items-center justify-center min-h-screen px-4 py-8 sm:px-6 lg:px-8">
        
        {{-- Tarjeta de Login (sin cambios respecto a la versión anterior) --}}
        <div class="w-full max-w-md p-6 space-y-6 transition-shadow duration-300 bg-surface rounded-2xl shadow-lg sm:p-8 animate-fadeInUp hover:shadow-xl border border-primary-light/20">
            
            {{-- Encabezado con icono de abeja --}}
            <div class="flex flex-col items-center space-y-2">
                {{-- Icono de Abeja como imagen --}}
                <img src="{{ asset('assets/img/bee_button.png') }}" alt="Abeja" class="w-12 h-12 object-contain">
                <h1 class="text-3xl font-bold text-center text-text-dark">
                    Bienvenido de vuelta
                </h1>
                <p class="text-text-light">Inicia sesión para continuar</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Correo Electrónico" class="text-text-light" />
                    <x-text-input 
                        id="email" 
                        class="block w-full mt-1 transition duration-150 ease-in-out border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Contraseña" class="text-text-light" />
                    <x-text-input 
                        id="password" 
                        class="block w-full mt-1 transition duration-150 ease-in-out border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="text-primary border-gray-300 rounded shadow-sm focus:ring-primary-dark" name="remember">
                        <span class="ms-2 text-sm text-text-light">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm transition duration-150 ease-in-out underline text-text-light hover:text-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                {{-- Botón de Login principal --}}
                <div>
                    <x-primary-button class="w-full justify-center py-3 text-lg font-semibold text-text-dark bg-primary hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark transition duration-200 ease-in-out transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
                
                {{-- Divisor "OR" --}}
                <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-primary-light/50 after:mt-0.5 after:flex-1 after:border-t after:border-primary-light/50">
                    <p class="mx-4 mb-0 text-center font-semibold text-text-light">
                      O
                    </p>
                </div>

                {{-- Botón de Google --}}
                <div>
                    <a href="{{ route('google.redirect') }}" class="w-full">
                        <button type="button" class="w-full inline-flex items-center justify-center px-4 py-3 bg-surface border border-gray-300 rounded-md font-semibold text-sm text-text-dark tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                            {{-- Icono SVG de Google --}}
                            <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.574l6.19,5.238C42.012,35.846,44,30.138,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                            </svg>
                            Continuar con Google
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>