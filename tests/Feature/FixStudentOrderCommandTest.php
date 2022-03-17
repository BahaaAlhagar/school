<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\School;
use Illuminate\Support\Facades\Event;
use App\Events\StudentOrderFixedEvent;

class FixStudentOrderCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fix_student_order_command_works()
    {
        Event::fake();

        $schools = School::factory()
            ->count(2)
            ->hasStudents(4)
            ->create();

        $this->artisan('student:order')->assertSuccessful()
            ->expectsOutput('Student order is fixed!');

        $schools = School::with([
            'students' => function ($q) {
                return $q->orderBy('id');
            },
        ])->get();

        foreach ($schools as $school) {
            foreach ($school->students as $index => $student) {
                $this->assertSame($student->order, $index + 1);
            }
        }

        Event::assertDispatched(StudentOrderFixedEvent::class);
    }
}
