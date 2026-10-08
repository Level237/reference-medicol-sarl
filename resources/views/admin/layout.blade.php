<!DOCTYPE html>
<html lang="fr" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>@yield('title', 'Espace d’administration') — Référence Médico</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#fcfcfd] font-sans text-dark antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-[260px_minmax(0,1fr)]">
            <!-- Sidebar Desktop & Drawer Mobile -->
            @include('admin.partials.sidebar')

            <div class="flex min-w-0 flex-col">
                @include('admin.partials.header')

                <main class="flex-1 px-4 py-8 sm:px-8 lg:px-10">
                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            // Contrôle du drawer mobile
            const toggleBtn = document.getElementById('toggle-sidebar-mobile');
            const closeBtn = document.getElementById('close-sidebar-mobile');
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openSidebar() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
            }

            function closeSidebar() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        </script>
    </body>
</html>
