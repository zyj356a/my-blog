<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta name="csrf-token" content="{{ config( csrf_token()) }}">

    <title> {{ $title ?? config('blog.title') }}</title>
    <link rel="stylesheet" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}" type="application/rss+xml">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">--}}
    @yield('styles')
</head>
<body>
    @include('blog.partials.page-nav')

    @yield('page-header')

    @yield('content')
    @yield('comments')

    @include('blog.partials.page-footer')


    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>