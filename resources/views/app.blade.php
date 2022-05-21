<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravue SPA</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <style>
            .router-link-active {
                color: orange;
            }

            .bg-primary-soft {
                background-color: #e3f2fd;
            }

            a, .btn-link {
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <div id="app"></div>
    </body>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plugin/axios.js') }}"></script>
</html>