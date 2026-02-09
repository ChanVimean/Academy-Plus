<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::latest()->get();

        $subjects = Subject::orderBy('name')->get();

        $editStudent = null;
        if ($request->has('edit')) {
            $editStudent = Student::with('subjects')->find($request->edit);
        }

        return view('students.index', compact('students', 'editStudent', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $student = Student::create($request->only(['name']));

        $student->subjects()->attach($request->subject_id);

        return redirect()->route('students.index')->with('success', 'Student registered and enrolled!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $student->update($request->only(['name']));

        $student->subjects()->sync([$request->subject_id]);

        return redirect()->route('students.index')->with('success', 'Student updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->subjects()->detach();

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student and their enrollment data removed successfully.');
    }
}
