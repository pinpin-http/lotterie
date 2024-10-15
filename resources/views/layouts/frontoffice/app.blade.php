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
    <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
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
