<?php

namespace Tests\Feature;

use App\Models\ContentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_generator_redirects_to_login(): void
    {
        $response = $this->get('/content');

        $response->assertRedirect('/login');
    }

    public function test_user_model_has_credits(): void
    {
        $user = User::factory()->create(['credits' => 25]);
        
        $this->assertEquals(25, $user->credits);
        $this->assertTrue($user->hasCredits(10));
        $this->assertFalse($user->hasCredits(30));
    }
}