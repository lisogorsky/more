<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    // Автоматическая генерация slug при создании
    protected static function booted()
    {
        static::creating(function ($city) {
            if (empty($city->slug)) {
                $city->slug = Str::slug($city->name);
            }
        });
    }

    // Связь с пользователями
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
