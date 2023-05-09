<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class VisitPageBasicAuthTest extends TestCase
{
    /**
     * Not auth user cannot visit page to load file.
     */
    public function test_visit_page_not_authenticated_user(): void
    {
        $response = $this->get('/');

        $response->assertStatus(401);
    }

    /**
     * Auth user can visit page to load file.
     */
    public function test_visit_page_authenticated_user(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user)
            ->get('/');

        $response->assertStatus(200);
    }
}
