<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
{
    $query = Subject::withCount('students');

    if (auth()->user()->is_admin) {
        $subjects = $query->with('teacher')->get();
        $teachers = \App\Models\User::where('is_admin', false)->get();
    } else {
        $subjects = $query->where('user_id', auth()->id())->get();
        $teachers = collect();
    }

    return view('subjects.index', compact('subjects', 'teachers'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'room' => 'nullable|string|max:50',
        ]);

        Subject::create([
            'name' => $request->name,
            'section' => $request->section,
            'room' => $request->room,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created!');
    }

    public function update(Request $request, Subject $subject)
    {
        if ($subject->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'room' => 'nullable|string|max:50',
        ]);

        $subject->update($request->only(['name', 'section', 'room']));

        return redirect()->route('subjects.index')->with('success', 'Subject updated!');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->user_id !== auth()->id()) {
            abort(403);
        }

        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject/Class removed.');
    }
}
