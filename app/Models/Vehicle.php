<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //a
    protected $fillable = [
        'plate_number',
        'model',
        'brand',
        'year',
    ];
    public function audits()
{
    return $this->hasMany(Audit::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
