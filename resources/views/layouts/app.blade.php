<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- <script
            type="text/javascript"
            data-cmp-ab="1"
            src="https://cdn.consentmanager.net/delivery/autoblocking/09a543deb1371.js"
            data-cmp-host="a.delivery.consentmanager.net"
            data-cmp-cdn="cdn.consentmanager.net"
            data-cmp-codesrc="16">
        </script>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XLSWR16Q81"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-XLSWR16Q81');
        </script> --}}

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- fontawesome --}}
        <script src="https://kit.fontawesome.com/8d671a092c.js" crossorigin="anonymous"></script>
        {{-- JQuery --}}
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        {{-- オリジナルCSS --}}
        <link rel="stylesheet" href={{ asset('static/css/static.css') }} />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex flex-col min-h-screen font-sans antialiased">
        @include('components.header')
        <div class="flex-grow bg-white">
            @yield('content')
        </div>
        @include('components.footer')
    </body>
</html>
