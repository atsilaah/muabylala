<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model {
    protected $table    = 'layanans';
    protected $fillable = ['nama','deskripsi','harga','harga_hairdo','durasi','foto','is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function bookings() { return $this->hasMany(Booking::class); }
}
