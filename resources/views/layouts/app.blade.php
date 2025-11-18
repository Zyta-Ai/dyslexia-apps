<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBI - Aplikasi Literasi Inklusif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        /* [CSS KUSTOM DIBI COLORS HARUS ADA DI app.css atau tailwind.config.js] */
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0; /* Hapus margin default */
            padding: 0; /* Hapus padding default */
        }
    </style>
</head>
<body class="antialiased bg-dibi-bg text-dibi-text leading-extra-loose">
    
    <main>
        @yield('content')
    </main>
</body>
</html>