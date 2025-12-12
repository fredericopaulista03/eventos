<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;

Route::get('/', function () {
    try {
        $featuredEvents = Event::with('category', 'coverImage')
            ->where('is_featured', true)
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();
    } catch (\Exception $e) {
        $featuredEvents = [];
    }

    return view('welcome', compact('featuredEvents'));
});

Route::get('/events', function () {
    // Placeholder for listing page
    return view('welcome'); 
});

Route::get('/events/{slug}', function ($slug) {
    // In production, fetch via Controller:
    // $event = Event::where('slug', $slug)->firstOrFail();
    return view('pages.events.show', ['slug' => $slug]); 
});

// Organizer Dashboard (Mock for demo, normally auth protected)
Route::get('/organizer/dashboard', function () {
    return view('pages.organizer.dashboard');
});
Route::get('/organizer/events', function () {
     return "Event Management Page (To be implemented)";
});
