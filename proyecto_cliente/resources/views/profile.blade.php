@extends('layout.layout')

<!--  CSS Imports  -->
@section('styles')
<link rel="stylesheet" href="/styles/profile/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
@endsection

<!--  Profile  -->
@section('content')
<input type="hidden" id="default-view" value="<?=(isset($posts)) ? 'container' : 'container1'?>">
<div class="container pt-0 emp-profile">
    <div class="row" style="display: flex; justify-content: flex-end;">
        <button class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteProfileForm"
            id="delete_profile">Delete my profile</button>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="profile-img">
                <form action="{{ route('profile.img.update') }}" method="POST" id="img_form"
                    enctype="multipart/form-data">
                    {{csrf_field()}}
                    <img src="/uploads/users/{{ $user->foto }}" alt="" />
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="user_img" id="user_img" />
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8 pb-0">
            <div class="profile-head">
                <h5 id="profile-name">
                    {{ $user->nombre }}
                </h5>
                <a href="{{ route('log.out') }}" class="btn btn-sm btn-secondary">Logout <i
                        class="fas fa-sign-out-alt"></i></a>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($saved) || isset($posts)) ? '' : 'active' ?>" id="home-tab"
                            data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="true">About</a>
                    </li>
                    <li class="nav-item" id="post">
                        <a class="nav-link <?= ((isset($posts)) ? 'active' : '') ?>" id="profile-tab" data-toggle="tab"
                            href="#profile" role="tab" aria-controls="profile" aria-selected="false">Posts</a>
                    </li>
                    <li class="nav-item" id="saved">
                        <a class="nav-link <?= ((isset($saved)) ? 'active' : '') ?>" id="favourites-tab"
                            data-toggle="tab" href="#favourites" role="tab" aria-controls="favourites"
                            aria-selected="false">Saved</a>
                    </li>

                </ul>
            </div>

            <!--User personal data-->
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade <?= (isset($saved) || isset($posts)) ? '' : 'show active' ?>"
                            id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user-photo" value="{{ $user->foto }}" />
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Full Name:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="user-full-name" id="user-full-name"
                                            value="{{ $user->nombre }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Email: </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" name="user-email" id="user-email"
                                            value="{{ $user->correo }}" required disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Phone: </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="user-phone" id="user-phone"
                                            value="{{ $user->telefono }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Location: </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="user-location" id="user-location"
                                            value="{{ $user->direccion }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Password: </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="user-password" value="{{ $user->contraseña }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-7 mt-3">
                                    <input type="submit" class="profile-edit-btn py-2" value="Save" />
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?= ((isset($posts)) ? 'show active' : '') ?>" id="profile"
                            role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row p-0 m-0 isotope" id="container">
                                @foreach($carsPosted as $car)

                                <?php
                                get_car([
                                
                                    'options' => true,
                                    'car-id' => $car->id,
                                    'type' => $car->estilo,
                                    'model' => $car->modelo,
                                    'make' => $car->marca,
                                    'year' => substr($car->año, 0, 4),
                                    'price' => $car->precio,
                                    'img' => $car->images[0]->url,
                                    'is_sold' => $car->vendido
                                ]);
                                ?>

                                @endforeach()
                            </div>
                        </div>
                        <div class="tab-pane fade <?= (isset($saved)) ? 'show active' : '' ?>" id="favourites"
                            role="tabpanel" aria-labelledby="favourites-tab">

                            <div class="row p-0 m-0 isotope" id="container1">
                                @foreach($carsSaved as $car)

                                <?php
                                        get_car([
                                         
                                        'options' => false,
                                        'car-id' => $car->id,
                                        'type' => $car->estilo,
                                        'model' => $car->modelo,
                                        'make' => $car->marca,
                                        'year' => substr($car->año, 0, 4),
                                        'price' => $car->precio,
                                        'img' => $car->images[0]->url,
                                        'is_sold' => $car->vendido
                                    ]);
                                ?>
                                @endforeach()
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
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
<div class="col-sm-12 col-md-6 col-lg-4 mb-2 car p-0 grid-item" style="min-width: 250px;width: 250px;">
    <div class="card">
        <a href="{{ route('cars.show', $data['car-id']) }}">
            <div class="img-header" style="
            background-image: url('/uploads/cars/<?= $data['img'] ?>');
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
        <?php
            if ($data['options']) {
            ?>

        <button type="submit" data-toggle="modal" data-target="#deleteForm{{$data['car-id']}}" class="btn btn-danger"
            style="position: absolute;right: 110px;
                    top: 168px;">
            <i class="fas fa-trash-alt" style="padding-top: 5px;"></i>
        </button>

        <form action="{{route('cars.edit',$data['car-id'])}}" method="GET">

            <button type="submit" class="btn btn-secondary" style="position: absolute;right: 60px;
                top: 168px;">
                <i class="fas fa-edit" style="padding-top: 5px;"></i>
            </button>
        </form>

        <?php
            }
            ?>
        <?php
            if ($data['options']) {

            ?>
        <form action="" method="/set/Sold" id="form<?= $data['car-id']?>">
            @csrf
            <input type="hidden" name="idCar" value="<?=$data['car-id'] ?>">
        </form>

        <button type="button" class="btn btn-primary isSold-btn" id="<?= $data['car-id'] ?>" style="position: absolute;right: 10px;
                top: 168px;">
            <i class="far <?=$data['is_sold']?'fa-eye-slash':'fa-eye' ?>" id="car-<?= $data['car-id'] ?>"
                style="padding-top: 5px;"></i>
        </button>




        <?php
            } else {
            ?>
        <form method="POST" action="{{route('deleteFav')}}">
            @csrf
            <input type="hidden" name="id_vehiculo" value="<?= $data['car-id'] ?>">
            <input type="hidden" name="id_usuario"
                value="<?= json_decode(Illuminate\Support\Facades\Cookie::get('user'))->id ?>">


            <button type="submit" class="btn btn-danger save-btn" style="position: absolute;top: 168px;">
                <i class="fas fa-heart"></i>
                <!-- Change to fas when it's already added to favourites-->
            </button>
        </form>
        <?php }
            ?>

        <div class="align-items-lg-start text-center text-lg-left flex-column flex-lg-row" style="min-height: 160px;">
            <div class="media-body p-4">
                <h6 class="media-title font-weight-semibold text-capitalize pb-2">
                    <a>
                        <?= $data['make'] . " - " . $data['model'] . " - " . $data['year'] ?>
                    </a>
                </h6>
                <h5 class="font-weight-semibold" style="letter-spacing: 0.06rem;">$<?= $data['price'] ?></h5>
                <p class="list-inline-item text-capitalize m-0">Category: <?= $data['type']; ?>
                </p>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deleteForm{{$data['car-id']}}" tabindex="-1" role="dialog" aria-labelledby="deleteForm"
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
                <form action="{{route('cars.destroy',$data['car-id'])}}" method="post">
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
}
?>
<!-- Delete profile - Modal -->
<div class="modal fade" id="deleteProfileForm" tabindex="-1" role="dialog" aria-labelledby="deleteForm"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i
                        class="fas fa-exclamation-triangle text-danger px-2"></i>Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                Are you sure you want to permanently delete your profile?
                All your information including cars you posted will be permanently deleted.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{route('profile.destroy',json_decode(Cookie::get('user'))->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" data-toggle="modal" data-target="#deleteForm" class="btn btn-danger">
                        <i class="fas fa-trash-alt pr-2" style="padding-top: 5px;"></i>Delete my profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js'>
</script>
<script src="{{asset('/scripts/pagination.js')}}"></script>
<script>
    $('#user_img').on('change', function() {
        $('#img_form').submit();
    });
</script>


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
                data: $("#form" + $(this).attr('id')).serialize()
            }).done(
                function(res) {
                    var datax = JSON.parse(res);
                    if(datax.vendido){
                        $('#car-'+datax.id).removeClass("far fa-eye").addClass("far fa-eye-slash");
                    }else{
                        $('#car-'+datax.id).removeClass("far fa-eye-slash").addClass("far fa-eye");
                    }
                }
            );

        });
</script>



@endsection