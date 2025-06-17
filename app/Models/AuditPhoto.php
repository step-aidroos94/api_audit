<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditPhoto extends Model
{
    protected $fillable = ['audit_id', 'photo_path'];
  protected $appends = ['photo_url'];
    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }
    public function getPhotoUrlAttribute()
{
    return config('app.url') . '/storage/' . $this->photo_path;
}
}