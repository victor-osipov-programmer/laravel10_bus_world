<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];


    function passengers() {
        return $this->belongsToMany(User::class, 'passengers')->withPivot('place_from', 'place_back');
    }

    function from() {
        return $this->belongsTo(Trip::class, 'trip_from');
    }
    function back() {
        return $this->belongsTo(Trip::class, 'trip_back');
    }
}
