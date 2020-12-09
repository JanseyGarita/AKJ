@extends('layout.layout')

<!--  CSS Imports  -->
@section('styles')
<link rel="stylesheet" href="/styles/home/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
@endsection

<!--  Web page content code  -->
@section('content')
<!-- Hero Section  -->
<div class="hero-container">
    <div class="hero-content">
        <h1 class="text-uppercase text-white">The way it should be</h1>
        <a href="{{route('cars.index')}}" class="text-uppercase btn" id="find-car-btn">Find your car</a>
    </div>
</div>
<!-- Promotion Section  -->
<div class="promo-container row">
    <div id="promo-text-container" class="col-sm-12 col-md-8 p-4">
        <i class="far fa-heart" id="heart-icon"></i>
        <div class="text-container">
            <h3>Shop online</h3>
            <p>Make it yours from a social distance</p>
        </div>
    </div>
    <div id="promo-img-container" class="col-sm-12 col-md-4">
        <img src="/images/home/promo.png" alt="vehicle" class="img-fluid">
    </div>
</div>
<!-- Buy & Sell Section  -->
<div class="services-container row">
    <div id="buy-section" class="col-sm-12 col-md-6 service-section">
        <img src="/images/home/pay.png" alt="buy-a-car" class="img-fluid" style="width: 25%">
        <div class="service-content">
            <h4 class="text-white text-uppercase">looking for a car?</h4>
            <p class="text-white">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Delectus incidunt vero in, architecto optio ipsam eveniet
                cumque unde velit aliquam officia repudiandae asperiores quos sint!
            </p>
            <a href="{{route('cars.index')}}" class="go-btn"><span>take a look</span></a>
        </div>
    </div>
    <div id="sell-section" class="col-sm-12 col-md-6 service-section">
        <img src="/images/home/car.png" alt="buy-a-car" class="img-fluid" style="width: 25%">
        <div class="service-content">
            <h4 class="text-white text-uppercase">selling?</h4>
            <p class="text-white">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Delectus incidunt vero in, architecto optio ipsam eveniet
                cumque unde velit aliquam officia repudiandae asperiores quos sint!
            </p>
            <a href="/sell" class="go-btn"><span>go</span></a>
        </div>
    </div>
</div>
<!-- About us Section  -->
<div class="about-container p-4 mb-5 mt-3">
    <h4>Why buy with us?</h4>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse earum aperiam mollitia a recusandae rerum non
        iusto, sapiente porro animi repudiandae, molestias placeat sint tenetur, blanditiis fuga harum. Odio facere
        possimus provident libero magni itaque animi tempora rerum molestiae, id aspernatur eveniet alias cumque amet
        incidunt consectetur iure reprehenderit cupiditate?
    </p>
</div>
@endsection

<!--  Javascript Imports  -->
@section('scripts')

@endsection