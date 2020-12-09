<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Recaller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Socialite;
class SocialAuthController extends Controller
{


    public function redirectToProvider($provider)
    {
       return  Socialite::driver($provider)->stateless()->redirect();
      
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider)
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->stateless()->user();
        // Comprobamos si el usuario ya existe
        $resUser = Http::get('http://localhost:52825/api/usuarios/' . $social_user->email);
        $user = json_decode($resUser);

        if ($user == null){
             return $this->register($social_user);
              // Login y redirección
            } else {
                return $this->authAndRedirect($user); 
                                // Login y redirección
            }
       
    }

    public function register($social_user)
    {
        $respInsert = Http::post('http://localhost:52825/api/usuarios', [
            'nombre' => $social_user->name ? $social_user->name : $social_user->nickname,
            'correo' => $social_user->email,
            'telefono' => '',
            'direccion' => '',
            'foto' => isset($social_user->avatar_original) ? $social_user->avatar_original : $social_user->avatar,
            'contraseña' => ''
        ]);

        $resUser = Http::get('http://localhost:52825/api/usuarios/' . $social_user->email);

        $user = json_decode($resUser);
       
     
        return $this->authAndRedirect($user);
    }
    

    // Login y redirección
    public function authAndRedirect($user)
    {
        //  Auth::login($user);
        $active = 'profile';
        
        Cookie::queue('user', json_encode($user), time()+(24*60*60));
         
        $carsSaved = $this->getCarsSaved($user->id);
        $carsPosted = $this->getCarsPosted($user->id);
        // dd($user);
        // return view('profile',compact('active','user'));
        // //auth()->login($user);
         return redirect()->route('profile')->with(
             ['active'=>$active,'user'=>$user,'carsSaved'=>$carsSaved,'carsPosted'=>$carsPosted]);
    }



    public function getCarsSaved($idUser){

        $carsSaved =[];
        $resCars = Http::get('http://localhost:52825/api/vehiculosofrecidos');
        $resSaved = Http::get('http://localhost:52825/api/vehiculosdeseados');
        $cars = json_decode($resCars);
        $saved= json_decode($resSaved);
        
        foreach ($cars as $car) {
              foreach ($saved as $save) {
                if($car->id==$save->id_vehiculo){
                    if($save->id_usuario==$idUser){
                       $res = Http::get('http://localhost:52825/api/imagenes' . '/' . $save->id_vehiculo);
                       $images = json_decode($res);
                       $car->images=$images;
                        array_push($carsSaved,$car);
                   }
                }
              }
        }
        return $carsSaved;
   
       }


       public function getCarsPosted($idUser){
        $carsPosted =[];
        $resCar= Http::get('http://localhost:52825/api/vehiculosofrecidos');
        $cars =json_decode($resCar);
        foreach ($cars as $car) {
           if($car->id_usuario==$idUser){
             $res = Http::get('http://localhost:52825/api/imagenes' . '/' . $car->id);
             $images = json_decode($res);
             $car->images = $images;
             array_push($carsPosted, $car);
           }
        }
       return $carsPosted;
 
     }
}
