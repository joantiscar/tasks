<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DestroyTask;
use App\Http\Requests\IndexTask;
use App\Http\Requests\RemoveTaskTags;
use App\Http\Requests\StoreTask;
use App\Http\Requests\TaskShow;
use App\Http\Requests\UpdateTask;
use App\Http\Requests\UpdateTaskTags;
use App\Tag;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskTagsController extends Controller
{

    public function addMultipleTags(UpdateTaskTags $request, Task $task) // Route Model Binding
    {

        return $task->syncTags($request->all());
    }
    public function removeTag(RemoveTaskTags $request, Task $task, Tag $tag)
    {
        //Fet per lo de La Sénia

        $task->tags()->detach($tag['id']);

        $task->save();

        return $task->map();

    }

}
