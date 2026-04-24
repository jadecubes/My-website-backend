<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user. Password must be provided via ADMIN_PASSWORD env
        // so that running `db:seed` in any environment requires an explicit,
        // unique secret — no silent fallback to a well-known default.
        $adminPassword = env('ADMIN_PASSWORD');
        if (empty($adminPassword)) {
            throw new \RuntimeException(
                'ADMIN_PASSWORD env var is required to seed the admin user. '
                .'Set it in .env before running db:seed.'
            );
        }

        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@ethostudio.com')],
            [
                'name' => 'Admin',
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
            ]
        );

        // Seed categories
        $categories = ['Poster', 'Banner', 'Flyer', 'Infographic', 'Product'];
        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name]
            );
        }

        // Seed services
        $services = [
            ['title' => 'Graphic Design', 'description' => 'Posters, flyers, banners, and cards for your brand.', 'sort_order' => 1],
            ['title' => 'Infographic Design', 'description' => 'Visual storytelling through data and illustrations.', 'sort_order' => 2],
            ['title' => 'Product Design', 'description' => 'Packaging and product appearance design.', 'sort_order' => 3],
        ];
        foreach ($services as $service) {
            Service::firstOrCreate(['title' => $service['title']], $service);
        }
    }
}
