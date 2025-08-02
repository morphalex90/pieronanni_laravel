<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#000000" />
    <link rel="preload" fetchpriority="high" href="/img/background.webp" as="image" type="image/webp" />

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <script defer data-domain="pieronanni.me"
        src="https://plausible.morpheus90.com/js/script.file-downloads.hash.outbound-links.js"></script>
    <script>window.plausible = window.plausible || function () { (window.plausible.q = window.plausible.q || []).push(arguments) }</script>

    <script defer src="https://umami.morpheus90.com/script.js"
        data-website-id="8ed0d585-a2f4-4def-980a-12822cfa4856"></script>

    <!-- Fonts -->
    @googlefonts

    @routes
    @viteReactRefresh
    @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
    <div id="modal-root"></div>
</body>

</html>