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
<input type="hidden" id="isUpdate" value="true">
<div class="container-fluid form-container p-4">
    <form method="POST" action="{{route('cars.update',$car->id)}}" name="sell-form" enctype="multipart/form-data"
        class="p-5">
        {{csrf_field()}}
        @method('PUT')

        <input type="hidden" name="issold" value="{{$car->vendido}}">
        <input type="hidden" name="created_on" value="{{$car->creado_en}}">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <!--Price-->
                <div class="form-group float-label-control label-bottom">
                    <label for="title">Price</label>
                    <input type="number" class="form-control" value="{{$car->precio}}" min="0" id="price" name="price"
                        required>
                </div>
                <!--Make-->
                <div class="form-group float-label-control label-bottom makes-input-container">
                    <label for="makes-input">Make</label>
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input type="hidden" id="default_make" value="{{$car->marca}}">
                                <select class="form-control selectpicker" id="makes-input" name="make"
                                    data-live-search="true" required>
                                    <option value="{{$car->marca}}" selected>{{$car->marca}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Model-->
                <div class="form-group float-label-control label-bottom models-input-container">
                    <label for="models-container">Model</label>
                    <input type="hidden" id="default_model" value="{{$car->modelo}}">
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query" id="models-container">
                                
                                <select class="form-control selectpicker" id="models-input" name="model"
                                    data-live-search="true" required>
                                    <option value="{{$car->modelo}}" selected>{{$car->modelo}}</option>

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
                                <input type="number" min="1960" max="2024" value="{{$car->año}}" class="form-control"
                                    id="year" name="year" required>
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
                                                <option value="SUV" <?=($car->estilo == "SUV")? 'selected':''?>>SUV
                                                </option>
                                                <option value="Truck" <?=($car->estilo == "Truck")? 'selected':''?>>
                                                    Truck</option>
                                                <option value="Crossover"
                                                    <?=($car->estilo == "Crossover")? 'selected':''?>>Crossover</option>
                                                <option value="Sedan" <?=($car->estilo == "Sedan")? 'selected':''?>>
                                                    Sedan</option>
                                                <option value="Coupe" <?=($car->estilo == "Coupe")? 'selected':''?>>
                                                    Coupe</option>
                                                <option value="Sport" <?=($car->estilo == "Sport")? 'selected':''?>>
                                                    Sport</option>
                                                <option value="Convertible"
                                                    <?=($car->estilo == "Convertible")? 'selected':''?>>Convertible
                                                </option>
                                                <option value="Luxury" <?=($car->estilo == "Luxury")? 'selected':''?>>
                                                    Luxury</option>
                                                <option value="Diesel" <?=($car->estilo == "Diesel")? 'selected':''?>>
                                                    Diesel</option>
                                                <option value="Van" <?=($car->estilo == "Van")? 'selected':''?>>Van
                                                </option>
                                                <option value="Electric"
                                                    <?=($car->estilo == "Electric")? 'selected':''?>>Electric</option>
                                                <option value="Hybrid" <?=($car->estilo == "Hybrid")? 'selected':''?>>
                                                    Hybrid</option>
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
                        <option value="M" <?=($car->transmision == "M")? 'selected':''?>>Manual</option>
                        <option value="A" <?=($car->transmision == "A")? 'selected':''?>>Automatic</option>
                    </select>
                </div>
                <!--Fuel type-->
                <div class="form-group float-label-control label-bottom">
                    <label for="fuel">Fuel</label>
                    <select class="form-control" id="fuel" name="fuel">
                        <option value="G" <?=($car->combustible == "G")? 'selected':''?>>Gasoline</option>
                        <option value="D" <?=($car->combustible == "D")? 'selected':''?>>Diesel</option>
                        <option value="E" <?=($car->combustible == "E")? 'selected':''?>>Electric</option>
                    </select>
                </div>
                <!--Doors-->
                <div class="form-group float-label-control label-bottom">
                    <label for="doors">Doors</label>
                    <input type="number" min="0" max="10" class="form-control" value="{{$car->cant_puertas}}" id="title"
                        name="doors" required>
                </div>
                <!--Cylinders-->
                <div class="form-group float-label-control label-bottom">
                    <label for="cylinders">Cylinders</label>
                    <input type="number" min="0" class="form-control" value="{{$car->motor}}" id="title" name="motor"
                        required>
                </div>
                <!--Car Colors-->
                <div class="form-group float-label-control label-bottom py-2">
                    <div class="row">
                        <!--Interior Color-->
                        <div class="col-sm-12 col-md-6">
                            <label for="interior-color">Interior Color</label>
                            <select class="form-control color-picker" id="interior-color" name="incolor">
                                <option value="White" <?=($car->color_interior == "White")? 'selected="selected"':''?>
                                    data-color="#fff">White</option>
                                <option value="Red" <?=($car->color_interior == "Red")? 'selected="selected"':''?>
                                    data-color="#ed0000">Red</option>
                                <option value="Blue" <?=($car->color_interior == "Blue")? 'selected="selected"':''?>
                                    data-color="#030bff">Blue</option>
                                <option value="Black" <?=($car->color_interior == "Black")? 'selected="selected"':''?>
                                    data-color="#000">Black</option>
                                <option value="Orange" <?=($car->color_interior == "Orange")? 'selected="selected"':''?>
                                    data-color="#ff5703">Orange</option>
                                <option value="Yellow" <?=($car->color_interior == "Yellow")? 'selected="selected"':''?>
                                    data-color="#ffd000">Yellow</option>
                                <option value="Green" <?=($car->color_interior == "Green")? 'selected="selected"':''?>
                                    data-color="#229c1c">Green</option>
                                <option value="Turquoise"
                                    <?=($car->color_interior == "Turquoise")? 'selected="selected"':''?>
                                    data-color="#43e8d8">Turquoise</option>
                                <option value="Gray" <?=($car->color_interior == "Gray")? 'selected="selected"':''?>
                                    data-color="#636e72">Gray</option>
                                <option value="Brown" <?=($car->color_interior == "Brown")? 'selected="selected"':''?>
                                    data-color="#83502e">Brown</option>
                            </select>
                        </div>
                        <!--Exterior Color-->
                        <div class="col-sm-12 col-md-6">
                            <label for="exterior-color">Exterior Color</label>
                            <select class="form-control color-picker" id="exterior-color" name="excolor">
                                <option value="White" <?=($car->color_exterior == "White")? 'selected="selected"':''?>
                                    data-color="#fff">White</option>
                                <option value="Red" <?=($car->color_exterior == "Red")? 'selected="selected"':''?>
                                    data-color="#ed0000">Red</option>
                                <option value="Blue"
                                    <?=($car->color_exterior == "Blue")? 'selected="selected"':''?>data-color="#030bff">
                                    Blue</option>
                                <option value="Black"
                                    <?=($car->color_exterior == "Black")? 'selected="selected"':''?>data-color="#000">
                                    Black</option>
                                <option value="Orange" <?=($car->color_exterior == "Orange")? 'selected="selected"':''?>
                                    data-color="#ff5703">Orange</option>
                                <option value="Yellow" <?=($car->color_exterior == "Yellow")? 'selected="selected"':''?>
                                    data-color="#ffd000">Yellow</option>
                                <option value="Green" <?=($car->color_exterior == "Green")? 'selected="selected"':''?>
                                    data-color="#229c1c">Green</option>
                                <option value="Turquoise"
                                    <?=($car->color_exterior == "Turquoise")? 'selected="selected"':''?>
                                    data-color="#43e8d8">Turquoise</option>
                                <option value="Gray" <?=($car->color_exterior == "Gray")? 'selected="selected"':''?>
                                    data-color="#636e72">Gray</option>
                                <option value="Brown" <?=($car->color_exterior == "Brown")? 'selected="selected"':''?>
                                    data-color="#83502e">Brown</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Conditions -->
        <div class="row pb-4">
            <div class="col-sm-4 col-md-4">
                <input type="checkbox" name="negotiable" {{$car->negociable?'checked' : ''}}>
                <label for="vehicle1"> Is Negotiable?</label>
            </div>
            <div class="col-sm-4 col-md-4">
                <input type="checkbox" name="swap" {{($car->recibe)?'checked' : ''}}>
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
            Finish and Update
        </button>
    </form>
</div>
@endsection

<!--  Scripts  -->
@section('scripts')
<script>
    (function ($) {
    $.fn.imageUploader = function (options) {
        var array =  {!! json_encode($car_images) !!};
        cars = [];
        array.forEach(image => {
            cars.push(
                {
                    id: image.id_imagen,
                    src: '/uploads/cars/'+image.url
                }
            );
        });
        let defaults = {
            preloaded: cars,
            imagesInputName: "images",
            preloadedInputName: "preloaded",
            label: "Drag & Drop files here or click to browse",
        };
        let plugin = this;
        plugin.settings = {};
        plugin.init = function () {
            plugin.settings = $.extend(plugin.settings, defaults, options);
            plugin.each(function (i, wrapper) {
                let $container = createContainer();
                $(wrapper).append($container);
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));
                if (plugin.settings.preloaded.length) {
                    $container.addClass("has-files");
                    let $uploadedContainer = $container.find(".uploaded");
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(
                            createImg(
                                plugin.settings.preloaded[i].src,
                                plugin.settings.preloaded[i].id,
                                !0
                            )
                        );
                    }
                }
            });
        };
        let dataTransfer = new DataTransfer();
        let createContainer = function () {
            let $container = $("<div>", { class: "image-uploader" }),
                $input = $("<input>", {
                    type: "file",
                    id: plugin.settings.imagesInputName + "-" + random(),
                    name: plugin.settings.imagesInputName + "[]",
                    multiple: "",
                }).appendTo($container),
                $uploadedContainer = $("<div>", { class: "uploaded" }).appendTo(
                    $container
                ),
                $textContainer = $("<div>", { class: "upload-text" }).appendTo(
                    $container
                ),
                $i = $("<i>", {
                    class: "material-icons",
                    text: "cloud_upload",
                }).appendTo($textContainer),
                $span = $("<span>", { text: plugin.settings.label }).appendTo(
                    $textContainer
                );
            $container.on("click", function (e) {
                prevent(e);
                $input.trigger("click");
            });
            $input.on("click", function (e) {
                e.stopPropagation();
            });
            $input.on("change", fileSelectHandler.bind($container));
            return $container;
        };
        let prevent = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };
        let createImg = function (src, id) {
            let $container = $("<div>", { class: "uploaded-image" }),
                $img = $("<img>", { src: src }).appendTo($container),
                $button = $("<button>", { class: "delete-image" }).appendTo(
                    $container
                ),
                $i = $("<i>", {
                    class: "material-icons",
                    text: "clear",
                }).appendTo($button);
            if (plugin.settings.preloaded.length) {
                $container.attr("data-preloaded", !0);
                let $preloaded = $("<input>", {
                    type: "hidden",
                    name: plugin.settings.preloadedInputName + "[]",
                    value: id,
                }).appendTo($container);
            } else {
                $container.attr("data-index", id);
            }
            $container.on("click", function (e) {
                prevent(e);
            });
            $button.on("click", function (e) {
                prevent(e);
                if ($container.data("index")) {
                    let index = parseInt($container.data("index"));
                    $container
                        .find(".uploaded-image[data-index]")
                        .each(function (i, cont) {
                            if (i > index) {
                                $(cont).attr("data-index", i - 1);
                            }
                        });
                    dataTransfer.items.remove(index);
                }
                $container.remove();
                if (!$container.find(".uploaded-image").length) {
                    $container.removeClass("has-files");
                }
            });
            return $container;
        };
        let fileDragHover = function (e) {
            prevent(e);
            if (e.type === "dragover") {
                $(this).addClass("drag-over");
            } else {
                $(this).removeClass("drag-over");
            }
        };
        let fileSelectHandler = function (e) {
            prevent(e);
            let $container = $(this);
            $container.removeClass("drag-over");
            let files = e.target.files || e.originalEvent.dataTransfer.files;
            setPreview($container, files);
        };
        let setPreview = function ($container, files) {
            $container.addClass("has-files");
            let $uploadedContainer = $container.find(".uploaded"),
                $input = $container.find('input[type="file"]');
            $(files).each(function (i, file) {
                dataTransfer.items.add(file);
                $uploadedContainer.append(
                    createImg(
                        URL.createObjectURL(file),
                        dataTransfer.items.length - 1
                    )
                );
            });
            $input.prop("files", dataTransfer.files);
        };
        let random = function () {
            return Date.now() + Math.floor(Math.random() * 100 + 1);
        };
                this.init();
                return this;
            };
        })(jQuery);

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="/libraries/bootstrap-colorselector.js"></script>
<script src="/scripts/sell.js"></script>

@endsection