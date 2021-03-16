<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BGHMC | OR SCHEDULER</title>
    <link rel="icon" href="../img/bghmc.png" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- script --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
          $(".err").click(function(){
            $(".error").fadeOut(1000);
          });
        });
        </script>

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Roboto', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

            {
            margin: 0;
            padding: 0;
        }

        .responsive {
            max-width: 100%;
            height: auto;
        }

        @media screen and (min-width: 601px) {
            div.responsive {
                font-size: 80px;
            }
        }

        @media screen and (max-width: 600px) {
            div.responsive {
                font-size: 30px;
            }
        }

        .css-selector {
            background: linear-gradient(314deg, #d42c2c, #34ddb1);
            background-size: 400% 400%;

            -webkit-animation: AnimationName 12s ease infinite;
            -moz-animation: AnimationName 12s ease infinite;
            animation: AnimationName 12s ease infinite;
        }

        @-webkit-keyframes AnimationName {
            0%{background-position:42% 0%}
            50%{background-position:59% 100%}
            100%{background-position:42% 0%}
        }
        @-moz-keyframes AnimationName {
            0%{background-position:42% 0%}
            50%{background-position:59% 100%}
            100%{background-position:42% 0%}
        }
        @keyframes AnimationName {
            0%{background-position:42% 0%}
            50%{background-position:59% 100%}
            100%{background-position:42% 0%}
        }
        .shake {
            animation: shake-animation 2.5s ease infinite;
            transform-origin: 50% 50%;
        }
        .element: hover {
            animation: none;
        }
    </style>
</head>

<body class="css-selector">
    <div class="row">
        @guest
        <div class="col-lg-7 col-md-7 col-sm-7 mt-5 shadow-lg p-3 mb-5 bg-white"
            style="width:50%; margin-top:10% !important; margin:auto; border-radius: 25px;">
            <div class="row">
                <div class="col-4 border-0">
                    <div class="mt-5 border-0 shake">
                        <div class="mt-5 img-thumbnail bg-white element border-0 float-right" style="width: auto;">
                            <img src="../img/appointment.png" height="255" width="255" class="responsive">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 border-0">
                    <div class="border-0">
                        <div class="card-header bg-white border-0 mt-3">
                            <h2>Baguio General Hospital and Medical Center</h2>
                            <h4>Operating Room Doctor's Scheduler</h4>
                        </div>
                        @if(session('wrong'))
                        <div class="alert alert-danger error" style="border-radius: 25px;">
                            {{ session('wrong') }}
                        </div>
                        @endif
                        <div class="card-body border-0 mb-5">
                            <h3>Login</h3>
                            <form action="{{route('check')}}" method="POST">
                                @csrf
                                <label for="user_name">Username</label>
                                <input id="user_name" type="text" class="form-control" name="username"
                                    {{-- value="{{ old('user_name') }}" --}} placeholder="HOMIS Username" required
                                    autofocus>
                                <br>
                                <label for="user_pass">Password</label>
                                <input id="user_pass" type="password"
                                    class="form-control{{ $errors->has('user_pass') ? ' is-invalid' : '' }}"
                                    placeholder="HOMIS Password" name="password" required>
                                <button type="submit" class="btn btn-primary err sub mt-3">Login</button>
                            </form>
                        </div>
                        {{-- <div class="card-footer text-center bg-white">
                            <small class="text-muted">Developed: MIS Section | Local 202</small>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col justify-content-center text-center">
            <meta http-equiv="refresh" content="3;url={{url('/')}}" />
            <h1 class="font-weight-bolder">You are already logged in :)</h1> <br>
            <code>The page will redirect you to the home page...</code>
        </div>
        @endguest
    </div>
</body>

</html>
