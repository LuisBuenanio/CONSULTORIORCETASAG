<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div class="flex min-h-screen bg-gray-100">
        <div class="w-1/2 bg-blue-500">
            <!-- Aquí coloca tu imagen o cualquier contenido que desees en la parte izquierda -->
            <img src="{{ asset('img/logos/logo11.png') }}" alt="Imagen izquierda">
        </div>
        <div class="w-1/2">
            <div class="flex justify-center items-center min-h-screen">
                <div class="w-full max-w-md">
                    <div class="bg-white py-16 px-12 shadow-lg rounded-lg">
                        <h2 class="text-2xl mb-6">Iniciar sesión</h2>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
