<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sajio Billing</title>
    <!-- Fonts -->

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.body.querySelector("#sidebarToggle");
            console.log(sidebarToggle)
            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", (event) => {
                    event.preventDefault();
                    console.log('1');
                    document.body.classList.toggle("sb-sidenav-toggled");
                    localStorage.setItem(
                        "sb|sidebar-toggle",
                        document.body.classList.contains("sb-sidenav-toggled")
                    );
                });
            }
        });
    </script>

    @vite(['resources/css/styles.css', 'resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div id="app">


    </div>

</body>


</html>
