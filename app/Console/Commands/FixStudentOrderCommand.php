<?php

namespace App\Console\Commands;

use App\Models\School;
use App\Models\Student;
use Illuminate\Console\Command;
use App\Events\StudentOrderFixedEvent;

class FixStudentOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix School students order';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schoolIds = School::pluck('id');

        $schoolIds->each(function ($schoolId) {
            foreach (Student::where('school_id', $schoolId)->orderBy('id')->cursor() as $index => $student) {
                $student->update([
                    'order' => $index + 1,
                ]);
            }
        });

        StudentOrderFixedEvent::dispatch();

        $this->comment('Student order is fixed!');
    }
}
