<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|array',
            'tickets.*.id' => 'required|exists:tickets,id',
            'tickets.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Calculate Total and Validate Stock
                $totalAmount = 0;
                $lineItems = [];

                foreach ($request->tickets as $item) {
                    $ticket = Ticket::lockForUpdate()->find($item['id']);
                    
                    if ($ticket->stock < $item['quantity']) {
                        throw new \Exception("Insufficient stock for ticket: {$ticket->name}");
                    }

                    $subtotal = $ticket->price * $item['quantity'];
                    $totalAmount += $subtotal;
                    
                    $lineItems[] = [
                        'ticket' => $ticket,
                        'quantity' => $item['quantity'],
                        'unit_price' => $ticket->price,
                        'subtotal' => $subtotal
                    ];
                }

                // Create Order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                    'status' => 'pending',
                    'total_amount' => $totalAmount,
                    'currency' => 'BRL',
                ]);

                // Create Items and Decrement Stock
                foreach ($lineItems as $line) {
                    $order->items()->create([
                        'ticket_id' => $line['ticket']->id,
                        'ticket_name' => $line['ticket']->name,
                        'quantity' => $line['quantity'],
                        'unit_price' => $line['unit_price'],
                        'subtotal' => $line['subtotal']
                    ]);

                    $line['ticket']->decrement('stock', $line['quantity']);
                }

                // Create Payment Record (Pending)
                $order->payment()->create([
                    'amount' => $totalAmount,
                    'provider' => $request->payment_method,
                    'status' => 'pending'
                ]);

                return response()->json([
                    'message' => 'Order created successfully',
                    'order' => $order,
                    'payment_url' => 'https://mock-payment-gateway.com/pay/' . $order->order_number
                ], 201);
            });

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function myOrders(Request $request)
    {
        return response()->json(
            $request->user()->orders()->with('items.ticket')->latest()->get()
        );
    }
}
