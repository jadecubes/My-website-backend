<?php

namespace Tests\Feature\Api;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // The throttle middleware keys on IP; clear any counter carried
        // across tests so rate-limit assertions are independent.
        RateLimiter::clear('api');
    }

    public function test_valid_submission_creates_message(): void
    {
        $payload = [
            'name'    => 'Ada Lovelace',
            'email'   => 'ada@example.com',
            'subject' => 'Hello',
            'body'    => 'I would like a poster.',
        ];

        $this->postJson('/api/contact', $payload)
            ->assertCreated()
            ->assertJson(['message' => 'Message sent successfully.']);

        $this->assertDatabaseHas('messages', [
            'email' => 'ada@example.com',
            'body'  => 'I would like a poster.',
        ]);
    }

    public function test_subject_is_optional(): void
    {
        $this->postJson('/api/contact', [
            'name'  => 'Ada',
            'email' => 'ada@example.com',
            'body'  => 'Hi',
        ])->assertCreated();

        $this->assertSame(1, Message::count());
    }

    public function test_missing_required_fields_returns_422(): void
    {
        $this->postJson('/api/contact', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'body']);
    }

    public function test_invalid_email_returns_422(): void
    {
        $this->postJson('/api/contact', [
            'name'  => 'Ada',
            'email' => 'not-an-email',
            'body'  => 'Hi',
        ])->assertStatus(422)
          ->assertJsonValidationErrors(['email']);
    }

    public function test_rate_limit_blocks_sixth_request_within_a_minute(): void
    {
        $payload = [
            'name'  => 'Ada',
            'email' => 'ada@example.com',
            'body'  => 'Hi',
        ];

        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/contact', $payload)->assertCreated();
        }

        $this->postJson('/api/contact', $payload)->assertStatus(429);
    }
}
