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

    public function test_user_can_show_school_details()
    {
        $school = School::factory()->create();

        $response = $this->apiSignIn()->get(route('schools.show', $school->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $school->name,
            ]);
    }

    public function test_user_can_update_school_details()
    {
        $school = School::factory()->create();

        $this->assertNotEquals($school->name, 'new name');

        $response = $this->apiSignIn()->patch(route('schools.update', $school->id), [
            'name' => 'new name',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'new name',
            ]);

        $this->assertSame($school->fresh()->name, 'new name');
    }
}
