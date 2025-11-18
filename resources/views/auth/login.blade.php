<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBI - Masuk Akun</title>
    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
        }

        .login-bg {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center bottom;
            background-repeat: no-repeat;
        }

        .card-login {
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
        }

        .button-login {
            background: #FFEFBE;
            background: linear-gradient(90deg, rgba(255, 239, 190, 1) 0%, rgba(255, 209, 102, 1) 100%);
            color:#333333;
            box-shadow: 2px 5px 20px rgba(0, 0, 0, 0.4);
            cursor: pointer;
        }
    </style>
</head>

<body class="antialiased bg-dibi-bg text-dibi-text">

    <div class="login-bg min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">

            <div class="bg-dibi-card p-8 rounded-xl shadow-2xl border-3 border-dibi-teal bg-opacity-55 card-login">

                <h2 class="text-3xl font-bold text-center text-dibi-text mb-6">Login</h2>

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-dibi-text font-semibold mb-2">Masukan
                            Email</label>
                        <input id="email" type="text" name="email" required autofocus
                            class="w-full px-4 py-3 border-0 border-dibi-teal rounded-lg focus:ring-dibi-gold focus:border-dibi-gold bg-white text-dibi-text text-lg shadow-sm leading-extra-loose">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-dibi-text font-semibold mb-2">Kata Sandi</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 border-0 border-dibi-teal rounded-lg focus:ring-dibi-gold focus:border-dibi-gold bg-white text-dibi-text text-lg shadow-sm leading-extra-loose">
                    </div>

                    <button type="submit"
                        class="w-full bg-dibi-teal text-white font-bold py-3 rounded-lg text-xl shadow-lg hover:opacity-90 transition duration-150 button-login">
                        MASUK
                    </button>

                    <p class="text-center mt-4 text-dibi-text">
                        Belum punya akun? <a href="/register"
                            class="text-dibi-teal font-semibold hover:underline">Daftar di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
