<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\School;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_list_schools()
    {
        $school = School::factory()->create();

        $response = $this->apiSignIn()->get(route('schools.index'));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $school->name,
            ]);
    }

    public function test_user_can_create_school()
    {
        $response = $this->apiSignIn()->post(route('schools.store'), [
            'name' => 'test name',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'test name',
            ]);
    }
}
