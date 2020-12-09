<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Isset_;

class FavoritesController extends Controller
{

    protected $profile;
    protected $cars;
    public function __construct()
    {
        $this->profile =  new ProfileController();
        $this->cars = new CarsController();
    }
    public function addFavorite(Request $request){
        if($request->saved){
            $resp =Http::get('http://localhost:52825/api/vehiculosdeseados');
            $saveds = json_decode($resp);
            $toDelete = "";
            foreach ($saveds as $saved) {
                if($saved->id_vehiculo==intval($request->id_vehiculo)&&
                $saved->id_usuario==intval($request->id_usuario)){
                 $toDelete = $saved;
                }
            }
            $res = Http::delete('http://localhost:52825/api/vehiculosdeseados/'.$toDelete->id);
        
        }else{
            $res = Http::post('http://localhost:52825/api/vehiculosdeseados',[
                "id_vehiculo"=>intval($request->id_vehiculo),
                "id_usuario"=>intval($request->id_usuario)
            ]);
        }

        if($request->vistaUnica==1){
            $resp = Http::get("http://localhost:52825/api/vehiculosofrecidos" . "/" . intval($request->id_vehiculo));
            $car = $this->cars->getCarsWithImages(json_decode($resp));
            $car = $this->cars->get_table_real_values($car);
            $user = $this->cars->userCar($car->id_usuario);
            $isSaved=$this->cars->isSavedForThisUser($car->id);
    
            return redirect()->route('cars.show',$car->id);
        }


          return $res;

   }


 


   public function deleteFav(Request $request){

    $resp =Http::get('http://localhost:52825/api/vehiculosdeseados');
    $saveds = json_decode($resp);
    $toDelete = "";
    foreach ($saveds as $saved) {
        if($saved->id_vehiculo==intval($request->id_vehiculo)&&
        $saved->id_usuario==intval($request->id_usuario)){
         $toDelete = $saved;
        }
    }
    $res = Http::delete('http://localhost:52825/api/vehiculosdeseados/'.$toDelete->id);
    if (null !== Cookie::get('user')) {
        $user = json_decode(Cookie::get('user'));
        $active = 'profile';
        $carsSaved = $this->profile->getCarsSaved($user->id);
        $carsPosted =$this->profile->getCarsPosted($user->id);
        $saved = true;

       // return view('profile',compact('user','active','carsSaved','carsPosted','saved'));
        return redirect()->route('profile.saved');
    }
    return redirect()->route('login');
   }
}
