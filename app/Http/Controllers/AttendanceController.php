<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = Attendance::with(['student', 'subject'])
            ->orderBy('attendance_date', 'desc')
            ->paginate(25);

        return view('attendance.index', compact('history'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject)
    {
        $students = Student::orderBy('name', 'asc')->get();

        return view('attendance.create', compact('subject', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:present,late,absent',
        ]);

        foreach ($request->attendances as $studentId => $data) {
            Attendance::create([
                'student_id' => $studentId,
                'subject_id' => $request->subject_id,
                'attendance_date' => $request->date,
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Attendance recorded!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
