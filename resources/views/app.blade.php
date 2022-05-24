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

    <body class="d-flex flex-column min-vh-100">
        <div id="app"></div>
        
        <footer class="footer mt-auto py-1 bg-primary-soft bg-dark">
            <div class="container">
                <div class="d-flex bd-highlight">
                    <div class="flex-grow-1 bd-highlight text-white">
                    <figure class="mt-2">
                        <blockquote class="blockquote text-white">
                            <p>Get in touch.</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0 text-white">
                            &copy; <cite title="Source Title">indra.ndra26@gmail.com</cite>
                        </figcaption>
                    </figure>
                </div>
                    <div class="bd-highlight text-white">
                        <figure class="mt-2">
                            <blockquote class="blockquote text-white">
                                <p>Laravue SPA.</p>
                            </blockquote>
                        </figure>
                    </div>
                  </div>
            </div>
        </footer>
    </body>
    
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('js/plugin/axios.js') }}"></script> --}}
</html>