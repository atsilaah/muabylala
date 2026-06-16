<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mua extends Model {
    protected $table    = 'muas';
    protected $fillable = ['user_id','spesialisasi','bio','foto','is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function user()     { return $this->belongsTo(User::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function reviews()  { return $this->hasMany(Review::class); }
}
