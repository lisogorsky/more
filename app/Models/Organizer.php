<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function documents()
    {
        return $this->hasMany(OrganizerDocument::class);
    }

    public function languages()
    {
        return $this->morphToMany(Language::class, 'languageable');
    }

    public function subCategories()
    {
        return $this->morphToMany(SubCategory::class, 'sub_categorizable');
    }
}
