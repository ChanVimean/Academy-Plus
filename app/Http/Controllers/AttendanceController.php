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
        $subjects = Subject::all();

        $query = Attendance::with(['student', 'subject']);

        if ($request->filled('search_student')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search_student.'%');
            });
        }

        if ($request->filled('filter_subject')) {
            $query->where('subject_id', $request->filter_subject);
        }

        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        $history = $query->latest()->paginate(20);

        $topAbsentees = Attendance::where('status', 'absent')
            ->select('student_id', \DB::raw('count(*) as total'))
            ->with('student')
            ->groupBy('student_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('attendance.index', compact('history', 'subjects', 'topAbsentees'));
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
