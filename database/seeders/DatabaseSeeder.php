<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\NavLink;
use App\Models\Service;
use App\Models\SiteSettings;
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

        // Seed site settings (singleton)
        SiteSettings::firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Ethos Studio',
                'tagline' => 'Professional graphic design',
                'footer_email' => 'hello@ethostudio.com',
                'copyright' => '© 2026 Ethos Studio. All rights reserved.',
            ]
        );

        // Seed nav links
        $navLinks = [
            ['label' => 'Home', 'href' => '/', 'sort_order' => 0],
            ['label' => 'Portfolio', 'href' => '/portfolio', 'sort_order' => 1],
            ['label' => 'About', 'href' => '/about', 'sort_order' => 2],
            ['label' => 'Contact', 'href' => '/contact', 'sort_order' => 3],
        ];
        foreach ($navLinks as $link) {
            NavLink::firstOrCreate(
                ['href' => $link['href']],
                [
                    'label' => $link['label'],
                    'sort_order' => $link['sort_order'],
                    'is_published' => true,
                ]
            );
        }
    }
}
