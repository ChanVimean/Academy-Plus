<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                {{ isset($editSubject) ? 'Edit Subject' : 'My Subjects' }}
            </h2>

            <form
                action="{{ isset($editSubject) ? route('subjects.update', $editSubject->id) : route('subjects.store') }}"
                method="POST" class="flex items-center gap-2 w-full md:w-auto">
                @csrf
                @if (isset($editSubject))
                    @method('PUT')
                @endif

                <x-text-input name="name" :value="old('name', $editSubject->name ?? '')" placeholder="Enter Subject Name (e.g. Math 101)"
                    class="w-full md:w-64 text-sm" required />

                <x-primary-button
                    class="whitespace-nowrap {{ isset($editSubject) ? 'bg-orange-600 hover:bg-orange-700' : '' }}">
                    {{ isset($editSubject) ? 'Update Subject' : '+ Add Subject' }}
                </x-primary-button>

                @if (isset($editSubject))
                    <a href="{{ route('subjects.index') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($subjects->isEmpty())
                        <p class="text-center text-gray-500 py-4">No subjects found. Add one above! 👆</p>
                    @else
                        <table class="w-full text-left">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="p-4">Subject Name</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr
                                        class="border-b hover:bg-gray-50 transition {{ isset($editSubject) && $editSubject->id == $subject->id ? 'bg-orange-50' : '' }}">
                                        <td class="p-4 font-medium">{{ $subject->name }}</td>
                                        <td class="p-4 text-right flex justify-end items-center gap-3">
                                            <a href="{{ route('attendance.take', $subject->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-[10px] text-white uppercase tracking-widest hover:bg-green-700">
                                                📝 Take Attendance
                                            </a>

                                            <a href="{{ route('subjects.index', ['edit' => $subject->id]) }}"
                                                class="text-sm text-blue-600 hover:underline font-medium">
                                                Edit
                                            </a>

                                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                                onsubmit="return confirm('Deleting this subject will remove all enrollment and attendance records. Continue?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-sm text-red-600 hover:underline font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
