<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $editStudent ? 'Edit Student' : 'Student Registry' }}
            </h2>

            <form action="{{ $editStudent ? route('students.update', $editStudent->id) : route('students.store') }}"
                method="POST" class="flex flex-wrap md:flex-nowrap items-center gap-2 w-full md:w-auto">
                @csrf
                @if ($editStudent)
                    @method('PUT')
                @endif

                <x-text-input name="name" :value="old('name', $editStudent->name ?? '')" placeholder="Student Full Name"
                    class="w-full md:w-64 text-sm" required />

                <select name="subject_id"
                    class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <option value="">-- Assign Class --</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ isset($editStudent) && $editStudent->subjects->contains($subject->id) ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>

                <x-primary-button class="{{ $editStudent ? 'bg-orange-600' : 'bg-green-600' }}">
                    {{ $editStudent ? 'Update' : '+ Register' }}
                </x-primary-button>

                @if ($editStudent)
                    <a href="{{ route('students.index') }}" class="text-sm text-gray-500 underline">Cancel</a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead class="border-b bg-gray-50 text-xs uppercase text-gray-600 font-bold">
                        <tr>
                            <th class="p-4 w-24">ID</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Class</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-mono text-sm text-gray-400">
                                    #{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="p-4 font-bold text-gray-800">{{ $student->name }}</td>
                                <td class="p-4">
                                    @foreach ($student->subjects as $sub)
                                        <span
                                            class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded border border-blue-200">
                                            {{ $sub->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-4">
                                        <a href="{{ route('students.index', ['edit' => $student->id]) }}"
                                            class="text-indigo-600 text-sm hover:underline">Edit</a>

                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this student?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 text-sm hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-gray-500 italic">No students registered
                                    yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
