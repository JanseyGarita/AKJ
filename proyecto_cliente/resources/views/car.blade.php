@extends('layout.layout')

<!--  CSS Imports  -->
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="/styles/car/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
@endsection

<!--  Web page content code  -->
@section('content')
<?php

use Illuminate\Support\Facades\Cookie;

if(!isset($error)){
?>
<div class="bbb_deals_featured" style="left: 0;">
    <div class="container">
        <button class="btn btn-secondary back-btn" id="back-btn"><i class="fas fa-arrow-left"></i></button>
    </div>
    <div class="container" style="left: 0;">
        <div class="row">
            <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-center">
                <!-- bbb_deals -->
                <div class="bbb_deals pt-0">

                    <div class="container-fluid p-0 m-0 pb-4">
                        <div class="row p-0 m-0" style="min-height: 5em;">
                            <div class="bbb_deals_title col-sm-12 col-md-8 py-4">{{ $car->marca." ".$car->modelo}}</div>

                            <div class="bbb_deals_slider_nav_container d-flex col-sm-12 col-md-4 py-4"
                                style="flex-direction: row;">
                                <div id="save-section" class="bbb_deals_item_price_a d-flex justify-content-end"
                                    style="position: relative; left: 50%;">

                                    <?php if (Illuminate\Support\Facades\Cookie::get('user') !== null) { ?>
                                    <form action="{{route('addFavorite')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="vistaUnica" value="1">
                                        <input type="hidden" name="saved" value="{{$isSaved}}">
                                        <input type="hidden" name="id_vehiculo" value="{{$car->id}}">
                                        <input type="hidden" name="id_usuario"
                                            value="<?= json_decode(Illuminate\Support\Facades\Cookie::get('user'))->id ?>">

                                        <button type="submit" class="btn btn-outline-danger"
                                            style="border-radius: 50px; padding: 6px 12px;">
                                            <i class="<?= $isSaved ? 'fas' : 'far' ?> fa-heart"
                                                style="margin-top: 0.4em;"></i>
                                            <!-- Change to fas when it's already added-->
                                        </button>
                                    </form>
                                    <?php } ?>
                                    <p class="m-0 p-0 ml-2" style="margin-top: 0.85em !important;">{{$car->saved}}
                                        people saved</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bbb_deals_slider_container">
                        <!-- bbb_deals Slider -->
                        <div class="bbb_deals_slider_prev bbb_deals_slider_nav">
                            <i class="fas fa-chevron-left ml-auto"></i>
                        </div>
                        <div class="bbb_deals_slider_next bbb_deals_slider_nav">
                            <i class="fas fa-chevron-right ml-auto"></i>
                        </div>
                        <div class="owl-carousel owl-theme bbb_deals_slider">
                            @foreach ($car->images as $image)
                            {{ get_slide($image) }}
                            @endforeach
                        </div>
                        <div class="bbb_deals_content">
                            <div class="bbb_deals_info_line d-flex flex-row justify-content-start px-4">
                                <div class="bbb_deals_item_category">
                                    <a href="#!" class="text-capitalize">category: {{ $car->estilo}}</a>
                                </div>
                                <div class="bbb_deals_item_price_a ml-auto">
                                    Published on: {{ substr($car->creado_en, 0, 10) }}
                                </div>
                            </div>
                            <div class="bbb_deals_info_line d-flex flex-row justify-content-start px-3">
                                <div class="bbb_deals_item_name">{{ $car->modelo . " " . substr($car->año, 0,4) }}</div>
                                <div class="bbb_deals_item_price ml-auto">${{ $car->precio }}</div>
                            </div>
                            <div class="container details-container p-3">
                                <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                    <thead class="cf">
                                        <th>Fuel</th>
                                        <th>Doors</th>
                                        <th>Transmission</th>
                                        <th>Interior Color</th>
                                        <th>Exterior Color</th>
                                        <th>Engine</th>
                                        <th>Negotiable</th>
                                        <th>Swap</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-title="Fuel">{{ $car->combustible }}</td>
                                            <td data-title="Doors">{{ $car->cant_puertas }}</td>
                                            <td data-title="Transmission">{{ $car->transmision }}</td>
                                            <td data-title="Interior Color">{{$car->color_interior }}</td>
                                            <td data-title="Exterior Color">{{$car->color_exterior }}</td>
                                            <td data-title="Engine">{{$car->motor }}</td>
                                            <td data-title="Negotiable">{{ $car->negociable }}</td>
                                            <td data-title="Swap">{{ $car->recibe }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div> <!-- Featured -->
            </div>
        </div>
    </div>
</div>

<div class="container" id="options-container"
    style="<?= (json_decode(Cookie::get('user')) == !null) ? "left:51%" : "" ?>">
    <?php
    $userCookie = json_decode(Cookie::get('user'));
        if ($userCookie == !null) {

        if($userCookie->id==$car->id_usuario){$userCookie
        ?>

    <!-- Cambiar a vendido o no vendido -->
    <form action="" method="/set/Sold" id="form">
        @csrf
        <input type="hidden" name="idCar" value="{{$car->id}}">
    </form>

    <a type="button" class="isSold-btn" id="{{$car->id}}">
        <i class="far <?= $car->vendido ? 'fa-eye-slash' : 'fa-eye' ?>" id="car-{{$car->id}}"></i>
    </a>

    <!--   -slash to change the icon   -->
    <a href="{{route('cars.edit',$car->id)}}" id="edit-btn"><i class="fas fa-edit"></i></a>
    <!--<a href="#!" id="delete-btn" data-toggle="modal" data-target="#deleteForm">
            <i class="fas fa-trash-alt"></i>
        </a>-->
    <a id="delete-btn" data-toggle="modal" data-target="#deleteForm{{$car->id}}">
        <i class="fas fa-trash-alt"></i>
    </a>
    <?php
        }
        }
        ?>

    <?php


        $users = json_decode(Illuminate\Support\Facades\Http::get('http://localhost:52825/api/usuarios'));
        $user = "";
        foreach ($users as $userf) {
            if ($userf->id == $car->id_usuario) {

                $user = $userf;

                break;
            }
        }


        ?>
    <a href="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=http://127.0.0.1:8000/cars/<?= $car->id ?>&display=popup&ref=plugin&src=share_button"
        id="facebook-btn"><i class="fab fa-facebook-f"></i></a>
    <a href="https://wa.me/506<?= $user->telefono ?>?text=Marca:{{$car->marca}}%20Modelo:{{$car->modelo}}%20Año:{{$car->año}}%20Precio:{{$car->precio}}"
        id="whatsapp-btn"><i class="fab fa-whatsapp"></i></a>

    <a href="#!" id="email-btn" data-toggle="modal" data-target="#contactEmail"><i class="far fa-envelope"></i></a>


    <a href="{{route('descargarPDF',$car->id)}}" id="pdf-btn"><i class="far fa-file-pdf"></i></a>
</div>

<!-- Start modal email -->
<div class="modal fade" id="contactEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contact Seller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('contact-seller')}}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="name">Name</label>
                    <input required type="text" name="name" id="name" class="form-control mb-3"
                        value="<?=json_decode(Cookie::get('user'))==null?'':json_decode(Cookie::get('user'))->nombre?>">
                    <label for="phone">Phone</label>
                    <input required type="text" name="phone" id="phone" class="form-control mb-3"
                        value="<?=json_decode(Cookie::get('user'))==null?'':json_decode(Cookie::get('user'))->telefono?>">
                    <label for="mail">Mail</label>
                    <input required type="email" name="mail" id="mail" class="form-control mb-3"
                        value="<?=json_decode(Cookie::get('user'))==null?'':json_decode(Cookie::get('user'))->correo?>">
                    <input type="hidden" name="link" value="http://127.0.0.1:8000/cars/<?=$car->id?>">
                    <input type="hidden" name="forId" value="<?=$car->id_usuario?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- End modal email -->
<div class="modal fade" id="deleteForm{{$car->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteForm"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to permanently delete this post?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{route('cars.destroy',$car->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" data-toggle="modal" data-target="#deleteForm"
                        class="btn btn-danger text-uppercase">
                        <i class="fas fa-trash-alt pr-1" style="padding-top: 5px;"></i>delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
?>
<div class="container-fluid"
    style="position: relative;height: 70vh; background-image: url('/images/404.png');background-position: center;background-size: auto;background-repeat: no-repeat;background-color: #f8fafc;">
    <div class="container pt-4">
        <button class="btn btn-secondary back-btn" id="back-btn"><i class="fas fa-arrow-left"></i></button>
    </div>
</div>
<?php
    }
?>
@endsection

<!--  Javascript Imports  -->
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.js"></script>
<script src="/scripts/car-scripts.js"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".isSold-btn").click(
        function() {
            $.ajax({
                url: '/set/Sold',
                method: 'POST',
                data: $("#form").serialize()
            }).done(
                function(res) {

                    var datax = JSON.parse(res);

                    if (datax.vendido) {
                        $('#car-' + datax.id).removeClass("far fa-eye").addClass("far fa-eye-slash");
                    } else {
                        $('#car-' + datax.id).removeClass("far fa-eye-slash").addClass("far fa-eye");
                    }

                    console.log(datax);
                }
            );

        });
</script>
@endsection

<?php
function get_slide($image)
{
?>
<!-- Car view -->
<div class="owl-item bbb_deals_item">
    <div class="bbb_deals_image">
        <img src="/uploads/cars/{{ $image->url }}" alt="preview" class="img-fluid" style="max-height: 400px;">
    </div>
</div>
<?php
}
?>