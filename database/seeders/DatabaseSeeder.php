<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // 2. Create Teachers
        $teacher1 = User::create([
            'name' => 'Teacher John',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $teacher2 = User::create([
            'name' => 'Sarah Proctor',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // 3. Create a pool of 30 Students
        $allStudents = Student::factory(30)->create();

        // 4. Define Random Subjects
        $classes = [
            ['name' => 'C# Programming', 'section' => 'Morning', 'room' => 'Lab 1'],
            ['name' => 'Economics 101', 'section' => 'Afternoon', 'room' => 'Hall B'],
            ['name' => 'Marketing Strategy', 'section' => 'Online', 'room' => 'Zoom'],
            ['name' => 'iOS Development (Swift)', 'section' => 'Evening', 'room' => 'Lab 4'],
            ['name' => 'Flutter Mobile', 'section' => 'Morning', 'room' => 'Lab 2'],
            ['name' => 'Macroeconomics', 'section' => 'A', 'room' => 'Hall C'],
        ];

        foreach ($classes as $index => $classData) {
            // Randomly assign the class to one of the two teachers
            $teacherId = ($index % 2 == 0) ? $teacher1->id : $teacher2->id;

            $subject = Subject::create([
                'name' => $classData['name'],
                'section' => $classData['section'],
                'room' => $classData['room'],
                'user_id' => $teacherId,
            ]);

            // Randomly assign 5 to 12 students from our pool to this specific class
            $randomStudents = $allStudents->random(rand(5, 12));
            $subject->students()->attach($randomStudents);
        }
    }
}
