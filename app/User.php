<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use Notifiable, HasApiTokens, HasRoles, Impersonate;

    const DEFAULT_PHOTO = 'default.png';

    const DEFAULT_PHOTO_PATH1 = 'photos/' . self::DEFAULT_PHOTO;

    const DEFAULT_PHOTO_PATH = 'app/' . self::DEFAULT_PHOTO_PATH1;

    const USER_CACHE_KEY = 'tasks.joantiscar.scool.cat-user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
      = [
        'name',
        'email',
        'password',
      ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
      = [
        'password',
        'remember_token',
      ];

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    public function getCurrentAvatar()
    {
        return $this->avatars[0] ?? '';
    }

    public function assignPhoto(Photo $photo)
    {
        $photo->user_id = $this->id;
        $photo->save();
        return $this;
    }

    public function avatars()
    {
        return $this->hasMany(Avatar::class);
    }

    public function addAvatar(Avatar $avatar)
    {
        $this->avatars()->save($avatar);
        return $this;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($task)
    {
        $this->tasks()->save($task);
    }

    public function removeTask($task)
    {
        $task = $this->tasks()->findOrFail($task->id);
        $task->delete();
    }

    public function addTasks($tasks)
    {
        $this->tasks()->saveMany($tasks);
    }

    public function have_task($task)
    {
        return $this->tasks()->findOrFail($task->id);
    }

    public function isSuperAdmin()
    {
        return $this->admin;
    }

    public function map()
    {
        return [
          'id'          => $this->id,
          'name'        => $this->name,
          'email'       => $this->email,
          'gravatar'    => $this->gravatar,
          'admin'       => (boolean)$this->admin,
          'roles'       => $this->roles()->pluck('name')->unique()->toArray(),
          'permissions' => $this->getAllPermissions()
            ->pluck('name')
            ->unique()
            ->toArray(),
          'isOnline' => $this->isOnline

        ];
    }

    public function mapSimple()
    {
        return [
          'id'       => $this->id,
          'name'     => $this->name,
          'email'    => $this->email,
          'gravatar' => $this->gravatar,
          'admin'    => (boolean)$this->admin,
          'hash_id'  => $this->hash_id,
          'isOnline' => $this->isOnline
        ];
    }

    public function getGravatarAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email);
    }

    public function impersonatedBy()
    {
        if ($this->isImpersonated()) {
            return User::findOrFail(Session::get('impersonated_by'));
        }
        return null;
    }

    public function scopeRegular($query)
    {
        return $query->where('admin', false);
    }

    public function scopeAdmin($query)
    {
        return $query->where('admin', true);
    }

    protected function hashedKey()
    {
        $hashids = new \Hashids\Hashids(config('tasks.salt'));
        return $hashids->encode($this->getKey());
    }

    /**
     * Get the photo path prefix.
     *
     * @param  string $value
     *
     * @return string
     */
    public function getHashIdAttribute($value)
    {
        return $this->hashedKey();
    }

    public function isOnline()
    {
        return Cache::has(User::USER_CACHE_KEY . '-user_is_online' . $this->id);
    }

    public function getIsOnlineAttribute()
    {
        return $this->isOnline();
    }
}
