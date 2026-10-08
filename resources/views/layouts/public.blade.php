<!DOCTYPE html>
<html lang="fr" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Équipements médicaux') — Référence Médico Sarl</title>
        <meta name="description" content="@yield('meta_description', 'Référence Médico Sarl fournit des équipements et appareils médicaux aux hôpitaux et aux cliniques.')">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-white font-sans text-dark antialiased">
        @include('partials.topbar')
        @include('partials.header')

        <main id="contenu">
            @yield('content')
        </main>
    </body>
</html>
