{{-- <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BGHMC Schedulers</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/master_index.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container px-5">
                <div class="large-6  columns">
						<h1 class="logo"><a href="https://bghmc.doh.gov.ph/" title="BGHMC" rel="home"><img src="http://bghmc.doh.gov.ph/wp-content/uploads/2015/03/bghmc-banner.png"></a></h1>
				</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">                        
                        <li class="nav-item"><a class="nav-link" href="/logout" style="color:black;font-weight: bold;">Logout</a></li>
                    </ul>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container px-4 px-lg-5">
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">

            </div>

         
                @if (App\Http\Controllers\LoggedUser::user_role()== 0 )
                

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                        
                        <h4 class="modal-title">Access Denied</h4>
                        
                        </div>
                        <div class="modal-body">
                        <p>Please contact your administrator</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h2 class="card-title">OR Scheduler<a  href="/"></h2>
                            <i class='fas fa-bed' style='font-size:90px;color:green'></i>
                        </div>
                        <div class="card-footer text-center"><a class="btn btn-secondary btn-sm" href="/orScheduler">Go to Scheduler</a></div>
                    </div>
                </div>

                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h2 class="card-title">NORA Scheduler <a  href="/"></h2>
                            <i class="fas fa-syringe fa-6x " style="color:green"></i>
                            
                        </div>
                        <div class="card-footer text-center">                             
                            <a class="btn btn-secondary btn-sm"  data-toggle="modal" data-target="#myModal">Go to Scheduler</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h2 class="card-title">Pain Scheduler<a  href="/"></h2>
                            <i class="fa fa-user-md" style="font-size:90px;color:green"></i>
                        </div>
                        <div class="card-footer text-center" >
                            <a class="btn btn-secondary btn-sm"  data-toggle="modal" data-target="#myModal" >Go to Scheduler</a>
                        </div>
                    </div>
                </div>

                @else

                <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h2 class="card-title">OR Scheduler<a  href="/noraHome"></h2>
                            <i class='fas fa-bed' style='font-size:90px;color:green'></i>
                        </div>
                        <div class="card-footer text-center"><a class="btn btn-secondary btn-sm" href="/orScheduler">Go to Scheduler</a></div>
                    </div>
                </div>

                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h2 class="card-title">NORA Scheduler <a  href="/noraHome"></h2>
                            <i class="fas fa-syringe fa-6x " style="color:green"></i>
                            
                        </div>
                        <div class="card-footer text-center"><a class="btn btn-secondary btn-sm" href="/noraHome">Go to Scheduler</a></div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h2 class="card-title">Pain Scheduler<a  href="/painHome"></h2>
                            <i class="fa fa-user-md" style="font-size:90px;color:green"></i>
                        </div>
                        <div class="card-footer text-center" ><a class="btn btn-secondary btn-sm" href="painHome" >Go to Scheduler</a></div>
                    </div>
                </div>
                @endif
               
            </div>
        </div>
        <!-- Footer-->
		<div class="row gx-4 gx-lg-5 align-items-center my-5">

            </div>
       
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html> --}}


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

    </style>
</head>

<body style="background-color: #edf0f5">
    <div class="container-fluid">
        <div class="row body-container">
            <div class="col-5">
                <span class="h1" style="color: #232a36">Select Category</span>
                <br>
                <span style="font-size: 20px;">Select from the category where you want to proceed.</span>
            </div>
            <div class="col-7"></div>

            <div class="col-md-4" style="margin-top: 120px;">
                <div class="card">
                    <div class="card-body">
                        <img src="../img/doctor.png" alt="" width="130" height="130" class="img-circle elevation-3"
                            style="margin-left: 125px; margin-top: 25px;">
                        <br>
                        <center style="border: none !important;">
                            <p class="h3" style="border:none !important; margin-top: 15px !important;">OR Scheduler</p>
                        </center>
                        <center style="border: none !important;"><a href="/orScheduler" class="btn" style="margin-top: 40px !important;">Proceed</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 120px;">
                <div class="card">
                    <div class="card-body">
                        <img src="../img/medical-appointment.png" alt="" width="130" height="130"
                            class="img-circle elevation-3" style="margin-left: 110px; margin-top: 25px;">
                            <br>
                        <center style="border: none !important;">
                            <p class="h3" style="border:none !important; margin-top: 15px !important;">NORA Scheduler</p>
                        </center>
                        <center style="border: none !important;"><a href="/noraHome" class="btn" style="margin-top: 40px !important;">Proceed</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 120px;">
                <div class="card">
                    <div class="card-body">
                        <img src="../img/doctor_1.png" alt="" width="130" height="130" class="img-circle elevation-3"
                            style="margin-left: 110px; margin-top: 25px;">
                              <br>
                        <center style="border: none !important;">
                            <p class="h3" style="border:none !important; margin-top: 15px !important;">Pain Logbook</p>
                        </center>
                        <center style="border: none !important;"><a href="painHome" class="btn" style="margin-top: 40px !important;">Proceed</a></center>
                            
                    </div>
                </div>
            </div>
          
        </div>
    </div>
      <div class="col-md-12" style="background: rgb(238,174,202);
background: linear-gradient(344deg, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%); width: auto; height: 350px; margin-top: -150px; z-index: -1;">
            </div>
</body>

</html>
