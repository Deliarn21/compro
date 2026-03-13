<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacyRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_contact_route_redirects_to_new_contact_page(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/contact-us');

        $response
            ->assertStatus(301)
            ->assertRedirect('/contact');
    }
}
