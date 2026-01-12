<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{

    protected $casts = [
        'date_start' => 'date',
        'date_end'   => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function partnerCategories()
    {
        return $this->belongsToMany(CategoryPartner::class, 'category_partner_event');
    }

    public function getStartsAtAttribute(): Carbon
    {
        return $this->date_start
            ->copy()
            ->setTimeFromTimeString($this->time_start);
    }
}
