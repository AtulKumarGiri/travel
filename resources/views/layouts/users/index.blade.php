<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Travel Management System') }} - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="d-flex flex-column vh-100">

    @include('layouts.users.header')

    <div class="d-flex flex-fill">
        <div id="sidebar" class="bg-light border-end sidebar-fixed">
            @include('layouts.users.sidebar')
        </div>

        <main id="main-content" class="flex-fill p-4">
            @yield('content')
        </main>
        <div>
            @include('layouts.users.rightcanvas')
        </div>
        <div>
            @include('admin.activeusers')
        </div>
        <div>
            @include('layouts.other.confirmation')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const icon = document.getElementById('sidebarIcon');

        toggleBtn.addEventListener('click', () => {
            const isCollapsed = sidebar.classList.toggle('collapsed');

            mainContent.classList.toggle('expanded');

            // Toggle icon
            if (isCollapsed) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x-lg');
            } else {
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            }
        });

        document.getElementById('activeUsersCanvas')
            .addEventListener('show.bs.offcanvas', function () {
                document.querySelector('.bi-people-fill')
                    .closest('button')
                    .classList.add('btn-success');
            });

        document.getElementById('activeUsersCanvas')
            .addEventListener('hidden.bs.offcanvas', function () {
                document.querySelector('.bi-people-fill')
                    .closest('button')
                    .classList.remove('btn-success');
            });

        function updateLiveDateTime() {
            const now = new Date();

            const options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };

            document.getElementById('liveDateTime').innerText =
                now.toLocaleString('en-IN', options);
        }

        // Initial load
        updateLiveDateTime();

        // Update every second
        setInterval(updateLiveDateTime, 1000);
        </script>




</body>
</html>
