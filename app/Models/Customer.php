<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @method bool delete()
 */

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'jenis_makeup',
        'harga',
        'tanggal_booking',
        'aktif',
        'foto',
        'user_id',
    ];

    protected $casts = [
        'harga'           => 'decimal:2',
        'aktif'           => 'boolean',
        'tanggal_booking' => 'date',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}

