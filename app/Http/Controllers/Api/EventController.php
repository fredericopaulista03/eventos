<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()->where('status', 'published');

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->q.'%')
                  ->orWhere('description', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->city.'%');
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        return response()->json(
            $query->with(['category', 'organizer', 'coverImage'])
                  ->orderBy('start_date', 'asc')
                  ->paginate(12)
        );
    }

    public function show($slug)
    {
        $event = Event::with(['category', 'organizer', 'tickets', 'images'])
                      ->where('slug', $slug)
                      ->firstOrFail();

        return response()->json($event);
    }
}
