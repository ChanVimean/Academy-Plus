<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                    {{ isset($editStudent) ? '📝 Edit Student Profile' : '🎓 Student Registry' }}
                </h2>
            </div>

            <form
                action="{{ isset($editStudent) ? route('students.update', $editStudent->id) : route('students.store') }}"
                method="POST"
                class="bg-white p-6 rounded-xl shadow-md border border-gray-200 flex flex-col lg:flex-row gap-8 items-stretch">
                @csrf
                @if (isset($editStudent))
                    @method('PUT')
                @endif

                <div class="lg:w-1/3 flex flex-col justify-between">
                    <div>
                        <x-input-label for="name" value="Student Full Name" class="text-gray-500 font-bold mb-1" />
                        <x-text-input name="name" :value="old('name', $editStudent->name ?? '')"
                            class="block w-full border-gray-200 focus:ring-indigo-500" placeholder="e.g. John Smith"
                            required />
                        <p class="mt-2 text-xs text-gray-400">Enter the student's legal name as it appears on school
                            records.</p>
                    </div>

                    <div class="mt-6">
                        <x-primary-button
                            class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg">
                            {{ isset($editStudent) ? 'Update Student' : 'Register Student' }}
                        </x-primary-button>
                        @if (isset($editStudent))
                            <a href="{{ route('students.index') }}"
                                class="block text-center mt-2 text-xs text-gray-500 hover:underline">Cancel and go
                                back</a>
                        @endif
                    </div>
                </div>

                <div class="flex-1 border-l border-gray-100 lg:pl-8">
                    <div class="flex justify-between items-center mb-3">
                        <x-input-label value="Class Enrollment" class="text-gray-500 font-bold" />
                        <input type="text" id="subjectSearch" placeholder="🔍 Search classes..."
                            class="w-56 text-xs border-gray-200 bg-gray-50 rounded-full px-4 py-1.5 focus:ring-indigo-500">
                    </div>

                    <div id="subjectList"
                        class="border border-gray-200 rounded-xl bg-gray-50 p-2 max-h-64 overflow-y-auto shadow-inner">
                        <div class="space-y-2">
                            @foreach ($subjects as $subject)
                                <label
                                    class="subject-item flex items-center p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-indigo-400 transition-all group"
                                    title="{{ $subject->name }}">

                                    <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"
                                        {{ isset($editStudent) && $editStudent->subjects->contains($subject->id) ? 'checked' : '' }}
                                        class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">

                                    <div class="ml-4 flex flex-col flex-1 overflow-hidden">
                                        <span
                                            class="subject-name text-sm font-bold text-gray-700 group-hover:text-indigo-700 truncate">
                                            {{ $subject->name }}
                                        </span>
                                        <span class="text-[11px] text-gray-400 uppercase tracking-tight">
                                            Instructor: {{ $subject->teacher->name }}
                                        </span>
                                    </div>

                                    <div class="ml-auto px-3">
                                        <span class="text-[10px] font-bold py-1 px-2 rounded bg-gray-100 text-gray-500">
                                            {{ $subject->section }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('subjectSearch').addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('.subject-item').forEach(item => {
                    const text = item.querySelector('.subject-name').textContent.toLowerCase();
                    item.style.display = text.includes(term) ? 'flex' : 'none';
                });
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-100 p-4 rounded-t-lg border-b flex flex-wrap gap-4 items-center justify-between">
                <div class="text-sm font-bold text-gray-600 uppercase tracking-widest">Filters</div>
                <form action="{{ route('students.index') }}" method="GET" class="flex flex-wrap gap-3">
                    <x-text-input name="search_name" value="{{ request('search_name') }}"
                        placeholder="Search by name..." class="text-sm w-48" />

                    <select name="filter_subject" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All Classes</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ request('filter_subject') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-bold">Apply</button>
                    @if (request('search_name') || request('filter_subject'))
                        <a href="{{ route('students.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm">Clear</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-b-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Student</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Enrolled Classes</th>
                            <th class="p-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-400">ID: #{{ $student->id }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($student->subjects as $subject)
                                            <span
                                                class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-[10px] font-bold rounded border border-blue-200">
                                                {{ $subject->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400 italic">No Enrolled Classes</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('students.index', ['edit' => $student->id]) }}"
                                            class="text-blue-500 hover:text-blue-700 text-sm font-semibold">Edit</a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            onsubmit="return confirm('Delete record?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-400 hover:text-red-600 text-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-gray-400">No students found for this
                                    search.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
