<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully_with_seeded_content(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Hasnur Group', false)
            ->assertSee('Strategic Business Unit', false);
    }
}
