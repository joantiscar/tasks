<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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

}
