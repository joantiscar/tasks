<?php

namespace Tests\Feature\Traits;

use App\User;
use Spatie\Permission\Models\Permission;

trait CanLogin
{

    /**
     * @param null $guard
     *
     * @return mixed
     */
    protected function login($guard = null)
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, $guard);
        return $user;
    }

    /**
     * @param null $guard
     *
     * @return mixed
     */
    protected function loginWithPermission($permission, $guard = null)
    {
        $user = factory(User::class)->create();
        Permission::create([
          'name' => $permission,
        ]);
        $user->givePermissionTo($permission);
        $this->actingAs($user, $guard);
        return $user;
    }
    public function loginAsChatUser($guard = 'web')
    {
        initialize_roles();
        return $this->loginAsUsingRole($guard, 'Chat');
    }
    protected function loginAsSuperAdmin($guard = null)
    {
        $user = factory(User::class)->create();
        $user->admin = true;
        $user->save();
        $this->actingAs($user, $guard);
        return $user;
    }

    protected function loginAsUsingRole($guard, $role)
    {
        initialize_roles();
        $user = factory(User::class)->create();

        $roles = is_array($role) ? $role : [$role];
        foreach ($roles as $role) {
            $user->assignRole($role);
        }
        $user->assignRole($role);
        $this->actingAs($user, $guard);
        return $user;
    }

    protected function loginAsTaskManager($guard = null)
    {
        return $this->loginAsUsingRole($guard, 'TaskManager');
    }

    protected function loginAsTaskUser($guard = null)
    {
        return $this->loginAsUsingRole($guard, 'Tasks');
    }

    protected function loginAsTagManager($guard = null)
    {
        return $this->loginAsUsingRole($guard, 'TagsManager');
    }

    protected function loginAsTagUser($guard = null)
    {
        return $this->loginAsUsingRole($guard, 'Tags');
    }
}
