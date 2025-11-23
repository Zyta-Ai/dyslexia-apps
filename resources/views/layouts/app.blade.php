<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBI - Aplikasi Literasi Inklusif</title>

    {{-- FONT PRELOAD FOR BETTER LOADING PERFORMANCE --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    {{-- PRELOAD OPENDYSLEXIC FONT --}}
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Dyslexic:wght@400;700&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Dyslexic:wght@400;700&display=swap">
    </noscript>

    {{-- DYSLEXIC FONTS CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dyslexic-fonts.css') }}">

    {{-- FALLBACK FONT LOADING --}}
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

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
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Loading state untuk font */
        body:not([data-font-loaded]) {
            font-family: 'Comic Sans MS', 'Trebuchet MS', 'Verdana', cursive, sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-sky-50 text-gray-800">
    {{-- Font Loader Script --}}
    <script src="{{ asset('js/font-loader.js') }}"></script>

    @if (config('app.debug'))
        {{-- Font Debug Script (Development Only) --}}
        <script src="{{ asset('js/font-debug.js') }}"></script>
    @endif

    <main>
        @yield('content')
    </main>
</body>

</html>
