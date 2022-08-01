<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">

    @vite(['resources/css/styles.css', 'resources/js/app.js'])
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            const sidebarToggle = document.body.querySelector("#sidebarToggle");
            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", (event) => {
                    event.preventDefault();
                    document.body.classList.toggle("sb-sidenav-toggled");
                    localStorage.setItem(
                        "sb|sidebar-toggle",
                        document.body.classList.contains("sb-sidenav-toggled")
                    );
                });
            }
        });
    </script>
</head>

<body>
    <div id="app">

    </div>

</body>

</html>
