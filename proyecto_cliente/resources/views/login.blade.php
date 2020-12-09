<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Website logo-->
    <link rel="icon" href="/images/logo-AKJ.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!--Poppins-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!--Font Awesome-->
    <script src="https://kit.fontawesome.com/b94e20be92.js"></script>
    <!--Main styles-->
    <link rel="stylesheet" href="/styles/layout-styles.css">
    <link rel="stylesheet" href="/styles/login/style.css">

    <title>AKJ - Login</title>
</head>

<body>


    <!-- Loading overlay -->
    <div class="loading-overlay"
        style="position: fixed; z-index: 1000; width: 100%; height: 100%; background: #fff; display: flex; justify-content: center; align-items: center;">
        <div class="spinner-box">
            <div class="configure-border-1">
                <div class="configure-core"></div>
            </div>
            <div class="configure-border-2">
                <div class="configure-core"></div>
            </div>
        </div>
    </div>

    <!-- Page blured backdrop image -->
    <div class="container-fluid" id="backdrop">
    </div>

    <!--Content Code start-->
    <div class="container" style="width: 60%; height: 80vh; position: relative;">
        <div id="logo">
        </div>
        <div class="row" style="position: relative; height: 100%;">
            <div class="col-sm-12 login-content">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#nav-login"
                            role="tab" aria-controls="nav-login" aria-selected="true">Log in</a>
                        <a class="nav-item nav-link" id="nav-signup-tab" data-toggle="tab" href="#nav-signup" role="tab"
                            aria-controls="nav-signup" aria-selected="false">Sign up</a>
                    </div>
                </nav>


                <div class="tab-content p-3 px-sm-0 row" id="nav-tabContent">
                    
                    <div class="alert alert-danger" style="display:none"  role="alert" id="emailexist">
                        <span>
                        <p>This email already exist. -Please LOG IN-</p>
                        </span>
                      </div>
                    <!-- Log in -->
                    <div class="tab-pane fade show active p-4 col-sm-12 col-md-6" id="nav-login" role="tabpanel"
                        aria-labelledby="nav-login-tab">
                        <!-- Social media login buttons -->
                        <div class="btn-container">

                            <a href="{{route('social.auth','google')}}"
                                class="btn btn-outline-danger social-login-btn px-3" id="google-login">
                                <i class="fab fa-google pr-3"></i>Sign in with Google
                            </a>
                            <a href="{{route('social.auth','github')}}"
                                class="btn btn-outline-primary social-login-btn px-3" id="facebook-login">
                                <i class="fab fa-github pr-3"></i>Sign in with GitHub
                            </a>
                        </div>
                        <!-- Divider -->
                        <p class="divider-text">
                            <span class="bg-light text-uppercase p-2">or</span>
                        </p>

                        
                        <!-- Login form -->
                        <form style="position: relative; width: 60%;" action=" {{ route('user_login') }} "
                            method="POST">
                            @csrf
                            <!-- Email -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input name="user_email" class="form-control" placeholder="Email" type="email" required>
                            </div>
                            <!-- Password -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="user_password" class="form-control" placeholder="Password" type="password"
                                    required>
                            </div>
                              
                            <!-- Login Button -->
                            <p class="text-danger text-center">
                                <?php
                            if(isset($message)){
                                print_r("Wrong email or password");
                            }
                            
                            ?></p>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block login-btn">
                                    Log in <i class="fas fa-sign-in-alt pl-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Sign up -->
                    <div class="tab-pane fade p-4 col-sm-12 col-md-6" id="nav-signup" role="tabpanel"
                        aria-labelledby="nav-signup-tab">
                        <!-- Social media login buttons -->
                        <br>
                        <div class="btn-container">
                        <a href="{{route('social.auth','google')}}"
                                class="btn btn-outline-danger social-login-btn px-3" id="google-login">
                                <i class="fab fa-google pr-3"></i>Sign in with Google
                            </a>
                            <a href="{{route('social.auth','github')}}"
                                class="btn btn-outline-primary social-login-btn px-3" id="facebook-login">
                                <i class="fab fa-github pr-3"></i>Sign in with GitHub
                            </a>
                        </div>
                        <!-- Divider -->
                        <p class="divider-text">
                            <span class="bg-light text-uppercase p-2">or</span>
                        </p>
                        <!-- Sign up Form -->
                        
                        <form action=" {{ route('user_singup') }}" method="POST" style="position: relative; width: 60%; "
                            oninput='user_password_2.setCustomValidity(user_password_2.value != user_password.value ? "Passwords do not match." : "")'>
                            @csrf
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="user_full_name" class="form-control" placeholder="Full name" type="text"
                                    required>
                            </div>
                            <!-- form-group -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input name="user_email" class="form-control" placeholder="Email address" type="email"
                                    required>
                            </div>
                             <!-- form-group -->
                             <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-phone-volume"></i> </span>
                                </div>
                                <input name="phone" class="form-control" placeholder="Phone Number" type="text"
                                    required>
                            </div>
                             <!-- form-group -->
                             <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-map-marker-alt"></i> </span>
                                </div>
                                <input name="address" class="form-control" placeholder="Address" type="text"
                                    required>
                            </div>
                            <!-- form-group -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="user_password" class="form-control" placeholder="Create password"
                                    type="password" required>
                            </div>
                            <!-- form-group -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="user_password_2" class="form-control" placeholder="Repeat password"
                                    type="password" required>
                            </div>
                            <!-- form-group -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block signup-btn">Create Account
                                </button>
                            </div>
                            <!-- form-group -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Content Code start-->

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js">
    </script>

    @if (Session::has('message'))
    <script>
        //setTimeout(() => {  alert('This email already exist. -Please LOG IN-') }, 300);

        setTimeout(function(){
             $('#emailexist').show();
             $('#emailexist').fadeIn();
         }, 300);
         setTimeout(function(){
            $('#emailexist').hide();
         }, 5000);
         

    </script>
    @endif

    <script>
        $(document).ready(function(){
            $('.loading-overlay').fadeOut(300);
        });

    </script>
</body>

</html>