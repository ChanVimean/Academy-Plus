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
        $query = Student::with('subjects');

        // Filter 1: Student Name
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%'.$request->search_name.'%');
        }

        // Filter 2: By Class (Subject)
        if ($request->filled('filter_subject')) {
            $query->whereHas('subjects', function ($q) use ($request) {
                $q->where('subjects.id', $request->filter_subject);
            });
        }

        $students = $query->latest()->get();
        $subjects = Subject::all();

        $editStudent = null;
        if ($request->has('edit')) {
            $editStudent = Student::with('subjects')->find($request->edit);
        }

        return view('students.index', compact('students', 'subjects', 'editStudent'));
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $student = Student::create(['name' => $data['name']]);

        $student->subjects()->sync($request->subject_ids);

        return redirect()->route('students.index')->with('success', 'Student registered in multiple classes!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject_ids' => 'array',
        ]);

        $student->update(['name' => $data['name']]);

        $student->subjects()->sync($request->subject_ids ?? []);

        return redirect()->route('students.index')->with('success', 'Student records updated!');
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
