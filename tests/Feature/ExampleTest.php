<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnauthorizedRequest()
    {
        $response = $this->get('/api/auth/me');

        $response->assertStatus(401);
    }
}
