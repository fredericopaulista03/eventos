<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'name', 'description', 'price', 
        'stock', 'max_per_order', 'sales_start', 'sales_end'
    ];

    protected $casts = [
        'sales_start' => 'datetime',
        'sales_end' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
