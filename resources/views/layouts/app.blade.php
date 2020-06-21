<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <title>@yield('title', 'Main page')</title>
</head>
<body class="d-flex flex-column bg-white">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-lg">
                <a class="navbar-brand" href="{{ route('domains.create') }}">Analyzer</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('domains.create') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('domains.index') }}">Domains</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-grow-1 content">
        @include('flash::message')
        @yield('content')
    </main>
    <footer class="border-top py-3 mt-5 bg-dark text-white">
        <div class="container-lg">
            <div class="text-center">
                created by
                <a class="text-warning" href="https://ru.hexlet.io/u/driver" target="_blank">DriveR</a>
            </div>
        </div>
    </footer>
</body>
</html>