<?php

namespace App\Providers;

use App\Events\TaskCompleted;
use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskUncompleted;
use App\Events\TaskUpdated;
use App\Listeners\AddRolesToRegisterUser;
use App\Listeners\ForgetTasksCache;
use App\Listeners\LogTaskCompleted;
use App\Listeners\LogTaskCreated;
use App\Listeners\LogTaskDeleted;
use App\Listeners\LogTaskUncompleted;
use App\Listeners\LogTaskUpdated;
use App\Listeners\SendMailTaskCompleted;
use App\Listeners\SendMailTaskCreated;
use App\Listeners\SendMailTaskDeleted;
use App\Listeners\SendMailTaskUncompleted;
use App\Listeners\SendMailTaskUpdated;
use App\Listeners\SendTaskCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen
      = [
        Registered::class => [
          SendEmailVerificationNotification::class,
          AddRolesToRegisterUser::class,
        ],
        TaskUncompleted::class => [
          SendMailTaskUncompleted::class,
          LogTaskUncompleted::class,
          ForgetTasksCache::class,
        ],
        TaskCompleted::class => [
          SendMailTaskCompleted::class,
          LogTaskCompleted::class,
          ForgetTasksCache::class,
        ],
        TaskCreated::class => [
          SendMailTaskCreated::class,
          LogTaskCreated::class,
          ForgetTasksCache::class,
          SendTaskCreatedNotification::class,
        ],
        TaskUpdated::class => [
          SendMailTaskUpdated::class,
          LogTaskUpdated::class,
          ForgetTasksCache::class,
        ],
        TaskDeleted::class => [
          SendMailTaskDeleted::class,
          LogTaskDeleted::class,
          ForgetTasksCache::class,
        ],
      ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
