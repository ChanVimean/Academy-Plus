<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subjects = Subject::orderBy('name')->get();

        $history = Attendance::with(['student', 'subject'])
            ->when($request->subject_id, function ($query, $subject_id) {
                return $query->where('subject_id', $subject_id);
            })
            ->orderBy('attendance_date', 'desc')
            ->paginate(25)
            ->withQueryString();

        return view('attendance.index', compact('history', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject)
    {
        $students = $subject->students()->orderBy('name')->get();

        return view('attendance.create', compact('subject', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject)
    {
        foreach ($request->status as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                    'attendance_date' => now()->format('Y-m-d'),
                ],
                [
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('subjects.index')->with('success', 'Attendance recorded!');
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
