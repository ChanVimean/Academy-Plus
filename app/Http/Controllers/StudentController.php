<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::latest()->get();

        $editStudent = null;
        if ($request->has('edit')) $editStudent = Student::find($request->edit);
        return view('students.index', compact('students', 'editStudent'));
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
            'student_id_number' => 'required|unique:students'
        ]);

        Student::create($request->only(['name', 'student_id_number']));

        return redirect()->route('students.index')->with('success', 'Student added!');
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
            'student_id_number' => 'required|string|unique:students,student_id_number,' . $student->id,
        ]);

        $student->update($request->only(['name', 'student_id_number']));

        return redirect()->route('students.index')->with('success', 'Student updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
