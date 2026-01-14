<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function organizers()
    {
        return $this->morphedByMany(Organizer::class, 'sub_categorizable');
    }

    public function participants()
    {
        return $this->morphedByMany(Participant::class, 'sub_categorizable');
    }
}
