<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_only_published_projects(): void
    {
        $category = Category::create(['name' => 'Poster', 'slug' => 'poster']);

        Project::create([
            'title' => 'Published', 'slug' => 'published',
            'description' => 'x', 'category_id' => $category->id,
            'is_published' => true, 'sort_order' => 1,
        ]);
        Project::create([
            'title' => 'Draft', 'slug' => 'draft',
            'description' => 'x', 'category_id' => $category->id,
            'is_published' => false, 'sort_order' => 2,
        ]);

        $response = $this->getJson('/api/projects');

        $response->assertOk();
        $slugs = collect($response->json('data'))->pluck('slug')->all();
        $this->assertContains('published', $slugs);
        $this->assertNotContains('draft', $slugs);
    }

    public function test_index_filters_by_category_slug(): void
    {
        $posters = Category::create(['name' => 'Poster', 'slug' => 'poster']);
        $banners = Category::create(['name' => 'Banner', 'slug' => 'banner']);

        Project::create([
            'title' => 'P1', 'slug' => 'p1', 'description' => 'x',
            'category_id' => $posters->id, 'is_published' => true, 'sort_order' => 1,
        ]);
        Project::create([
            'title' => 'B1', 'slug' => 'b1', 'description' => 'x',
            'category_id' => $banners->id, 'is_published' => true, 'sort_order' => 1,
        ]);

        $response = $this->getJson('/api/projects?category=poster');

        $response->assertOk();
        $slugs = collect($response->json('data'))->pluck('slug')->all();
        $this->assertEquals(['p1'], $slugs);
    }

    public function test_index_respects_sort_order(): void
    {
        $category = Category::create(['name' => 'Poster', 'slug' => 'poster']);

        Project::create([
            'title' => 'Second', 'slug' => 'second', 'description' => 'x',
            'category_id' => $category->id, 'is_published' => true, 'sort_order' => 2,
        ]);
        Project::create([
            'title' => 'First', 'slug' => 'first', 'description' => 'x',
            'category_id' => $category->id, 'is_published' => true, 'sort_order' => 1,
        ]);

        $slugs = collect($this->getJson('/api/projects')->json('data'))
            ->pluck('slug')->all();

        $this->assertEquals(['first', 'second'], $slugs);
    }

    public function test_show_returns_published_project_by_slug(): void
    {
        $category = Category::create(['name' => 'Poster', 'slug' => 'poster']);
        Project::create([
            'title' => 'Hello', 'slug' => 'hello', 'description' => 'x',
            'category_id' => $category->id, 'is_published' => true, 'sort_order' => 1,
        ]);

        $this->getJson('/api/projects/hello')
            ->assertOk()
            ->assertJsonFragment(['slug' => 'hello']);
    }

    public function test_show_returns_404_for_unpublished_project(): void
    {
        $category = Category::create(['name' => 'Poster', 'slug' => 'poster']);
        Project::create([
            'title' => 'Draft', 'slug' => 'draft', 'description' => 'x',
            'category_id' => $category->id, 'is_published' => false, 'sort_order' => 1,
        ]);

        $this->getJson('/api/projects/draft')->assertNotFound();
    }

    public function test_show_returns_404_for_missing_slug(): void
    {
        $this->getJson('/api/projects/nope')->assertNotFound();
    }
}
