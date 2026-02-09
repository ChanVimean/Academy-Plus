<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                {{ isset($editSubject) ? 'Edit Class' : 'My Classes' }}
            </h2>

            <form
                action="{{ isset($editSubject) ? route('subjects.update', $editSubject->id) : route('subjects.store') }}"
                method="POST" class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
                @csrf
                @if (isset($editSubject))
                    @method('PUT')
                @endif

                <div class="flex flex-1 gap-2 min-w-[300px]">
                    <x-text-input name="name" :value="old('name', $editSubject->name ?? '')" placeholder="Subject (e.g. Law)" class="flex-1 text-sm"
                        required />

                    <x-text-input name="section" :value="old('section', $editSubject->section ?? '')" placeholder="Section (e.g. A)"
                        class="w-24 text-sm" />

                    <x-text-input name="room" :value="old('room', $editSubject->room ?? '')" placeholder="Room" class="w-24 text-sm" />
                </div>

                <div class="flex items-center gap-2">
                    <x-primary-button
                        class="whitespace-nowrap {{ isset($editSubject) ? 'bg-orange-600 hover:bg-orange-700' : '' }}">
                        {{ isset($editSubject) ? 'Update' : '+ Add Class' }}
                    </x-primary-button>

                    @if (isset($editSubject))
                        <a href="{{ route('subjects.index') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                    @endif
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($subjects->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No classes assigned to you yet. Create one above! 👆</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="border-b bg-gray-50">
                                    <tr class="text-xs uppercase text-gray-500">
                                        <th class="p-4">Subject & Details</th>
                                        @if (auth()->user()->is_admin)
                                            <th class="p-4">Teacher</th>
                                        @endif
                                        <th class="p-4">Section</th>
                                        <th class="p-4">Room</th>
                                        <th class="p-4 text-center">Students</th>
                                        <th class="p-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $subject)
                                        <tr
                                            class="border-b hover:bg-gray-50 transition {{ isset($editSubject) && $editSubject->id == $subject->id ? 'bg-orange-50' : '' }}">
                                            <td class="p-4 font-bold text-indigo-700">
                                                {{ $subject->name }}
                                            </td>
                                            @if (auth()->user()->is_admin)
                                                <td class="p-4">
                                                    <div class="flex items-center gap-2">
                                                        <div
                                                            class="h-7 w-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-[10px] font-bold">
                                                            {{ substr($subject->teacher->name, 0, 1) }}
                                                        </div>
                                                        <span
                                                            class="text-sm font-medium text-gray-700">{{ $subject->teacher->name }}</span>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="p-4">
                                                <span class="px-2 py-1 bg-gray-100 rounded text-xs text-gray-600">
                                                    {{ $subject->section ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-sm text-gray-600">
                                                {{ $subject->room ?? '-' }}
                                            </td>
                                            <td class="p-4 text-center text-sm font-semibold">
                                                {{ $subject->students_count }}
                                            </td>
                                            <td class="p-4 text-right flex justify-end items-center gap-4">
                                                <a href="{{ route('attendance.take', $subject->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-[10px] text-white uppercase tracking-widest hover:bg-green-700 shadow-sm">
                                                    📝 Take Attendance
                                                </a>

                                                <a href="{{ route('subjects.index', ['edit' => $subject->id]) }}"
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-bold uppercase tracking-tighter">
                                                    Edit
                                                </a>

                                                <form action="{{ route('subjects.destroy', $subject->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Delete this class? This will wipe all attendance data for this specific section.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-600 hover:text-red-800 font-bold uppercase tracking-tighter">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
