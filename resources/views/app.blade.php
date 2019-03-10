<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                    <h5 class="my-0 mr-md-auto font-weight-normal"><a class="text-dark" href="/">Staff tree</a></h5>
                    <nav class="my-2 my-md-0 mr-md-3">
                        <a class="p-2 text-dark" href="{{route('staff')}}">Table</a> |
                        <a class="p-2 text-dark" href="{{route('staff.ajax')}}">Table ajax</a>
                    </nav>
                    @if (Route::has('login'))
                        @auth
                            <a class="btn btn-outline-primary" href="{{ url('/home') }}">Home</a>
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
