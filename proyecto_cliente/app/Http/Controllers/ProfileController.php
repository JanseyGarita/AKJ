<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use PhpParser\JsonDecoder;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
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
        //
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
    public function showProfile()
    {
        if (null !== Cookie::get('user')) {
            $user = json_decode(Cookie::get('user'));
            $user->contraseña = Crypt::decryptString( $user->contraseña);
            $active = 'profile';
            $carsSaved = $this->getCarsSaved($user->id);
            $carsPosted = $this->getCarsPosted($user->id);
            return view('profile', compact('user', 'active', 'carsSaved', 'carsPosted'));
        }
        return redirect()->route('login');
    }



    public function showProfileSaved()
    {
        if (null !== Cookie::get('user')) {
            $user = json_decode(Cookie::get('user'));
            $user->contraseña = Crypt::decryptString( $user->contraseña);
            $active = 'profile';
            $carsSaved = $this->getCarsSaved($user->id);
            $carsPosted = $this->getCarsPosted($user->id);
            $saved = true;
            return view('profile', compact('user', 'active', 'carsSaved', 'carsPosted', 'saved'));
        }
        return redirect()->route('login');
    }
    public function showProfilePosts()
    {
        if (null !== Cookie::get('user')) {
            $user = json_decode(Cookie::get('user'));
            $user->contraseña = Crypt::decryptString( $user->contraseña);
            $active = 'profile';
            $carsSaved = $this->getCarsSaved($user->id);
            $carsPosted = $this->getCarsPosted($user->id);
            $cars = $this->get_all_cars();
            $posts = true;
            return view('profile', compact('user', 'active', 'carsSaved', 'carsPosted', 'posts', 'cars'));
        }
        return redirect()->route('login');
    }

    function get_all_cars()
    {
        $resCar = Http::get('http://localhost:52825/api/vehiculosofrecidos');
        return json_decode($resCar);
    }

    public function getCarsPosted($idUser)
    {
        $carsPosted = [];
        $resCar = Http::get('http://localhost:52825/api/vehiculosofrecidos');
        $cars = json_decode($resCar);
        foreach ($cars as $car) {
            if ($car->id_usuario == $idUser) {
                $res = Http::get('http://localhost:52825/api/imagenes' . '/' . $car->id);
                $images = json_decode($res);
                $car->images = $images;
                array_push($carsPosted, $car);
            }
        }
        return $carsPosted;
    }


    public function getCarsSaved($idUser)
    {

        $carsSaved = [];
        $resCars = Http::get('http://localhost:52825/api/vehiculosofrecidos');
        $resSaved = Http::get('http://localhost:52825/api/vehiculosdeseados');
        $cars = json_decode($resCars);
        $saved = json_decode($resSaved);

        foreach ($cars as $car) {
            foreach ($saved as $save) {
                if ($car->id == $save->id_vehiculo) {
                    if ($save->id_usuario == $idUser) {
                        $res = Http::get('http://localhost:52825/api/imagenes' . '/' . $save->id_vehiculo);
                        $images = json_decode($res);
                        $car->images = $images;
                        array_push($carsSaved, $car);
                    }
                }
            }
        }
        return $carsSaved;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $resUser = Http::get('http://localhost:52825/api/usuarios/' . $request->user_email);

        if (json_decode($resUser) == null) {

            $respuesta = Http::post($this->URL_API . '/usuarios', [
                "nombre" => $request->user_full_name,
                "correo" => $request->user_email,
                "telefono" => $request->phone,
                "direccion" => $request->address,
                "foto" => 'default.png',
                "contraseña" => Crypt::encryptString($request->user_password)
            ]);

            $usuarios = Http::get($this->URL_API . '/usuarios');
            $usuarios = json_decode($usuarios);
            $last = $usuarios[count($usuarios) - 1];
            Cookie::queue('user', json_encode($last), time() + (24 * 60 * 60));
            $this->contact($request);
            return redirect()->route('profile');
        } else {
            return redirect()->route('login')->with('message', true);
        }
    }


    public function contact(Request $request)
    {
        $remitente = $request->user_email;
        $subject = "Asunto del correo";
        $for = $request->user_email;
        $file = null;
        $asunto = 'Bienvenida';
        Mail::send('email', $request->all(), function ($msj) use ($subject, $for, $remitente, $file, $asunto) {
            $msj->from($remitente, $asunto);
            $msj->subject($asunto);
            $msj->to($for);
        });
    }

    public function update_user_info(Request $request)
    {
        if (null !== Cookie::get('user')) {
            $user = $request->all();
            $result = Http::put($this->URL_API . '/usuarios' . '/' . json_decode(Cookie::get('user'))->id, [
                "id" => json_decode(Cookie::get('user'))->id,
                "nombre" => $user['user-full-name'],
                "correo" => json_decode(Cookie::get('user'))->correo,
                "telefono" => $user['user-phone'],
                "direccion" => $user['user-location'],
                "foto" => $user['user-photo'],
                "contraseña" =>Crypt::encryptString($user['user-password'])
            ]);
            $this->restart_cookie(json_decode(Cookie::get('user'))->correo);
            return redirect()->route('profile');
        } else {
            return redirect()->route('login');
        }
    }

    public function update_user_img(Request $request)
    {
        if (null !== Cookie::get('user')) {
            $img_name = $this->upload_img($request);
            if ($img_name) {
                $result = Http::put($this->URL_API . '/usuarios' . '/' . json_decode(Cookie::get('user'))->id, [
                    "id" => json_decode(Cookie::get('user'))->id,
                    "nombre" => json_decode(Cookie::get('user'))->nombre,
                    "correo" => json_decode(Cookie::get('user'))->correo,
                    "telefono" => json_decode(Cookie::get('user'))->telefono,
                    "direccion" => json_decode(Cookie::get('user'))->direccion,
                    "foto" => $img_name,
                    "contraseña" => json_decode(Cookie::get('user'))->contraseña
                ]);

                $this->delete_profile_img();
                $this->restart_cookie(json_decode(Cookie::get('user'))->correo);
            }
            return redirect()->route('profile');
        } else {
            return redirect()->route('login');
        }
    }

    function upload_img(Request $request)
    {
        if ($file = $request->file('user_img')) {
            $time = date('d_m_Y_His');
            $name = $time . "_" . $file->getClientOriginalName();
            $result = $file->move('uploads/users/', $name);
            return $name;
        }
        return false;
    }

    function restart_cookie($email)
    {
        $resUser = Http::get('http://localhost:52825/api/usuarios/' . $email);

        if (isset(json_decode($resUser)->id)) {
            Cookie::queue(Cookie::forget('user'));
            $user = json_decode($resUser);
            Cookie::queue('user', json_encode($user), time() + (24 * 60 * 60));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cars = json_decode(Http::get('http://localhost:52825/api/vehiculosofrecidos/'));
        $carsPosted = [];
        foreach ($cars as $car) {
            if ($car->id_usuario . "" == $id) {
                $res = Http::get('http://localhost:52825/api/imagenes' . '/' . $car->id);
                $images = json_decode($res);
                $this->delete_images($images);
                array_push($carsPosted, $car);
            }
        }
        $this->delete_profile_img();
        $id = (int) $id;
        Http::delete('http://localhost:52825/api/usuarios/' . $id);
        Cookie::queue(Cookie::forget('user'));
        return redirect()->route('login');
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
    function delete_profile_img()
    {
        $image_path = 'uploads/users/' . json_decode(Cookie::get('user'))->foto;
        if (File::exists($image_path) && json_decode(Cookie::get('user'))->foto != 'default.png') {
            File::delete($image_path);
        }
    }
}
