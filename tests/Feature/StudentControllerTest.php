<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\School;
use App\Models\Student;

class StudentControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_listing_students()
    {
        $school = School::factory()->create();
        $student = Student::factory()->create([
            'school_id' => $school->id,
        ]);

        $response = $this->apiSignIn()->get(route('students.index'));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $student->name,
            ])
            ->assertJsonFragment([
                'name' => $school->name,
            ]);
    }
}
