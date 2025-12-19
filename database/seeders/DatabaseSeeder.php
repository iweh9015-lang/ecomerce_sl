<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('✅ Admin user created: admin@example.com');
        } else {
            $this->command->info('ℹ️ Admin user already exists: admin@example.com');
        }

        $existingCustomers = User::where('role', 'customer')->count();
        if ($existingCustomers < 10) {
            User::factory(10 - $existingCustomers)->create([
                'role' => 'customer',
            ]);
            $this->command->info('✅ Customer users seeded (ensured 10 total)');
        } else {
            $this->command->info('ℹ️ Customer users already present');
        }

        // Ensure these specific accounts exist without duplicating
        User::firstOrCreate([
            'email' => 'admin@tokoonline.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::firstOrCreate([
            'email' => 'customer@tokoonline.com',
        ], [
            'name' => 'Customer',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->call(CategorySeeder::class);

        Product::factory(50)->create();
        $this->command->info('✅ 50 products created');

        Product::factory(8)->featured()->create();
        $this->command->info('✅ 8 featured products created');

        $this->command->newLine();
        $this->command->info('🎉 Database seeding completed!');
        $this->command->info('📧 Admin login: admin@example.com');
        $this->command->info('🔑 Password: password');
    }
}
