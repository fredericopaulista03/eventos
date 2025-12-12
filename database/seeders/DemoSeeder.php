<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Order;
use App\Models\Organizer;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');

        $this->command->info('Creating Categories...');
        $categories = ['Esportes', 'Shows', 'Teatro', 'Workshops', 'Gastronomia'];
        $catIds = [];
        foreach ($categories as $cat) {
            $c = EventCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
            $catIds[] = $c->id;
        }

        $this->command->info('Creating 3 Organizers...');
        $organizerRole = Role::where('slug', 'organizer')->first();
        
        $organizers = [];
        for ($i = 0; $i < 3; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $user->roles()->attach($organizerRole);
            
            $org = Organizer::create([
                'user_id' => $user->id,
                'name' => $faker->company,
                'bio' => $faker->paragraph,
                'contact_email' => $user->email,
            ]);
            $organizers[] = $org;
        }

        $this->command->info('Creating 10 Events...');
        $events = [];
        for ($i = 0; $i < 10; $i++) {
            $organizer = $faker->randomElement($organizers);
            $startDate = $faker->dateTimeBetween('-1 month', '+6 months');
            $status = $startDate < now() ? 'completed' : 'published';

            $event = Event::create([
                'organizer_id' => $organizer->id,
                'category_id' => $faker->randomElement($catIds),
                'title' => $faker->sentence(3),
                'slug' => $faker->slug,
                'description' => $faker->paragraph(3),
                'venue_name' => $faker->city . ' Arena',
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->stateAbbr, // Generates 'BR-SP' etc, might need strict 2 chars
                'start_date' => $startDate,
                'end_date' => Carbon::parse($startDate)->addHours(4),
                'status' => $status,
                'is_featured' => $faker->boolean(30),
            ]);

            // Create Tickets
            Ticket::create([
                'event_id' => $event->id,
                'name' => 'Lote 1',
                'price' => $faker->numberBetween(5000, 15000), // cents
                'stock' => 100,
                'sales_start' => now()->subDays(10),
                'sales_end' => $event->start_date,
            ]);
            Ticket::create([
                'event_id' => $event->id,
                'name' => 'VIP',
                'price' => $faker->numberBetween(20000, 50000),
                'stock' => 20,
                'sales_start' => now()->subDays(10),
                'sales_end' => $event->start_date,
            ]);

            $events[] = $event;
            // Create dummy cover image
            $event->images()->create([
                'path' => 'https://picsum.photos/seed/' . $event->id . '/800/400',
                'is_cover' => true
            ]);
        }

        $this->command->info('Creating Orders...');
        // Create a buyer
        $buyer = User::create([
            'name' => 'Comprador Teste',
            'email' => 'buyer@test.com',
            'password' => Hash::make('password')
        ]);

        foreach ($events as $event) {
            if ($faker->boolean(70)) { // 70% chance of sales
                $ticket = $event->tickets->first();
                $qty = $faker->numberBetween(1, 3);
                
                $order = Order::create([
                    'user_id' => $buyer->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'status' => 'completed',
                    'total_amount' => $ticket->price * $qty,
                    'currency' => 'BRL',
                ]);

                $order->items()->create([
                    'ticket_id' => $ticket->id,
                    'ticket_name' => $ticket->name,
                    'quantity' => $qty,
                    'unit_price' => $ticket->price,
                    'subtotal' => $ticket->price * $qty
                ]);
            }
        }
    }
}
