<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBI - Daftar Akun Baru</title>
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

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
        }

        .register-bg {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center bottom;
            background-repeat: no-repeat;
        }

        .card-register {
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
        }

        .button-register {
            background: #FFEFBE;
            background: linear-gradient(90deg, rgba(255, 239, 190, 1) 0%, rgba(255, 209, 102, 1) 100%);
            color: #333333;
            box-shadow: 2px 5px 20px rgba(0, 0, 0, 0.4);
            cursor: pointer;
        }
    </style>
</head>

<body class="antialiased bg-dibi-bg text-dibi-text">

    <div class="register-bg min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">

            <div class="bg-dibi-card p-8 rounded-xl shadow-2xl border-3 border-dibi-teal bg-opacity-95 card-register">

                <h2 class="text-3xl font-bold text-center text-dibi-text mb-6">Daftar Akun Baru</h2>

                <form method="POST" action="/register">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-dibi-text font-semibold mb-2">Nama Panggilan</label>
                        <input id="name" type="text" name="name" required autofocus
                            class="w-full px-4 py-3 border-0 border-dibi-teal rounded-lg focus:ring-dibi-gold focus:border-dibi-gold bg-white text-dibi-text text-lg shadow-sm leading-extra-loose">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-dibi-text font-semibold mb-2">Email</label>
                        <input id="email" type="email" name="email" required
                            class="w-full px-4 py-3 border-0 border-dibi-teal rounded-lg focus:ring-dibi-gold focus:border-dibi-gold bg-white text-dibi-text text-lg shadow-sm leading-extra-loose">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-dibi-text font-semibold mb-2">Kata Sandi</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 border-0 border-dibi-teal rounded-lg focus:ring-dibi-gold focus:border-dibi-gold bg-white text-dibi-text text-lg shadow-sm leading-extra-loose">
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-dibi-text font-semibold mb-2">Konfirmasi
                            Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 border-0 border-dibi-teal rounded-lg focus:ring-dibi-gold focus:border-dibi-gold bg-white text-dibi-text text-lg shadow-sm leading-extra-loose">
                    </div>

                    <button type="submit"
                        class="w-full bg-dibi-teal text-white font-bold py-3 rounded-lg text-xl shadow-lg hover:opacity-90 transition duration-150 button-register">
                        DAFTAR AKUN
                    </button>

                    <p class="text-center mt-4 text-dibi-text">
                        Sudah punya akun? <a href="/login" class="text-dibi-teal font-semibold hover:underline">Masuk
                            di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
