<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        School::pluck('id')
            ->each(function ($schoolId) {
                Student::factory()->state([
                    'school_id' => $schoolId,
                ])
                ->count(3)
                ->create();
            });
    }
}
