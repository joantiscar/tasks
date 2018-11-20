<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($task)
    {
        $this->tasks()->save($task);
    }
    public function addTasks($tasks)
    {
        $this->tasks()->saveMany($tasks);
    }

    public function have_task($task)
    {
        return Auth::user()->tasks()->findOrFail($task->id);

    }

    public function isSuperAdmin()
    {
        return $this->admin;
    }

    public function map()
    {
        return[
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        'avatar' => $this->getAvatarAttribute()
        ];
    }

    public function getAvatarAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email);

    }
}
