<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Roles
        $adminRole = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Administrator']);
        $organizerRole = Role::firstOrCreate(['slug' => 'organizer'], ['name' => 'Organizer']);
        $userRole = Role::firstOrCreate(['slug' => 'user'], ['name' => 'User']);

        // 2. Create Permissions
        $manageEverything = Permission::firstOrCreate(['slug' => 'manage_everything'], ['name' => 'Manage Everything']);
        $createEvent = Permission::firstOrCreate(['slug' => 'create_event'], ['name' => 'Create Event']);

        // 3. Assign Permissions to Roles (Pivot)
        if (!$adminRole->permissions()->where('slug', 'manage_everything')->exists()) {
            $adminRole->permissions()->attach($manageEverything);
        }
        
        if (!$organizerRole->permissions()->where('slug', 'create_event')->exists()) {
            $organizerRole->permissions()->attach($createEvent);
        }

        // 4. Create Super Admin
        $email = 'fredericopaulista@gmail.com';
        
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => Hash::make('12345678'),
                // 'role' column is removed/deprecated, using pivot table now
                'email_verified_at' => now(),
            ]);
            $this->command->info('Super Admin user created successfully.');
        } else {
            $this->command->info('Super Admin user found. Updating roles...');
        }

        // 5. Assign Role to User
        if (!$user->roles()->where('slug', 'admin')->exists()) {
            $user->roles()->attach($adminRole);
            $this->command->info('Admin role assigned to user.');
        }
        
        // Ensure they have an organizer profile too if needed
        if (!$user->organizer_profile) {
             $user->organizer_profile()->create([
                'name' => 'Admin Organizer',
                'contact_email' => $email
            ]);
        }
    }
}
