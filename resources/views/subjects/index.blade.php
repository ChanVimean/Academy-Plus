<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($editSubject) ? 'Edit Class' : 'Class Management' }}
            </h2>

            <form
                action="{{ isset($editSubject) ? route('subjects.update', $editSubject->id) : route('subjects.store') }}"
                method="POST" class="flex flex-wrap gap-2">
                @csrf
                @if (isset($editSubject))
                    @method('PUT')
                @endif

                <x-text-input name="name" :value="old('name', $editSubject->name ?? '')" placeholder="Subject Name" required />
                <x-text-input name="section" :value="old('section', $editSubject->section ?? '')" placeholder="Section" class="w-24" />
                <x-text-input name="room" :value="old('room', $editSubject->room ?? '')" placeholder="Room" class="w-24" />

                @if (auth()->user()->is_admin)
                    <select name="user_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                        required>
                        <option value="">Assign Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('user_id', $editSubject->user_id ?? '') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                @endif

                <x-primary-button class="{{ isset($editSubject) ? 'bg-orange-600 hover:bg-orange-700' : '' }}">
                    {{ isset($editSubject) ? 'Update' : 'Add Class' }}
                </x-primary-button>

                @if (isset($editSubject))
                    <a href="{{ route('subjects.index') }}"
                        class="py-2 text-gray-400 hover:text-gray-600 text-sm">Cancel</a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search --}}
            <div class="mb-6 flex justify-end">
                <form action="{{ route('subjects.index') }}" method="GET" class="flex gap-2">
                    <x-text-input name="search" value="{{ request('search') }}"
                        placeholder="Search Class or Professor..." class="w-80" />
                    <button type="submit"
                        class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">Filter</button>
                    @if (request('search'))
                        <a href="{{ route('subjects.index') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Clear</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    {{-- Table Head --}}
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-xs uppercase text-gray-500 font-bold">
                            <th class="p-4">Class Detail</th>
                            <th class="p-4">Professor</th>
                            <th class="p-4 text-center">Students</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    {{-- Table Body --}}
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">
                                    <div class="text-indigo-600 font-bold text-lg">{{ $subject->name }}</div>
                                    <div class="text-xs text-gray-500">Section: {{ $subject->section ?? 'N/A' }} |
                                        Room: {{ $subject->room ?? 'N/A' }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                            {{ strtoupper(substr($subject->teacher->name, 0, 1)) }}
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700">{{ $subject->teacher->name }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold border border-blue-200">
                                        {{ $subject->students_count }} Enrolled
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-evenly items-center gap-3">

                                        <a href="{{ route('attendance.take', $subject->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <i class="fa-solid fa-check"></i>
                                            <span class="ms-2">Attendance</span>
                                        </a>

                                        @if (auth()->user()->is_admin)
                                            <a href="{{ route('subjects.index', ['edit' => $subject->id]) }}"
                                                class="text-sm font-medium text-blue-600 hover:text-blue-900 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this class?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-sm font-medium text-red-500 hover:text-red-700 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400">No classes found matching your
                                    criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
