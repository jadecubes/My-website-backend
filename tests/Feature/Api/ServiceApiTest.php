<?php

namespace Tests\Feature\Api;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_services_sorted_by_sort_order(): void
    {
        Service::create(['title' => 'Second', 'description' => 'x', 'sort_order' => 2]);
        Service::create(['title' => 'First', 'description' => 'x', 'sort_order' => 1]);
        Service::create(['title' => 'Third', 'description' => 'x', 'sort_order' => 3]);

        $titles = collect($this->getJson('/api/services')->assertOk()->json())
            ->pluck('title')->all();

        $this->assertEquals(['First', 'Second', 'Third'], $titles);
    }

    public function test_index_returns_empty_array_when_no_services(): void
    {
        $this->getJson('/api/services')
            ->assertOk()
            ->assertExactJson([]);
    }
}
