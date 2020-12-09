<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <link rel="stylesheet" href="style.css">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


    <title>{{ $car->marca." ".$car->modelo}}</title>



</head>

<body>

    <div class="container" style="text-align: center">

        <h2>{{ $car->marca." ".$car->modelo}}</h2>

    </div>

    <style>
        .info a {
            color: #273c75 !important;
        }
    </style>
    <div class="info" style="padding: 2em 3em;">

        <a href="#!" style="text-align: left" class="text-capitalize">Published on:
            {{ substr($car->creado_en, 0, 10) }}</a><br>
        <a href="#!" class="text-capitalize">Category: {{ $car->estilo}}</a><br>
        <a href="#!" class="text-capitalize">Model: {{ $car->modelo . " " . substr($car->año, 0,4) }}</a><br>
        <a href="#!" class="text-capitalize">Price: ${{ $car->precio }}</a><br>

        <a href="#!" class="text-capitalize">Name: {{ $user->nombre }}</a><br>
        <a href="#!" class="">Email: {{ $user->correo}}</a><br>
        <a href="#!" class="text-capitalize">Phone: {{ $user->telefono }}</a><br>
        <a href="#!" class="text-capitalize">Address: {{ $user->direccion }}</a><br>

    </div>
    <div class="contaner">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Fuel</th>
                    <th>Doors</th>
                    <th>Transmission</th>
                    <th>Interior Color</th>
                    <th>Exterior Color</th>
                    <th>Negotiable</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td data-title="Fuel">{{ $car->combustible }}</td>
                    <td data-title="Doors">{{ $car->cant_puertas }}</td>
                    <td data-title="Transmission">{{ $car->transmision }}</td>
                    <td data-title="Interior Color">{{$car->color_interior }}</td>
                    <td data-title="Exterior Color">{{$car->color_exterior }}</td>
                    <td data-title="Negotiable">{{ $car->negociable }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="container" style="padding:2em 0; ">
        @foreach ($car->images as $image)
        <br style="padding: 2em">
        <img style="position: relative" src="./uploads/cars/{{ $image->url }}">
        <br>
        @endforeach
    </div>



</body>

</html>