@extends('layout.layout')

<!--  CSS Imports  -->
@section('styles')
<link rel="stylesheet" href="/styles/cars/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<!--Plugin CSS file with desired skin-->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/css/bootstrap-slider.min.css">
@endsection

<!--  Web page content code  -->
@section('content')
<!-- Cars on sale Section  -->

<div class="container-fluid p-3 pt-5 d-flex justify-content-center ">
    <div class="row" style="position: relative; left: 0; width: 100%;">
        <div class="col-sm-12 col-md-4 col-lg-3 filters-container p-2 pl-3 pr-4">
            <!-- Accordion -->
            <div class="container-fluid bg-gray" id="accordion-style-1" style="position: relative;">
                <div class="container" style="position: relative;">
                    <section style="position: relative;">
                        <div class="row p-0" id="filters-row">

                            <div class="col-12 p-0">
                                <h5 class="text-green mb-4 text-center">Filter cars</h5>
                                <div class="accordion filters" id="accordionFilters">
                                    <!-- FILTERS -->
                                    <!--Car make - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading1">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse1"
                                                    aria-expanded="false" aria-controls="collapse1">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Make
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse1" class="collapse fade" aria-labelledby="headingOne"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group makes-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll"
                                                    data-filter-group="make">

                                                    <div class="btn-groupp" data-filter-group="style" style="position: relative;
                                                            width: 100%;
                                                            display: inline-grid;
                                                            justify-content: center;
                                                            align-items: center;">

                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="make">Any</span>
                                                        @foreach($makes as $make)
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            btn-filter="make"
                                                            data-filter=".b-{{strtolower(str_replace(' ', '', $make))}}"
                                                            value="b-{{strtolower($make)}}">
                                                            {{$make}}</span>
                                                        @endforeach

                                                    </div>

                                                </div>
                                                </>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car style - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading2">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse2"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Type
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse2" class="collapse fade" aria-labelledby="heading2"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group types-container mt-3 p-2"
                                                    data-filter-group="style"
                                                    style="max-height: 25vh; overflow-y: scroll;">

                                                    <div class="btn-groupp" data-filter-group="type" style="position: relative;
                                                                                            width: 100%;
                                                                                            display: inline-grid;
                                                                                            justify-content: center;
                                                                                            align-items: center;">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="type">Any</span>

                                                        @foreach($styles as $style)
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".s-{{strtolower($style)}}" btn-filter="type"
                                                            value=".s-{{strtolower($style)}}">
                                                            {{$style}}</span>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Price - working-->
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse3"
                                                    aria-expanded="false" aria-controls="collapse3">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Price
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse3" class="collapse fade" aria-labelledby="headingThree"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="bootstrap-slider">
                                                    <span class="row filter-label pl-2"
                                                        style="position: relative; width: 100%;">Range:
                                                        <span class="filter-selection px-1"> </span>
                                                    </span>
                                                    <b class="filter-min">800</b> <input id="filter-price" type="text"
                                                        class="bootstrap-slider" value="" data-filter-group="price"> <b
                                                        class="filter-max">200000</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Year - working-->
                                    <div class="card">
                                        <div class="card-header" id="headingFour">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse4"
                                                    aria-expanded="false" aria-controls="collapse4">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Year
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse4" class="collapse fade" aria-labelledby="headingFour"
                                            data-parent="#accordionFilters">
                                            <div class="card-body sliders">
                                                <div class="bootstrap-slider">
                                                    <span class="row filter-label px-2"
                                                        style="position: relative; width: 100%;">Range:
                                                        <span class="filter-selection px-1"> </span>
                                                    </span>
                                                    <b class="filter-min">1990</b> <input id="filter-year" type="text"
                                                        class="bootstrap-slider" value="" data-filter-group="year"> <b
                                                        class="filter-max">2020</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car transmission - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse5"
                                                    aria-expanded="false" aria-controls="collapse5">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Transmission
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse5" class="collapse fade" aria-labelledby="headingFive"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group transmission-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll">
                                                    <div class="btn-groupp" data-filter-group="transmission" style="position: relative;
                                                            width: 100%;
                                                            display: inline-grid;
                                                            justify-content: center;
                                                            align-items: center;">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="transmission">Any
                                                        </span>
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".t-automatic"
                                                            btn-filter="transmission">Automatic
                                                        </span>
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".t-manual" btn-filter="transmission">Manual
                                                        </span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car Fuel Type - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse6"
                                                    aria-expanded="false" aria-controls="collapse6">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Fuel
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse6" class="collapse fade" aria-labelledby="headingSix"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group fuel-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll">
                                                    <div class="btn-groupp" data-filter-group="fuel" style="
                                                        position: relative;
                                                        width: 100%;
                                                        display: inline-grid;
                                                        justify-content: center;
                                                        align-items: center;
                                                    ">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="fuel">Any
                                                        </span>
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".f-gasoline" btn-filter="fuel">Gasoline
                                                        </span>
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".f-diesel" btn-filter="fuel">Diesel
                                                        </span>
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".f-electric" btn-filter="fuel">Electric
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car Cylinders - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse7"
                                                    aria-expanded="false" aria-controls="collapse7">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Car engine
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse7" class="collapse fade" aria-labelledby="headingSeven"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group cylinders-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll">
                                                    <div class="btn-groupp" data-filter-group="cylinders"
                                                        style="position: relative; width: 100%; display: inline-grid; justify-content: center; align-items: center;">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="engine">Any
                                                        </span>
                                                        @foreach($motors as $motor)
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".c-{{$motor}}" btn-filter="engine" F>
                                                            {{$motor}}
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car doors - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading8">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse8"
                                                    aria-expanded="false" aria-controls="collapse8">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Doors
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse8" class="collapse fade" aria-labelledby="headingEight"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group doors-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll">
                                                    <div class="btn-groupp" data-filter-group="doors"
                                                        style="position: relative; width: 100%; display: inline-grid; justify-content: center; align-items: center;">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="doors">Any
                                                        </span>
                                                        @foreach($doors as $door)
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".d-{{$door}}" btn-filter="doors">
                                                            {{$door}}
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car Interior color - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading9">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse9"
                                                    aria-expanded="false" aria-controls="collapse9">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Interior color
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse9" class="collapse fade" aria-labelledby="headingNine"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group in-color-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll">
                                                    <div class="btn-groupp" data-filter-group="interior_color"
                                                        style="position: relative; width: 100%;">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="internal_color">Any
                                                        </span>
                                                        @foreach($inColors as $incolor)
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".ic-{{strtolower($incolor['color'])}}"
                                                            btn-filter="internal_color"
                                                            style="width: 32px; height: 32px; background-color: {{$incolor['hex']['hex_color']}}">
                                                        </span>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Car Exterior color - working -->
                                    <div class="card">
                                        <div class="card-header" id="heading10">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed btn-block text-left filter-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapse10"
                                                    aria-expanded="false" aria-controls="collapse10">
                                                    <i class="fas fa-chevron-right"></i>
                                                    Exterior color
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse10" class="collapse fade" aria-labelledby="headingTen"
                                            data-parent="#accordionFilters">
                                            <div class="card-body">
                                                <div class="button-group in-color-container mt-3 p-2"
                                                    style="max-height: 25vh; overflow-y: scroll">
                                                    <div class="btn-groupp" data-filter-group="exterior_color"
                                                        style="position: relative; width: 100%;">
                                                        <span class="btn btn-sm btn-default btn-filter is-checked"
                                                            data-filter="" btn-filter="external_color">Any
                                                        </span>
                                                        @foreach($exColors as $excolor)
                                                        <span class="btn btn-sm btn-default btn-filter"
                                                            data-filter=".ec-{{strtolower($excolor['color'])}}"
                                                            btn-filter="external_color"
                                                            style="width: 32px; height: 32px; background-color: {{$excolor['hex']['hex_color']}}">
                                                        </span>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </section>
                </div>
            </div>
            <!-- .// Accordion -->
        </div>
        <div class="col-sm-12 col-md-8 col-lg-9 autos-section"
            style="min-height: 200px; position: relative;">
        <div class="row autos-container" id="autos-container" style="position: relative; width: 100%;">
            <?=$saved=false;?>

            @foreach($cars as $car)
            <?php if(!$car->vendido){?>
            <?=$saved=false?>
            @foreach($carsSaved as $carSaved)

            <?php
            if($car->id==$carSaved->id){
            $saved =true;
            }?>
            @endforeach

            <?php
            

get_car([       'car-saved'=>$saved,
                'car-id' => $car->id, 'type' => $car->estilo,
                 'model' => $car->modelo, 'make' => $car->marca, 
                 'year' => substr($car->año, 0, 4),
                'price' => $car->precio,
                'transmission' => $car->transmision == 'M' ? 'Manual' : 'Automatic',
                'fuel' => get_combustible($car->combustible), 
                'cylinders' => $car->motor,
                 'doors' => $car->cant_puertas,
                'in-color' => $car->color_interior,
                 'ex-color' => $car->color_exterior, 
                 'img' => $car->images[0]->url
            ]);
            ?>
            <?php }?>
            @endforeach
        </div>

    </div>

</div>
</div>

@endsection

<!--  Javascript Imports  -->
@section('scripts')
<!--ION Range Slider-->
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
-->
<script src="https://npmcdn.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/bootstrap-slider.js"></script>
<script src="/scripts/cars-scripts.js"></script>
<script src="/scripts/filters.js"></script>

<script>
    $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
     }
 }); 

$(".save-btn").click(
    function () {
        $.ajax({
            url: '/add/favorite',
            method: 'POST',
            data:$("#form"+$(this).attr('id')).serialize()
        }).done(
            function(res){
                console.log(res);
            }
        );

});


</script>

@endsection

<?php

function get_combustible($c)
{
    switch ($c) {
        case 'G':
            return 'Gasoline';
            break;
        case 'D':
            return 'Diesel';
            break;
        case 'E':
            return 'Electric';
            break;
    }
}

function get_car($data)
{
?>
<div class="col-sm-12 col-md-6 col-lg-3 mb-2 car p-0 <?= "b-".strtolower(str_replace(' ', '', $data['make'])." s-".$data['type']." t-".$data['transmission'].
" f-".$data['fuel']." c-".$data['cylinders']." d-".$data['doors']." ic-".$data['in-color']." ec-".$data['ex-color']);?>"
    data-year="<?=$data['year']?>" data-price="<?=$data['price']?>" style="min-width: 250px;">
    <div class="card">
        <a href="{{ route('cars.show', $data['car-id']) }}">
            <div class="img-header" style="
            background-image: url('/uploads/cars/<?=$data['img']?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 190px;
            ">
                <p class="text-white text-uppercase"
                    style="position: absolute; top:24%; left: 45%; z-index: 2; font-size: 2em">
                    <i class="far fa-eye"></i>
                </p>
            </div>
        </a>

        <form method="POST" action="/add/favorite" id="form<?=$data['car-id']?>">
            @csrf
            <input type="hidden" name="saved" value="<?=$data['car-saved']?>">
            <input type="hidden" name="id_vehiculo" value="<?=$data['car-id']?>">
            <input type="hidden" name="id_usuario"
                value="<?=Cookie::get('user')==null?'':json_decode(Cookie::get('user'))->id?>">
        </form>

        <?php if(Cookie::get('user')!==null){?>
        <button type="button" class="btn btn-danger mt-2 save-btn" id="<?=$data['car-id']?>"
            style="position: absolute;">
            <i class="<?=$data['car-saved']?'fas':'far'?> fa-heart"></i>
        </button>
        <?php }?>
        <div class="align-items-lg-start text-center text-lg-left flex-column flex-lg-row" style="min-height: 160px;">
            <div class="media-body p-4">
                <h6 class="media-title font-weight-semibold text-capitalize pb-2">
                    <a>
                        <?=$data['make'] . " - " . $data['model'] . " - " . $data['year']?>
                    </a>
                </h6>
                <h5 class="font-weight-semibold" style="letter-spacing: 0.06rem;">$<?=$data['price']?></h5>

                <p class="list-inline-item text-capitalize m-0">Category: <?=$data['type'];?>
                </p>
            </div>
        </div>

    </div>
</div>
<?php
}

?>