<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_panel(): void
    {
        $user = User::create([
            'name' => 'Regular',
            'email' => 'user@example.com',
            'password' => 'secret-password',
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        // Filament returns 403 when canAccessPanel() fails for an
        // authenticated user.
        $this->assertContains($response->status(), [302, 403],
            'Non-admin should be denied (redirect to login or 403).');
        if ($response->status() === 302) {
            $this->assertStringNotContainsString('/admin/', $response->headers->get('Location') ?? '');
        }
    }

    public function test_admin_user_can_access_panel(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'secret-password',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $this->assertContains($response->status(), [200, 302],
            'Admin should reach the panel (possibly via a redirect to /admin/).');
    }
}
