<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article; // Import the Article model
use Illuminate\Foundation\Testing\RefreshDatabase; // Import the RefreshDatabase trait

class ArticleTest extends TestCase
{
    use RefreshDatabase; // Use the RefreshDatabase trait

    /**
     * Test that an article can be created.
     */
    public function test_can_create_article()
    {
        $data = [
            'author' => 'John Doe',
            'title' => 'Sample Title',
            'body' => 'Sample Body'
        ];

        $this->postJson('/api/articles', $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /**
     * Test that articles can be listed.
     */
    public function test_can_list_articles()
    {
        $this->getJson('/api/articles')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'author', 'title', 'body', 'created_at']
            ]);
    }

    /**
     * Test that a specific article can be shown.
     */
    public function test_can_show_article()
    {
        $article = Article::factory()->create();

        $this->getJson('/api/articles/'.$article->id)
            ->assertStatus(200)
            ->assertJson($article->toArray());
    }
}
