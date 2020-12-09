<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Website logo-->
    <link rel="icon" href="/images/logo-AKJ.png">
    <title>AKJ Vehicles</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!--Poppins-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Main styles-->
    <link rel="stylesheet" href="/styles/layout-styles.css">
    @yield('styles')
</head>

<body>

    <div class="loading-overlay" style="
        position: fixed; z-index: 1000; width: 100%; height: 100%; background: #fff;
        display: flex; justify-content: center; align-items: center;
        ">
        <div class="spinner-box">
            <div class="configure-border-1">
                <div class="configure-core"></div>
            </div>
            <div class="configure-border-2">
                <div class="configure-core"></div>
            </div>
        </div>
    </div>

    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler ml-3" type="button" data-toggle="collapse" data-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/" style="margin-left: 3em;">
            <img src="/images/AKJ-logo.png" alt="logo" class="img-fluid" style="max-width: 110px;">
        </a>
        <div class="collapse navbar-collapse" id="navbarToggler">

            <ul class="navbar-nav ml-auto mt-2 mt-lg-0" style="padding-right: 5em;">
                <li class="nav-item mx-3 <?=($active=='home')? 'active':''?>">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item mx-3 <?=($active=='buy')? 'active':''?>">
                    <a class="nav-link" href="{{route('cars.index')}}">Shop</a>
                </li>
                <li class="nav-item mx-3 <?=($active=='sell')? 'active':''?>">
                    <a class="nav-link" href="/sell">Sell</a>
                </li>
                <div class="btn-group container">

                    <button onclick="window.location.href='/profile'" type="button" class="btn">
                        <i class="fas fa-user"></i>
                    </button>
                    <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <?php
    if(null !== Cookie::get('user')){
?>
                        <a class="dropdown-item" href="/profile">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('profile.posts')}}">Posts</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('profile.saved')}}">Saved</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/sell">Sell</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('log.out')}}">
                            Logout
                            <i class="fas fa-sign-out-alt pl-2"></i>
                        </a>

                    </div>
                    <?php
    }else{
        ?>
                    <a class="dropdown-item" href="{{route('login')}}">
                        Log in
                        <i class="fas fa-sign-in-alt pl-2"></i>
                    </a>
                    <?php
    }
?>
                </div>
            </ul>
        </div>
    </nav>
    <br><br>
    <div class="container-fluid content-container p-0 m-0">
        @yield('content')
    </div>

    <footer>
        <div id="footer">
            <div id="footer-core" class="option1">
                <div id="footer-col1" class="widget-area last pl-3">
                    <h3 class="widget-title">Created by</h3>
                    <div class="error-icon">
                        <span><span>Antony Barboza </span>|<span> Jansey Garita </span>| <span>Keilor
                                Rodríguez</span></span>
                        <br>
                        <p id="year">All rights reserved © 2020</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function(){
            $('.loading-overlay').fadeOut(300);
        });
    </script>
    @yield('scripts')
</body>

</html>