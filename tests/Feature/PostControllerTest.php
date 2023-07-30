<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_all_posts()
    {
        Post::factory()->count(15)->create();

        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'content',
                        'image',
                        'category_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_a_post()
    {
        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => 1, // Assuming category with ID 1 exists.
        ];

        $response = $this->postJson('/api/v1/posts', $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post created successfully',
                'data' => [
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'category_id' => $data['category_id'],
                ],
            ]);

        // Assumption: The image file should be uploaded and saved successfully.
        Storage::assertExists('public/posts/' . $response->json('data.image'));
    }

    public function test_can_show_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/v1/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'category_id' => $post->category_id,
            ]);
    }

    public function test_can_update_a_post()
    {
        $post = Post::factory()->create();
        $newData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category_id' => 2, // Assuming category with ID 2 exists.
        ];

        $response = $this->putJson('/api/v1/posts/' . $post->id, $newData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post updated successfully',
                'data' => [
                    'id' => $post->id,
                    'title' => $newData['title'],
                    'content' => $newData['content'],
                    'category_id' => $newData['category_id'],
                ],
            ]);
    }

    public function test_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson('/api/v1/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Post deleted successfully']);
        
        $this->assertNull(Post::find($post->id));
    }
}
