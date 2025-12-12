<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function organizerStats(Request $request)
    {
        $organizer = $request->user()->organizer_profile;
        
        if (!$organizer) {
            abort(403, 'Organizer profile required');
        }

        // Aggregate stats from all events of this organizer
        $eventIds = $organizer->events()->pluck('id');

        $totalEvents = $organizer->events()->count();
        $totalTicketsSold = DB::table('order_items')
            ->join('tickets', 'order_items.ticket_id', '=', 'tickets.id')
            ->whereIn('tickets.event_id', $eventIds)
            ->sum('quantity');

        $totalRevenue = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('tickets', 'order_items.ticket_id', '=', 'tickets.id')
            ->whereIn('tickets.event_id', $eventIds)
            ->where('orders.status', 'completed') // Only paid
            ->sum('order_items.subtotal');

        // Recent sales chart data (Last 30 days)
        $salesChart = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('tickets', 'order_items.ticket_id', '=', 'tickets.id')
            ->whereIn('tickets.event_id', $eventIds)
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(orders.created_at) as date, SUM(order_items.subtotal) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'kpis' => [
                'total_events' => $totalEvents,
                'total_tickets_sold' => $totalTicketsSold,
                'total_revenue' => $totalRevenue,
                'conversion_rate' => 2.5, // Mock for now
            ],
            'charts' => [
                'sales_over_time' => $salesChart
            ]
        ]);
    }
}
