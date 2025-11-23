<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBI - Aplikasi Literasi Inklusif</title>

    {{-- DYSLEXIA-FRIENDLY FONTS: Atkinson Hyperlegible + Open Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

    {{-- DYSLEXIC FONTS CSS - Font lokal dari server kita --}}
    <link rel="stylesheet" href="{{ asset('css/dyslexic-fonts.css') }}">

    {{-- SIMPLE CDN TAILWIND - NO VITE ERRORS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'teal': {
                            500: '#14b8a6',
                            600: '#0d9488'
                        },
                        'amber': {
                            500: '#f59e0b'
                        },
                        'sky': {
                            50: '#f0f9ff'
                        },
                        'gray': {
                            300: '#d1d5db',
                            800: '#1f2937'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="antialiased bg-sky-50 text-gray-800">

    <main>
        @yield('content')
    </main>
</body>

</html>
