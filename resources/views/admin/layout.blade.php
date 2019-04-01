<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewpoint" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('blog.title') }} 管理后台</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('styles')
    </head>
<body>
    {{-- Navigation Bar --}}
    <nav class="navbar navbar-expand-md navbar-light bg-laravel">
        <div class="container">
            <a class="navbar-brand mr-auto mr-lg-0" href="#">{{ config('blog.title') }}后台</a>
            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                @include('admin.partials.navbar')
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>