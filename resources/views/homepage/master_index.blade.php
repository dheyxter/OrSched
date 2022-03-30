<!DOCTYPE html>
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
</html>
