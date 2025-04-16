<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'license_plate', 'year', 'color', 'is_available'];

    public function bookings()
{
    return $this->hasMany(Booking::class);
}

}
