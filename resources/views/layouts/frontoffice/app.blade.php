<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Néoloto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Néoloto">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Pixel CSS -->
    @vite('resources/css/frontoffice/app.css')

    <!-- On prepare les assets pour le script js ici pour pas avoir de conflit de chemin en fonction de l'url--->
    <script>
        window.lotteryBallImages = [
            "{{ asset('frontoffice/img/boules/boule1.png') }}",
            "{{ asset('frontoffice/img/boules/boule2.png') }}",
            "{{ asset('frontoffice/img/boules/boule3.png') }}",
            "{{ asset('frontoffice/img/boules/boule4.png') }}",
            "{{ asset('frontoffice/img/boules/boule5.png') }}",
            "{{ asset('frontoffice/img/boules/boule6.png') }}",
            "{{ asset('frontoffice/img/boules/boule7.png') }}",
            "{{ asset('frontoffice/img/boules/boule8.png') }}",
        ];
    </script>

    @vite('resources/js/lotteryBackground.js')

</head>
<body>
    <div id="app">
        @include('parts.frontoffice.navbar')


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
