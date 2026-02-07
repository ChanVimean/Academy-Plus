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

                <x-text-input name="name" :value="old('name', $editStudent->name ?? '')" placeholder="Full Name" class="w-full md:w-48 text-sm"
                    required />

                <x-text-input name="student_id_number" :value="old('student_id_number', $editStudent->student_id_number ?? '')" placeholder="ID Number"
                    class="w-full md:w-40 text-sm" required />

                <x-primary-button
                    class="{{ $editStudent ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }}">
                    {{ $editStudent ? 'Update' : '+ Register' }}
                </x-primary-button>

                @if ($editStudent)
                    <a href="{{ route('students.index') }}" class="text-sm text-gray-500 underline hover:text-gray-700">
                        Cancel
                    </a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead class="border-b bg-gray-50 text-xs uppercase text-gray-600 font-bold">
                        <tr>
                            <th class="p-4">Name</th>
                            <th class="p-4">ID Number</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr
                                class="border-b hover:bg-gray-50 {{ isset($editStudent) && $editStudent->id == $student->id ? 'bg-orange-50' : '' }}">
                                <td class="p-4">{{ $student->name }}</td>
                                <td class="p-4 font-mono text-sm">{{ $student->student_id_number }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('students.index', ['edit' => $student->id]) }}"
                                        class="text-blue-600 hover:underline text-sm font-medium">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
