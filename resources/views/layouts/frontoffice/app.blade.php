<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Neumorphism UI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Neumorphism UI">
    
    <link rel="canonical" href="https://themesberg.com/product/ui-kits/neumorphism-ui/" />
    
    <!--  Social tags -->
    <meta name="keywords" content="neumorphism, neumorphism ui, neomorphism, neomorphism ui, neomorphism css, neumorphism css, neumorph, neumorphic, design system, login, form, table, tables, card, cards, navbar, modal, icons, icons, map, chat, carousel, menu, datepicker, gallery, slider, date, social, dropdown, search, tab, nav, footer, date picker, forms, tabs, time, button, select, input, timeline, cart, about us, account, log in, blog, profile, portfolio, landing page, ecommerce, shop, landing, register, app, contact, one page, sign up, signup, store, bootstrap 4, bootstrap4, dashboard, bootstrap 4 dashboard, bootstrap 4 design, bootstrap 4 system, bootstrap 4, bootstrap 4 uit kit, bootstrap 4 kit, themesberg, html kit, html css template, web template, bootstrap, bootstrap 4, css3 template, frontend, responsive bootstrap template, bootstrap ui kit, responsive ui kit">
    <meta name="description" content="Start developing neumorphic web applications and pages using Neumorphism UI. It features over 100 individual components and 5 example pages.">
    
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Neumorphism UI by Themesberg">
    <meta itemprop="description" content="Start developing neumorphic web applications and pages using Neumorphism UI. It features over 100 individual components and 5 example pages.">
    <meta itemprop="image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/neumorphism-ui/neumorphism-thumbnail.jpg">
    
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@themesberg">
    <meta name="twitter:title" content="Neumorphism UI by Themesberg">
    <meta name="twitter:description" content="Start developing neumorphic web applications and pages using Neumorphism UI. It features over 100 individual components and 5 example pages.">
    <meta name="twitter:creator" content="@themesberg">
    <meta name="twitter:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/neumorphism-ui/neumorphism-thumbnail.jpg">
    
    <!-- Open Graph data -->
    <meta property="fb:app_id" content="214738555737136">
    <meta property="og:title" content="Neumorphism UI by Themesberg" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://demo.themesberg.com/neumorphism-ui/" />
    <meta property="og:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/neumorphism-ui/neumorphism-thumbnail.jpg"/>
    <meta property="og:description" content="Start developing neumorphic web applications and pages using Neumorphism UI. It features over 100 individual components and 5 example pages." />
    <meta property="og:site_name" content="Themesberg" />
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="./frontoffice/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./frontoffice/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./frontoffice/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="./frontoffice/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="./frontoffice/img/favicon/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <!-- Pixel CSS -->
    @vite('resources/css/frontoffice/app.css')    
    <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
    
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
