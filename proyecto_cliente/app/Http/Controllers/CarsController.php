<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $URL_API;
    public function __construct()
    {
        $this->URL_API = "http://localhost:52825/api";
    }

    public function index()
    {
        $carsRes = Http::get($this->URL_API . "/vehiculosofrecidos");
        $makesRes = Http::get($this->URL_API . "/marcas");
        $stylesRes = Http::get($this->URL_API . "/estilos");
        $images = Http::get($this->URL_API . '/imagenes');

        $cars = $this->getCarsWithImages(json_decode($carsRes));
        $makes = $this->getMakes($cars);
        $styles = $this->getTypes($cars);
        $motors = $this->getEngines($cars);
        $doors = $this->getDoors($cars);
        $exColors = $this->getExColors($cars);
        $inColors = $this->getInColors($cars);
        $active = 'buy';
        $carsSaved = $this->getCarsSaved();
        return view(
            'cars',
            compact(
                'cars',
                'active',
                'makes',
                'styles',
                'motors',
                'doors',
                'exColors',
                'inColors',
                'images',
                'carsSaved'
            )
        );
    }

    public function getCarsSaved()
    {
        $carsSaved = [];
        $resCars = Http::get('http://localhost:52825/api/vehiculosofrecidos');
        $resSaved = Http::get('http://localhost:52825/api/vehiculosdeseados');
        $cars = json_decode($resCars);
        $saved = json_decode($resSaved);
        $user = json_decode(Cookie::get('user'));
        if (null !== $user) {
            foreach ($cars as $car) {
                foreach ($saved as $save) {
                    if ($car->id == $save->id_vehiculo) {
                        if ($save->id_usuario == $user->id) {
                            array_push($carsSaved, $car);
                        }
                    }
                }
            }
        }
        return $carsSaved;
    }

    public function getCantDeseadosByid($idcar)
    {
        $res = Http::get($this->URL_API . '/vehiculosdeseados');
        $deseados = json_decode($res);
        $cantidad = 0;
        foreach ($deseados as $deseado) {
            if ($deseado->id_vehiculo == $idcar) {
                $cantidad++;
            }
        }
        return $cantidad;
    }

    public function getCarsWithImages($cars)
    {
        if (gettype($cars) == 'array') {
            foreach ($cars as $car) {
                $car->images = $this->getImagesByIdCar($car->id);
                $car->saved = $this->getCantDeseadosByid($car->id);
            }
        } else {
            $cars->images = $this->getImagesByIdCar($cars->id);
            $cars->saved = $this->getCantDeseadosByid($cars->id);
        }
        return  $cars;
    }

    function getImagesByIdCar($id)
    {
        $res = Http::get($this->URL_API . '/imagenes' . '/' . $id);
        return json_decode($res);
    }


    function getExColors($cars)
    {
        $colors = [];
        foreach ($cars as $car) {
            $hex_color = Http::get($this->URL_API . "/colores" . "/" . $car->color_exterior);
            $current_color = ['color' => $car->color_exterior, 'hex' => $hex_color];
            if (!$this->color_exists($colors, $current_color) && (!$car->vendido)) array_push($colors, $current_color);
        }
        //$colors = array_unique($colors);

        return $colors;
    }

    function getInColors($cars)
    {
        $colors = [];
        foreach ($cars as $car) {
            $hex_color = Http::get($this->URL_API . "/colores" . "/" . $car->color_interior);
            $current_color = ['color' => $car->color_interior, 'hex' => $hex_color];
            if (!$this->color_exists($colors, $current_color) && (!$car->vendido)) array_push($colors, $current_color);
        }

        //$colors = array_unique($colors);

        return $colors;
    }

    function color_exists($colors, $current_color)
    {
        foreach ($colors as $color) {
            if ($color['color'] == $current_color['color']) {
                return true;
            }
        }
        return false;
    }


    function getDoors($cars)
    {
        $doors = [];
        foreach ($cars as $car) {
            array_push($doors, $car->cant_puertas);
        }
        $doors = array_unique($doors);
        sort($doors);
        return $doors;
    }

    function getEngines($cars)
    {
        $engines = [];
        foreach ($cars as $car) {
            if (!$car->vendido) array_push($engines, $car->motor);
        }
        $engines = array_unique($engines);
        sort($engines);
        return $engines;
    }
    function getTypes($cars)
    {
        $types = [];
        foreach ($cars as $car) {
            if (!$car->vendido) array_push($types, $car->estilo);
        }
        $types = array_unique($types);
        sort($types);
        return $types;
    }
    function getMakes($cars)
    {
        $makes = [];
        foreach ($cars as $car) {
            if (!$car->vendido) array_push($makes, $car->marca);
        }
        $makes = array_unique($makes);
        sort($makes);
        return $makes;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (null !== Cookie::get('user')) {
            $respuesta = Http::post($this->URL_API . '/vehiculosofrecidos', [
                "precio" => $request->price,
                "año" => $request->year,
                "combustible" => $request->fuel,
                "cant_puertas" => $request->doors,
                "transmision" => $request->transmission,
                "negociable" => $request->negotiable == null ? false : true,
                "recibe" => $request->swap == null ? false : true,
                "vendido" => false,
                "id_marca" => $this->getMarca($request->make)->id,
                "id_color_exterior" => $this->getColor($request->excolor)->id,
                "id_color_interior" => $this->getColor($request->incolor)->id,
                "id_modelo" => $this->getModelo($request->model)->id,
                "id_estilo" => $this->getEstilo($request->type)->id,
                "id_motor" => $this->getMotor($request->motor)->id,
                "id_usuario" => json_decode(Cookie::get('user'))->id
            ]);

            $carsRes = json_decode(Http::get($this->URL_API . "/vehiculosofrecidos"));
            $id_vehiculo = $carsRes[count($carsRes) - 1]->id;
            if ($files = $request->file('images')) {
                $this->upload_images($files, $id_vehiculo);
            }
            return back();
        } else {
            return redirect()->route('login');
        }
    }

    function upload_images($files, $id_vehiculo)
    {
        foreach ($files as $file) {
            $time = date('d_m_Y_His');
            $name = $time . "_" . $file->getClientOriginalName();
            $result = $file->move('uploads/cars/', $name);
            $res = Http::post($this->URL_API . '/imagenes', [
                "url" => $name,
                "id_vehiculo" => $id_vehiculo
            ]);
        }
    }

    function getEstilo($nombre)
    {
        $res = Http::get($this->URL_API . '/estilos' . '/' . $nombre);
        return json_decode($res);
    }
    function getMotor($cilindraje)
    {
        $res = Http::get($this->URL_API . '/motores' . '/' . $cilindraje);
        return json_decode($res);
    }

    function getColor($color)
    {
        $res = Http::get($this->URL_API . '/colores' . '/' . $color);
        return json_decode($res);
    }

    function getModelo($nombre)
    {
        $res = Http::get($this->URL_API . '/modelos' . '/' . $nombre);
        return json_decode($res);
    }
    function getMarca($nombre)
    {
        $res = Http::get($this->URL_API . '/marcas' . '/' . $nombre);
        return json_decode($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCar($id)
    {
        $usuarios = Http::get($this->URL_API . '/usuarios');
        $usuarios = json_decode($usuarios);
        foreach ($usuarios as $user) {
            if ($user->id == $id) {

                return $user;

                break;
            }
        }
        return false;
    }
    public function carPDF($id)
    {
        $resp = Http::get($this->URL_API . "/vehiculosofrecidos" . "/" . $id);
        $car = $this->getCarsWithImages(json_decode($resp));
        $car = $this->get_table_real_values($car);
        $user = $this->userCar($car->id_usuario);

        $pdf = \PDF::loadView('carPDF', ['active' => 'buy', 'car' => $car, 'user' => $user]);
        return $pdf->setPaper('a4', 'landscape')->stream('car.pdf');
    }

    public function show($id)
    {
        $resp = Http::get($this->URL_API . "/vehiculosofrecidos" . "/" . $id);
        if (json_decode($resp) != null) {
            $car = $this->getCarsWithImages(json_decode($resp));
            $car = $this->get_table_real_values($car);
            $user = $this->userCar($car->id_usuario);
            $isSaved = $this->isSavedForThisUser($car->id);
            return view('car', ['active' => 'buy', 'car' => $car, 'user' => $user, 'isSaved' => $isSaved]);
        } else {
            return view('car', ['active' => 'buy','error' => true]);
        }
    }


    public function isSavedForThisUser($idCar)
    {
        $is = false;
        foreach ($this->getCarsSaved() as $car) {
            if ($car->id == $idCar) {
                $is = true;
                break;
            }
        }
        return $is;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $active = 'sell';
        $resp = Http::get($this->URL_API . "/vehiculosofrecidos" . "/" . $id);
        $car = $this->getCarsWithImages(json_decode($resp));
        $car_images = $car->images;
        return view('editCar', compact('car', 'active', 'car_images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (null !== Cookie::get('user')) {

            if (isset($request->all()['preloaded'])) {
                $this->update_images($request->all()['preloaded'], $id);
            } else {
                $this->update_images([], $id);
            }

            $result = Http::put($this->URL_API . '/vehiculosofrecidos' . '/' . $id, [
                "id" => (int) $id,
                "precio" => $request->price,
                "año" => $request->year,
                "combustible" => $request->fuel,
                "cant_puertas" => $request->doors,
                "transmision" => $request->transmission,
                "negociable" => $request->negotiable == null ? false : true,
                "creado_en" => $request->created_on,
                "recibe" => $request->swap == null ? false : true,
                "vendido" => $request->issold == 1 ? true : false,
                "id_marca" => $this->getMarca($request->make)->id,
                "id_color_exterior" => $this->getColor($request->excolor)->id,
                "id_color_interior" => $this->getColor($request->incolor)->id,
                "id_modelo" => $this->getModelo($request->model)->id,
                "id_estilo" => $this->getEstilo($request->type)->id,
                "id_motor" => $this->getMotor($request->motor)->id,
                "id_usuario" => json_decode(Cookie::get('user'))->id
            ]);
            if ($files = $request->file('images')) {
                $this->upload_images($files, (int) $id);
            }
            return redirect()->route('profile');
        } else {
            return redirect()->route('login');
        }
    }



    public function setSold(Request $request)
    {
        $resp = Http::get($this->URL_API . "/vehiculosofrecidos" . "/" . $request->idCar);
        $car = json_decode($resp);

        $vendido = $car->vendido ? false : true;

        $result = Http::put($this->URL_API . '/vehiculosofrecidos' . '/' . $car->id, [
            "id" => $car->id,
            "precio" => $car->precio,
            "año" => $car->año,
            "combustible" => $car->combustible,
            "cant_puertas" => $car->cant_puertas,
            "transmision" => $car->transmision,
            "negociable" => $car->negociable,
            "creado_en" => $car->creado_en,
            "recibe" => $car->recibe,
            "vendido" => $vendido,
            "id_marca" => $car->id_marca,
            "id_color_exterior" => $car->id_color_exterior,
            "id_color_interior" => $car->id_color_interior,
            "id_modelo" => $car->id_modelo,
            "id_estilo" => $car->id_estilo,
            "id_motor" => $car->id_motor,
            "id_usuario" => $car->id_usuario
        ]);
        $resp = Http::get($this->URL_API . "/vehiculosofrecidos" . "/" . $request->idCar);
        return $resp;
    }

    function update_images($preloaded, $id)
    {
        $images = json_decode(Http::get($this->URL_API . '/imagenes' . '/' . $id));
        $images_to_delete = [];
        foreach ($images as $old_img) {
            $delete = true;
            for ($i = 0; $i < count($preloaded); $i++) {

                if ((int) $preloaded[$i] == $old_img->id_imagen) {
                    $delete = false;
                    break;
                }
            }
            if ($delete || count($preloaded) == 0) {
                $images_to_delete[] = $old_img;
            }
        }
        $this->delete_images($images_to_delete);
    }

    function delete_images($images)
    {
        foreach ($images as $image) {
            $resp = Http::delete($this->URL_API . "/imagenes" . "/" . $image->id_imagen);
            $img_path = 'uploads/cars/' . $image->url;
            if (File::exists($img_path)) {
                File::delete($img_path);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resp = Http::delete($this->URL_API . "/vehiculosofrecidos" . "/" . $id);
        $images = $this->getImagesByIdCar($id);
        foreach ($images as $img) {

            $img_path = 'uploads/cars/' . $img->url;
            if (File::exists($img_path)) {
                File::delete($img_path);
            }
        }
        return redirect()->route('profile');;
    }

   public function getUserById($id){
    $u = '';

    $resp = Http::get($this->URL_API. '/usuarios');
    $users = json_decode($resp);
    foreach ($users as $user) {
       if($user->id==$id){
       $u = $user;
       
       }
    }
return $u;

   }
    public function contactSeller(Request $request){
       
        $remitente = $request->mail;
        $subject = "Contact Seller";
        $for = $this->getUserById($request->forId)->correo;
        $file = '';
        $asunto ='Requesting info about car';
        Mail::send('contactSeller', $request->all(), function ($msj) use ($subject, $for, $remitente, $file, $asunto) {
            $msj->from($remitente, $asunto);
            $msj->subject($asunto);
            $msj->to($for);

        });

    return back();
    }



    function get_table_real_values($car)
    {
        switch ($car->combustible) {
            case "D":
                $car->combustible = "Diesel";
                break;
            case "G":
                $car->combustible = "Gasoline";
                break;
            case "E":
                $car->combustible = "Electric";
                break;
        }
        switch ($car->transmision) {
            case "A":
                $car->transmision = "Automatic";
                break;
            case "M":
                $car->transmision = "Manual";
                break;
        }
        switch ($car->negociable) {
            case 1:
                $car->negociable = "Yes";
                break;
            case 0:
                $car->negociable = "No";
                break;
        }
        switch ($car->recibe) {
            case 1:
                $car->recibe = "Yes";
                break;
            case 0:
                $car->recibe = "No";
                break;
        }
        return $car;
    }
}
