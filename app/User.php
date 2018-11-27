<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        'gravatar' => $this->gravatar,
        'admin' => (boolean)$this->admin,
        'roles' => $this->roles()->pluck('name')->unique()->toArray(),
        'permissions' => $this->getAllPermissions()->pluck('name')->unique()->toArray()

        ];
    }

    public function getGravatarAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email);

    }

    public function impersonatedBy()
    {
        if ($this->isImpersonated()) return User::findOrFail(Session::get('impersonated_by'));
        return null;
    }

    public function scopeRegular($query)
    {
        return $query->where('admin',false);
    }

    public function scopeAdmin($query)
    {
        return $query->where('admin',true);
    }
}