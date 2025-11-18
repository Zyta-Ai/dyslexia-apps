<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBI - Aplikasi Literasi Inklusif</title>
    
    {{-- BULLETPROOF CSS LOADING STRATEGY --}}
    @php
        $isProduction = app()->environment('production');
        $hasViteManifest = file_exists(public_path('build/.vite/manifest.json'));
        $hasFallbackCSS = file_exists(public_path('css/app.css'));
    @endphp
    
    @if ($isProduction || !$hasViteManifest)
        {{-- Production or when Vite manifest not available --}}
        @if ($hasFallbackCSS)
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
        {{-- Always include Tailwind CDN as final fallback --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'teal': { 500: '#14b8a6', 600: '#0d9488' },
                            'amber': { 500: '#f59e0b' },
                            'sky': { 50: '#f0f9ff' },
                            'gray': { 300: '#d1d5db', 800: '#1f2937' }
                        }
                    }
                }
            }
        </script>
    @else
        {{-- Development with Vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
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