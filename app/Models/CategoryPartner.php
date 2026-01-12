<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPartner extends Model
{
    public function location_partner()
    {
        return $this->belongsTo(LocationPartner::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'category_partner_event', 'category_partner_id', 'event_id');
    }

    public function partners()
    {
        // Вторым параметром можно указать имя таблицы, если оно не по стандарту
        return $this->belongsToMany(Partner::class, 'category_partner_partner');
    }
}
