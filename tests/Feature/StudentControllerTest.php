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

    public function test_user_can_store_student()
    {
        $school = School::factory()->create();

        Student::factory()->state(
            [
                'school_id' => $school->id,
            ]
        )->count(2)->create();

        $response = $this->apiSignIn()->post(route('students.store'), [
            'name' => 'test name',
            'school_id' => $school->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'test name',
                'school_id' => $school->id,
                'order' => 3,
            ]);
    }

    public function test_user_can_show_student_details()
    {
        $school = School::factory()->create();
        $student = Student::factory()->create([
            'school_id' => $school->id,
        ]);

        $response = $this->apiSignIn()->get(route('students.show', $student->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $student->name,
            ])
            ->assertJsonFragment([
                'name' => $school->name,
            ]);
    }
}
