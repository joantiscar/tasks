<?php

namespace App\Http\Controllers;

use App\Avatar;
use App\Http\Requests\Avatars\AvatarStore;

class AvatarController extends Controller
{

    public function store(AvatarStore $request)
    {
//        return $request;
        $extension = $request->file('avatar')->getClientOriginalExtension();
        $user = $request->user();
        $path = $request->file('avatar')->storeAs(
            'avatars', $user->id. '_' . time() . '.' . $extension
        );
        $request->file('avatar')->storeAs(
            '', $user->id. '.'. $extension,'google'
        );
        if ($avatar = Avatar::where('user_id',$user->id)->first()) {
            $avatar->url = $path;
            $avatar->save();
        } else {
            Avatar::create([
                'url' => $path,
                'user_id' => $request->user()->id
            ]);
        }

        return back();
    }

    public function storeExamples(AvatarStore $request)
    {
        //Nom definit per Laravel amb un sistema per evitar colisions:
        $path = $request->file('avatar')->store('avatars');
//        $path = Storage::putFile('avatars', $request->file('avatar'));
        //CustomFileName
        $path = $request->file('avatar')->storeAs(
            'avatars', $request->user()->id
        );
        //CustomFileName with extension
        $path = $request->file('avatar')->storeAs(
            'avatars', $request->user()->id
        );
        // Specificar un disk
//        $path = $request->file('avatar')->store(
//            'avatars/'.$request->user()->id, 's3'
//        );
        dump($path);
        return Avatar::create([
            'url' => $path
        ]);
    }
}
