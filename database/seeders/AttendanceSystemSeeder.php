<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::create([
            'name' => 'Teacher Jane',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Create Subjects for this teacher
        $subjects = ['Mathematics', 'Science', 'History'];
        foreach ($subjects as $name) {
            $teacher->subjects()->create(['name' => $name]);
        }

        // 3. Create Students
        $students = [
            ['name' => 'Alice Johnson', 'student_id_number' => 'STU001'],
            ['name' => 'Bob Smith', 'student_id_number' => 'STU002'],
            ['name' => 'Charlie Brown', 'student_id_number' => 'STU003'],
            ['name' => 'Diana Prince', 'student_id_number' => 'STU004'],
            ['name' => 'Ethan Hunt', 'student_id_number' => 'STU005'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
