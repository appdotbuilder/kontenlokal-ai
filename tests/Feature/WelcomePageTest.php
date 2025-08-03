<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_health_check_endpoint(): void
    {
        $response = $this->get('/health-check');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok'
        ]);
    }
}