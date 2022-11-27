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
        $(document).ready(function () {
            $(".err").click(function () {
                $(".error").fadeOut(1000);
            });
        });

    </script>

    <!-- Styles -->
    <style>
        html,
        body {
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
            0% {
                background-position: 42% 0%
            }

            50% {
                background-position: 59% 100%
            }

            100% {
                background-position: 42% 0%
            }
        }

        @-moz-keyframes AnimationName {
            0% {
                background-position: 42% 0%
            }

            50% {
                background-position: 59% 100%
            }

            100% {
                background-position: 42% 0%
            }
        }

        @keyframes AnimationName {
            0% {
                background-position: 42% 0%
            }

            50% {
                background-position: 59% 100%
            }

            100% {
                background-position: 42% 0%
            }
        }

        .shake {
            animation: shake-animation 2.5s ease infinite;
            transform-origin: 50% 50%;
        }

        .element: hover {
            animation: none;
        }

        .custom-select {
            border-color: #28a745;
        }

        .body-container {
            margin: auto;
            margin-top: 150px;
            width: 70%;

        }
        .card {
            border: none !important;
        }

        .card :hover {
            border: 2px solid #45bf6d;
            border-radius: 5px;
            transition: 0.3s;
            color: #45bf6d !important;
        }

        .btn {
            background-color: white;
            color: black;
            padding: 12px 28px;
            font-size: 16px;
            cursor: pointer;
        }

        .default {
            border-color: #dbdad5 !important;
            color: black !important;
        }
        img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

    </style>
</head>

<body style="background-color: #edf0f5">
    <div class="container-fluid">
        <div class="row body-container">
            <div class="col-5">
                <span class="h1" style="color: #232a36; font-size: ">Select Category</span>
                <br>
                <span style="font-size: 20px;">Select from the category where you want to proceed.</span>
            </div>
            <div class="col-7"></div>

            <div class="col-md-4" style="margin-top: 120px;">
                <div class="card">
                    <div class="card-body">
                        <img src="../img/doctor.png" alt="" width="130" height="130" class="img-circle elevation-3"
                            style="margin-top: 25px;">
                        <br>
                        <center style="border: none !important;">
                            <p class="h3" style="border:none !important; margin-top: 10px !important;">Operating Room Scheduler</p>
                        </center>
                        <center style="border: none !important;"><a href="/orScheduler" class="btn" style="margin-top: 70px !important;">Proceed</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 120px;">
                <div class="card">
                    <div class="card-body">
                        <img src="../img/medical-appointment.png" alt="" width="130" height="130"
                            class="img-circle elevation-3" style="margin-top: 25px;">
                            <br>
                        <center style="border: none !important;">
                            <p class="h3" style="border:none !important; margin-top: 10px !important;">NORA Scheduler</p>
                        </center>
                        <center style="border: none !important;"><a href="/noraHome" target="_blank" class="btn" style="margin-top: 70px !important;">Proceed</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 120px;">
                <div class="card">
                    <div class="card-body">
                        <img src="../img/doctor_1.png" alt="" width="130" height="130" class="img-circle elevation-3"
                            style="margin-top: 25px;">
                              <br>
                        <center style="border: none !important;">
                            <p class="h3" style="border:none !important; margin-top: 10px !important;">Pain Logbook</p>
                        </center>
                        <center style="border: none !important;"><a href="painHome" target="_blank" class="btn" style="margin-top: 70px !important;">Proceed</a></center>
                            
                    </div>
                </div>
            </div>
          
        </div>
    </div>
      <footer style="background: rgb(238,174,202);
background: linear-gradient(344deg, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%); width: auto; height: 400px; margin-top: -150px; z-index: -1; position:static">
            </footer>
</body>

</html>
