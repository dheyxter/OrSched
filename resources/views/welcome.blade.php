<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BGHMC | OR SCHEDULER</title>
    <link rel="icon" href="../img/bghmc.png" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
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
    

        body {
            background: url('../img/background.jpg');
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

    </style>
</head>

<body>
    <div class="row">
        <div class="col-7 mt-5 shadow-lg p-3 mb-5 bg-white"
            style="width:50%; margin-top:150px !important; margin:auto; border-radius: 25px;">
            <div class="row">
                <div class="col-4 border-0">
                    <div class="mt-5 border-0">
                        <div class="mt-5 img-thumbnail border-0 float-right" style="width: auto;">
                            <img src="../img/dd.png">
                        </div>
                    </div>
                </div>
                <div class="col-8 border-0">
                    <div class="border-0">
                        <div class="card-header border-0 mt-3">
                            <h2>Baguio General Hospital and Medical Center</h2>
                            <h4>Operating Room Doctor's Scheduler</h4>
                        </div>
                        <div class="card-body border-0 mb-5">
                            <h3>Login</h3>
                            <form action="{{route('check')}}" method="POST" >
                                @csrf
                                <label for="user_name">Username</label>
                                <input id="user_name" type="text" style="border-radius: 25px;" class="form-control"
                                    name="user_name" {{-- value="{{ old('user_name') }}" --}} placeholder="Enter Username"
                                    required autofocus>
                                <br>
                                <label for="user_pass">Password</label>
                                <input id="user_pass" type="password" style="border-radius: 25px;"
                                    class="form-control{{ $errors->has('user_pass') ? ' is-invalid' : '' }}"
                                    placeholder="Enter Password" name="user_pass" required>
                                <button type="submit" class="btn btn-primary mt-3" style="border-radius: 25px;">Login Now</button>
                            </form>
                            @if(session('wrong'))
                                <div class="alert alert-danger">
                                    {{ session('wrong') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{-- <small>Created by: MIS Section | Local 202</small> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
