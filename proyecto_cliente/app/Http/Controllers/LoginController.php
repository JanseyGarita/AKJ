<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function get_login($message = false)
    {
        if ($message) {
            return view('login')->with('message',true);
        }
        return redirect()->route('login');
    }


    public function login(Request $request)
    {
        $email = $request->user_email;
        $password = $request->user_password;

      //  $encrypted = Crypt::encryptString($password);
      //  dd($encrypted);
         
       // $decrypted = Crypt::decryptString($encrypted);
       
    //    dd($decrypted);



        $resUser = Http::get('http://localhost:52825/api/usuarios/' . $email);
    //   dd(md5($password));
        if (isset(json_decode($resUser)->id)) {
            $user = json_decode($resUser);
            if ($password=== Crypt::decryptString($user->contraseña)) {
                Cookie::queue('user', json_encode($user), time() + (24 * 60 * 60));
                // $this->contact($request,$email);
                return redirect()->route('profile');

            } else {
                return $this->get_login(true);
            }
        } else {
            return $this->get_login(true);
        }
    }
    public function contact(Request $request,$email2)
    {
        $remitente = $email2;
        $subject = "Asunto del correo";
        $for = $email2;
        $file = null;
        $asunto = 'Bienvenida';
        Mail::send('email', $request->all(), function ($msj) use ($subject, $for, $remitente, $file, $asunto) {
            $msj->from($remitente, $asunto);
            $msj->subject($asunto);
            $msj->to($for);
        });
       // return back()->with('notificacion', 'Éxito al enviar');
        //return view('email');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
