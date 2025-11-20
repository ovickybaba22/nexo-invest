<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#020617] text-slate-100">
        <div class="min-h-screen bg-gradient-to-b from-[#050816] via-[#020617] to-[#020617]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-slate-800/70 bg-[#020617]/90 backdrop-blur-sm">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script type="text/javascript">
            window.$crisp = [];
            window.CRISP_WEBSITE_ID = "26b54f43-f1f2-42f5-a13d-599b7d47cdc8";
            (function () {
                const d = document;
                const s = d.createElement('script');
                s.src = 'https://client.crisp.chat/l.js';
                s.async = 1;
                d.getElementsByTagName('head')[0].appendChild(s);
            })();
        </script>
    </body>
</html>
