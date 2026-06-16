<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = [
        'customer_id','mua_id','layanan_id','tanggal','jam_mulai',
        'jam_selesai','jumlah_orang','add_hairdo','total_harga',
        'status','catatan','alamat'
    ];
    protected $casts = ['add_hairdo' => 'boolean'];

    public function customer()   { return $this->belongsTo(User::class, 'customer_id'); }
    public function mua()        { return $this->belongsTo(Mua::class); }
    public function layanan()    { return $this->belongsTo(Layanan::class); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class); }
    public function review()     { return $this->hasOne(Review::class); }
}
