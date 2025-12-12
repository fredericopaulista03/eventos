<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function organizer_profile()
    {
        return $this->hasOne(Organizer::class);
    }
    
    public function collaborating_organizers()
    {
        return $this->belongsToMany(Organizer::class, 'organizer_collaborators')
                    ->withPivot('role', 'is_active')
                    ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function hasRole($slug)
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function isOrganizer()
    {
        return $this->hasRole('organizer') || $this->hasRole('admin');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
