<?php

namespace App;

use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use FormattedDates;

    protected $guarded = [];
//    protected $fillable = ['name','completed'];
    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at_formatted,
            'created_at_human' => $this->created_at_human,
            'created_at_timestamp' => $this->created_at_timestamp,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at_formatted,
            'updated_at_human' => $this->updated_at_human,
            'updated_at_timestamp' => $this->updated_at_timestamp
            ];
}

}
