<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CDN TAILWIND - NO VITE ERRORS --}}
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
    <title>Document</title>
</head>

<body>
    <h1 class="text-3xl font-bold underline">Hello Dunia</h1>
</body>

</html>
