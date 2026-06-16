<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model {
    protected $fillable = ['booking_id','metode','bukti_foto','status','confirmed_at'];

    public function booking() { return $this->belongsTo(Booking::class); }
}
