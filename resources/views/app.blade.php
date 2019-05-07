<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                    <h5 class="my-0 mr-md-auto font-weight-normal"><a class="text-dark" href="/">Staff tree</a> | <a class="text-dark" href="{{route('staff')}}">Staff table</a></h5>

                    @if (Route::has('login'))
                        @auth
                        <nav class="my-2 my-md-0 mr-md-3">
                            <a class="p-2 text-dark" href="{{route('staff.create')}}">New</a>
                        </nav>

                            <a class="btn btn-outline-primary" href="{{ url('/home') }}">{{ Auth::user()->name }}</a>
                            <a class="btn btn-outline-primary" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a class="btn btn-outline-primary" href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            @yield('content')

                    <footer class="pt-4 my-md-5 pt-md-5 border-top">
                    </footer>
                </div>
        </div>

    </body>
</html>
