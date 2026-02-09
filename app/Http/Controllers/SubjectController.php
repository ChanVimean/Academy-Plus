<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::withCount('students')->get();
        $editSubject = null;

        if ($request->has('edit')) {
            $editSubject = Subject::find($request->edit);
        }

        return view('subjects.index', compact('subjects', 'editSubject'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:subjects,name']);

        Subject::create([
            'name' => $request->name,
            'user_id' => auth()->id(), // Assuming teachers manage their own classes
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created!');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate(['name' => 'required|string|unique:subjects,name,'.$subject->id]);

        $subject->update($request->only('name'));

        return redirect()->route('subjects.index')->with('success', 'Subject updated!');
    }

    public function destroy(Subject $subject)
    {
        // Deleting the subject will automatically detach students due to database constraints
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject/Class removed.');
    }
}
