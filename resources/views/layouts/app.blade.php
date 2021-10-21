<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <script src="https://use.fontawesome.com/cd636b65bd.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel shadow-sm fixed-top bg-white">
            <div class="container">
                <a class="navbar-brand color-green" href="{{ url('/') }}">
                    {{ config('app.name', 'HookahArt') }}
                </a>
                @if(preg_match('@products@', url()->current()))
                    <a class="btn btn-danger cancel-table-closing" href="{{ route('open-table', ['path' => request('path')]) }}">
                        Back
                    </a>
                    <button class="btn btn-transparent products-basket position-relative" data-bs-toggle="modal" data-bs-target="#products-basket">
                        <i class="bi bi-basket fs-1"></i>
                    </button>
                @endif
            </div>
        </nav>
        <main class="py-4 mt-14">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')
</body>
</html>