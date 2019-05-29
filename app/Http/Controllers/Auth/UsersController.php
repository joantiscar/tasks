<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersIndex;
use App\Http\Requests\UserTaskShow;
use App\Http\Requests\UserTasksIndex;
use App\Tag;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{

    public function verifyMail(UsersIndex $request, User $user)
    {

        $user->sendEmailVerificationNotification();

    }

}
