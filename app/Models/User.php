<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'address', 'photo', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['is_active' => 'boolean'];

    // Role helpers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isMua(): bool      { return $this->role === 'mua'; }

    // Relations
    public function bookings() {
        return $this->hasMany(\App\Models\Booking::class, 'customer_id');
    }

    public function mua() {
        return $this->hasOne(\App\Models\Mua::class);
    }
}
