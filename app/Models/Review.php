<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    protected $fillable = ['booking_id','customer_id','mua_id','rating','komentar'];

    public function booking()  { return $this->belongsTo(Booking::class); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function mua()      { return $this->belongsTo(Mua::class); }
}
