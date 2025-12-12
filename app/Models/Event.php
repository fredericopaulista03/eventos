<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'venue_name',
        'address',
        'city',
        'state',
        'zip_code',
        'lat',
        'lng',
        'start_date',
        'end_date',
        'status',
        'is_online',
        'is_featured'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_online'  => 'boolean',
        'is_featured'=> 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    public function coverImage()
    {
        return $this->hasOne(EventImage::class)->where('is_cover', true)->latest();
    }
}
