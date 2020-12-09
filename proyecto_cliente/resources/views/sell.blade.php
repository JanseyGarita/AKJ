@extends('layout.layout')

<!--  CSS Imports  -->
@section('styles')
<!--Material Design Iconic Font-->
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="/styles/sell/image-uploader.min.css">
<link rel="stylesheet" href="/libraries/bootstrap-colorselector.css">
<link rel="stylesheet" href="/styles/sell/style.css">
<script src="https://kit.fontawesome.com/b94e20be92.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

<!--  Sell form code  -->
@section('content')
<input type="hidden" id="isUpdate" value="false">
<div class="container-fluid form-container p-4">
    <form method="POST" action="{{route('cars.store')}}" name="sell-form" enctype="multipart/form-data" class="p-5">
        {{csrf_field()}}
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <!--Price-->
                <div class="form-group float-label-control label-bottom">
                    <label for="title">Price</label>
                    <input type="number" class="form-control" value="0" min="0" id="price" name="price" required>
                </div>
                <!--Make-->
                <div class="form-group float-label-control label-bottom makes-input-container">
                    <label for="makes-input">Make</label>
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <select class="form-control selectpicker" id="makes-input" name="make"
                                    data-live-search="true" required>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Model-->
                <div class="form-group float-label-control label-bottom models-input-container">
                    <label for="models-container">Model</label>
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query" id="models-container">
                                <select class="form-control selectpicker" id="models-input" name="model"
                                    data-live-search="true" required>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Year-->
                <div class="float-label-control label-bottom">
                    <label for="year">Year</label>
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input type="number" min="1960" max="2024" value="2010" class="form-control" id="year"
                                    name="year" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Type -->
                <div class="float-label-control label-bottom py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-label-control label-bottom">
                                <label for="year">Type</label>
                                <div class="typeahead__container">
                                    <div class="typeahead__field">
                                        <div class="typeahead__query">
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="SUV">SUV</option>
                                                <option value="Truck">Truck</option>
                                                <option value="Crossover">Crossover</option>
                                                <option value="Sedan">Sedan</option>
                                                <option value="Coupe">Coupe</option>
                                                <option value="Sport">Sport</option>
                                                <option value="Convertible">Convertible</option>
                                                <option value="Luxury">Luxury</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="Van">Van</option>
                                                <option value="Electric">Electric</option>
                                                <option value="Hybrid">Hybrid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <!--Transmission-->
                <div class="form-group float-label-control label-bottom">
                    <label for="transmission">Transmission</label>
                    <select class="form-control" id="transmission" name="transmission">
                        <option value="A">Automatic</option>
                        <option value="M">Manual</option>
                    </select>
                </div>
                <!--Fuel type-->
                <div class="form-group float-label-control label-bottom">
                    <label for="fuel">Fuel</label>
                    <select class="form-control" id="fuel" name="fuel">
                        <option value="G">Gasoline</option>
                        <option value="D">Diesel</option>
                        <option value="E">Electric</option>
                    </select>
                </div>
                <!--Doors-->
                <div class="form-group float-label-control label-bottom">
                    <label for="doors">Doors</label>
                    <input type="number" min="0" max="10" class="form-control" value="0" id="title" name="doors"
                        required>
                </div>
                <!--Cylinders-->
                <div class="form-group float-label-control label-bottom">
                    <label for="cylinders">Cylinders</label>
                    <input type="number" min="0" class="form-control" value="0" id="title" name="motor" required>
                </div>
                <!--Car Colors-->
                <div class="form-group float-label-control label-bottom py-2">
                    <div class="row">
                        <!--Interior Color-->
                        <div class="col-sm-12 col-md-6">
                            <label for="interior-color">Interior Color</label>
                            <select class="form-control color-picker" id="interior-color" name="incolor">
                                <option value="White" data-color="#fff">White</option>
                                <option value="Red" data-color="#ed0000">Red</option>
                                <option value="Blue" data-color="#030bff">Blue</option>
                                <option value="Black" data-color="#000" selected="selected">Black</option>
                                <option value="Orange" data-color="#ff5703">Orange</option>
                                <option value="Yellow" data-color="#ffd000">Yellow</option>
                                <option value="Green" data-color="#229c1c">Green</option>
                                <option value="Turquoise" data-color="#43e8d8">Turquoise</option>
                                <option value="Gray" data-color="#636e72">Gray</option>
                                <option value="Brown" data-color="#83502e">Brown</option>
                            </select>
                        </div>
                        <!--Exterior Color-->
                        <div class="col-sm-12 col-md-6">
                            <label for="exterior-color">Exterior Color</label>
                            <select class="form-control color-picker" id="exterior-color" name="excolor">
                                <option value="White" data-color="#fff">White</option>
                                <option value="Red" data-color="#ed0000">Red</option>
                                <option value="Blue" data-color="#030bff">Blue</option>
                                <option value="Black" data-color="#000" selected="selected">Black</option>
                                <option value="Orange" data-color="#ff5703">Orange</option>
                                <option value="Yellow" data-color="#ffd000">Yellow</option>
                                <option value="Green" data-color="#229c1c">Green</option>
                                <option value="Turquoise" data-color="#43e8d8">Turquoise</option>
                                <option value="Gray" data-color="#636e72">Gray</option>
                                <option value="Brown" data-color="#83502e">Brown</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Conditions -->
        <div class="row pb-4">
            <div class="col-sm-4 col-md-4">
                <input type="checkbox" name="negotiable" value="true">
                <label for="vehicle1"> Is Negotiable?</label>
            </div>
            <div class="col-sm-4 col-md-4">
                <input type="checkbox" name="swap" value="true">
                <label for="vehicle1">Swap?</label>
            </div>
        </div>
        <!-- Images -->
        <div class="input-field">
            <label class="active">Photos</label>
            <div class="input-images-1" style="padding-top: .5rem;" required></div>
        </div>
        <br>
        <button class="btn btn-outline-success" type="submit">
            <i class="fas fa-check pr-2"></i>
            Finish and Post
        </button>
    </form>
</div>
@endsection

<!--  Scripts  -->
@section('scripts')
<script src="/scripts/image-uploader.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.js"></script>
<script>
    $( document ).ready(function() {
        setTimeout(() => {
        $('.image-uploader [type="file"]').prop('required',true);
    }, 300);
});
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="/libraries/bootstrap-colorselector.js"></script>
<script src="/scripts/sell.js"></script>

@endsection