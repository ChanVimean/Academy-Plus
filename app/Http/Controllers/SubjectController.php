<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $teachers = User::where('is_admin', false)->get();
        $query = Subject::with('teacher')->withCount('students');

        if (! auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('teacher', function ($t) use ($search) {
                        $t->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $subjects = $query->latest()->get();

        $editSubject = null;
        if ($request->has('edit')) {
            $editSubject = Subject::find($request->edit);
            if (! auth()->user()->is_admin && $editSubject->user_id !== auth()->id()) {
                abort(403);
            }
        }

        return view('subjects.index', compact('subjects', 'teachers', 'editSubject'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string',
            'room' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Subject::create($data);

        return redirect()->route('subjects.index')->with('success', 'Class created successfully!');
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string',
            'room' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', 'Class updated!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Class deleted.');
    }
}
