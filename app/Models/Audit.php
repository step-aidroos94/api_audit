<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    //aa
    protected $casts = [
    'photo_paths' => 'array',
    'audited_at' => 'datetime',
];
    protected $fillable = [
        'vehicle_id',
        'status',
        'notes',
        'audited_at',
        'user_id',
        'photo_path', // ← مهم إذا كنت ترسل صورة
    ];
    public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function photos()
{
    return $this->hasMany(AuditPhoto::class);
}
}
