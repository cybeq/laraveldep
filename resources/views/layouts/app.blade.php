@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@inject('MessageModel', 'App\Http\Controllers\MessageController')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tytul')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/layout.css') }}">
    <!-- Scripts -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
{{--header--}}


<div id="header" class="header">
    <div>
        <a class="navbar-brand" href="{{ url('/') }}">
        <img id="phub-img" class="phub-img" src="{{\Illuminate\Support\Facades\URL::asset('/images/phub.png')}}">
        </a>
        <h1 class="title-h1">party<span class="title-h1-bg">HUB</span></h1>
    </div>
    <div class="tasks-header" style="text-align: right; ">
        <h1  style="margin-top:-5px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            @guest
                @if (Route::has('login'))

                        <a  href="{{ route('login') }}"><button
                                style="font-size:80%;"
                                class="main-link">{{ __('Zaloguj') }}</button></a>

                @endif

                @if (Route::has('register'))

                        <a  href="{{ route('register') }}"><button
                                style="font-size:80%;"
                                class="main-link">{{ __('Zarejestruj') }}</button></a>

                @endif
            @else

                    {{$UsrData->setOnline(true)}}
                    <a class="username-on-bar" href="{{route('profile')}}">
                       #{{ Auth::user()->nick }}
                        <img style="width:25px;"src="http://localhost/img/imprezownia/person.png">
                    </a>

                    <a  href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                     <p>Wyloguj się</p><img style="width:25px;margin-left:5px;" src="{{\Illuminate\Support\Facades\URL::asset('/images/locker.png')}}">
                    </a>

                <a  href="{{ route('mailbox') }}">
                    <p>Wiadomości({{count(json_decode(($MessageModel->showUnSeen())))}})</p><img style="width:25px;margin-left:5px;" src="{{\Illuminate\Support\Facades\URL::asset('/images/mailbox.png')}}">
                </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

            @endguest

        </h1>
    </div>
</div>
{{--    --}}



{{-- body--}}
{{--<div class="body-container">--}}
{{--    <div class="left-body-panel"></div>--}}
@yield('content')
{{--<div class="right-body-panel"></div>--}}
{{--</div>--}}

</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="{{ URL::asset('js/header.js') }}" ></script>
</html>



