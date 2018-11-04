<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;


class LoginAltController
{
//    public function login(LoginRequest )
//    {
//
//    }
    public function login(Request $request)
    {

        //TODO -> VALIDATE
        $request->email;
        $request->password;

        //buscar el usuari a la base de dades i comprovar password ok

        $user = User::where('email', $request->email)->first();

        if (!$user) return redirect('/');

        if (!Hash::check($request->password, $user->password)) return redirect('/');

        Auth::login($user);
        return redirect('/home');


    }
}