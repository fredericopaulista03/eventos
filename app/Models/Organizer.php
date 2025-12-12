<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'bio',
        'logo',
        'website',
        'contact_email',
        'is_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Owner
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'organizer_collaborators')
                    ->withPivot('role', 'is_active')
                    ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
