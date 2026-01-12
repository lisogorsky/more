<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationPartner extends Model
{


    public function parther()
    {
        return $this->belongsTo(Partner::class);
    }

    public function category_partners()
    {
        return $this->hasMany(CategoryPartner::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
