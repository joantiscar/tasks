<?php

namespace App;

use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use FormattedDates;

    const TASKS_CACHE_KEY = 'tasks.joantiscar.scool.cat';

    protected $appends = ['created_at_formatted', 'updated_at_formatted'];

    protected $hidden = [
//        'created_at'
    ];
//    protected $guarded = [];
    protected $fillable = ['name', 'completed', 'id', 'description', 'user_id'];

    public function File()
    {
        return $this->hasOne(File::class);
    }
    public function assignFile(File $file)
    {
        $file->task_id = $this->id;
        $file->save();
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function addTags($tags)
    {

        $this->tags()->saveMany($tags);

    }

    public function addTag($tag)
    {

        $this->tags()->save($tag);

    }

    public function addTasks($tasks)
    {

        $this->tasks()->saveMany($tasks);

    }
    public function subject()
    {
        return ellipsis('Tasca pendent (' . $this->id . '): ' . $this->name . ' s\'ha marcat com a pendent', 80);
    }
    public function addTask($tag)
    {
        $this->tasks()->save($tag);
    }

    public function syncTags($tags)
    {
        $tagsids = [];
            if (sizeof($tags) > 0) {
            foreach ($tags as $tag) {
                if (is_array($tag)) array_push($tagsids, $tag['id'], false);
                else {
                    $tag = Tag::create([
                        'color' => 'grey',
                        'name' => $tag,
                        'description' => ''
                    ]);
                    $tag->save();
                    array_push($tagsids, $tag->id, false);
                }
            };
            }
            $this->tags()->sync($tagsids);
            return $this->map();
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
        $this->completed = !$this->completed;
        $this->save();
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'completed' => (boolean)$this->completed,
            'user_id' => (int)$this->user_id,
            'user_name' => optional($this->user)->name,
            'user_email' => optional($this->user)->email,
            'user_gravatar' => optional($this->user)->gravatar,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at_formatted,
            'created_at_human' => $this->created_at_human,
            'created_at_timestamp' => $this->created_at_timestamp,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at_formatted,
            'updated_at_human' => $this->updated_at_human,
            'updated_at_timestamp' => $this->updated_at_timestamp,
            'user' => $this->user,
            'full_search' => $this->full_search,
            'tags' => $this->tags
        ];
    }
    public function getCompletedAttribute($completed)
    {
        return (bool) $completed;
    }

    public function mapSimple()
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'description' => $this->description,
          'completed' => (boolean)$this->completed,
          'user_id' => optional($this->user)->id
        ];
    }
    public function scopeCompleted($query)
    {
        return $query->where('completed', 1);
    }
    public function scopeUncompleted($query)
    {
        return $query->where('completed', 0);
    }
    public function getFullSearchAttribute()
    {
        $state = $this->completed ? 'Completada' : 'Pendent';
        $username = optional($this->user)->name;
        $useremail = optional($this->user)->email;
        return "$this->id $this->name $this->description $state $username $useremail";
    }
}
