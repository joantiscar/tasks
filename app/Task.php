<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $hidden = [
        'created_at'
    ];
    protected $guarded = [];
//    protected $fillable = ['name','completed'];

    public function File()
    {
        return $this->hasOne(File::class);
    }
    public function assignFile(File $file)
    {
        $file->task_id = $this->id;
        $file->save();
    }

    public function addTags($tags)
    {

        $this->tags()->saveMany($tags);

    }
    public function addTag($tag)
    {

        $this->tag()->save($tag);

    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function assignUser(User $user)
    {
        $this->user()->associate($user);

        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function toggleCompleted()
    {
        $this->completed=!$this->completed;
        $this->save();
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'completed' => $this->completed,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->name
//            'tags' => $this->tags
//        'file' => optional($this->file)->file
        ];
    }
}
