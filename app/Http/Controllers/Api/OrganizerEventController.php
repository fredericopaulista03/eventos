<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizerEventController extends Controller
{
    public function index(Request $request)
    {
        // Get events for the logged-in organizer
        $organizer = $request->user()->organizer_profile;
        if (!$organizer) {
            return response()->json(['message' => 'Organizer profile not found'], 403);
        }

        return response()->json(
            $organizer->events()->with(['tickets', 'orders'])->latest()->paginate(20)
        );
    }

    public function store(Request $request)
    {
        // Validation would go here
        
        $organizer = $request->user()->organizer_profile;
        
        $event = $organizer->events()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(4),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'venue_name' => $request->venue_name,
            'address' => $request->address,
            'city' => $request->city,
            'status' => 'draft'
        ]);
        
        // Handle Tickets
        if ($request->has('tickets')) {
            foreach($request->tickets as $ticketData) {
                $event->tickets()->create($ticketData);
            }
        }

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        $this->authorizeOrganizer($event);
        return response()->json($event->load('tickets', 'orders'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeOrganizer($event);
        $event->update($request->all());
        return response()->json($event);
    }

    private function authorizeOrganizer($event)
    {
         $user = auth()->user();
         
         // 1. Owner
         if ($event->organizer_id === $user->organizer_profile?->id) {
             return true;
         }

         // 2. Collaborator
         $isCollaborator = $user->collaborating_organizers()
                                ->where('organizers.id', $event->organizer_id)
                                ->wherePivot('is_active', true)
                                ->wherePivotIn('role', ['admin', 'editor']) // Staff might not edit events
                                ->exists();

         if (!$isCollaborator) {
             abort(403, 'Unauthorized access to this event');
         }
    }
}
