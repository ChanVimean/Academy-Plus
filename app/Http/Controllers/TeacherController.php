<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        // Filter by Name or ID
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        $teachers = $query->get();
        $editTeacher = null;

        if ($request->has('edit')) {
            $editTeacher = User::where('is_admin', false)->find($request->edit);
        }

        return view('teachers.index', compact('teachers', 'editTeacher'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added!');
    }

    public function update(Request $request, User $teacher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
        ]);

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated!');
    }

    public function destroy(User $teacher)
    {
        // Prevent accidental admin deletion if route isn't protected perfectly
        if ($teacher->is_admin) abort(403);

        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher removed.');
    }
}
