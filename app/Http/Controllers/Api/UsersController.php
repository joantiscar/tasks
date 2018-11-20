<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DestroyUser;
use App\Http\Requests\IndexUser;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UserShow;
use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //
//    public function show(UserShow $request, User $user) // Route Model Binding
//    {
//
//        return $user->map();
//
////        return User::findOrFail($request->user);
//    }
//    public function destroy(DestroyUser $request, User $user) // Route Model Binding
//    {
//        $user->delete();
//
////        return User::findOrFail($request->user);
//    }
//
//
//
//    public function edit(UpdateUser $request, User $user) // Route Model Binding
//    {
//
//        $user->name = $request->name;
//        $user->completed = $request->completed;
//        $user->save();
//
//        return $user->map();
//
//
////        return User::findOrFail($request->user);
//    }
//    public function store(StoreUser $request) // Route Model Binding
//    {
////        User::create();
//
////          $request->validate([
////            'name' => 'required',
////        ]);
//
//
//        $user = new User();
//        $user->name = $request->name;
//        $user->completed = false;
//        $user->save();
//        return $user->map();
////        return User::findOrFail($request->user);
//    }
    public function index(IndexUser $request)
    {
        return map_collection(User::all());
    }
}
