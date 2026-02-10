<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Link a student to a class (Enroll)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        $subject->students()->syncWithoutDetaching([$request->student_id]);

        return back()->with('success', 'Student enrolled successfully.');
    }

    /**
     * Unlink a student from a class (Unenroll)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        $subject->students()->detach($request->student_id);

        return back()->with('success', 'Student removed from class.');
    }
}
