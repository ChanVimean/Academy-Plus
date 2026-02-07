<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance for: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div class="mb-6 flex items-center gap-4 border-b pb-6">
                        <x-input-label for="date" :value="__('Select Date:')" />
                        <x-text-input id="date" name="date" type="date" value="{{ date('Y-m-d') }}"
                            required />
                    </div>

                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs uppercase text-gray-500 font-bold border-b">
                                <th class="p-4">Student</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800">{{ $student->name }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $student->student_id_number }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-2">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="attendances[{{ $student->id }}][status]"
                                                    value="present" class="peer hidden" checked>
                                                <span
                                                    class="px-4 py-2 rounded border text-xs font-bold uppercase transition-all peer-checked:bg-green-600 peer-checked:text-white hover:bg-gray-100">
                                                    Present
                                                </span>
                                            </label>

                                            <label class="cursor-pointer">
                                                <input type="radio" name="attendances[{{ $student->id }}][status]"
                                                    value="late" class="peer hidden">
                                                <span
                                                    class="px-4 py-2 rounded border text-xs font-bold uppercase transition-all peer-checked:bg-orange-500 peer-checked:text-white hover:bg-gray-100">
                                                    Late
                                                </span>
                                            </label>

                                            <label class="cursor-pointer">
                                                <input type="radio" name="attendances[{{ $student->id }}][status]"
                                                    value="absent" class="peer hidden">
                                                <span
                                                    class="px-4 py-2 rounded border text-xs font-bold uppercase transition-all peer-checked:bg-red-600 peer-checked:text-white hover:bg-gray-100">
                                                    Absent
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-8 flex justify-end gap-4 items-center">
                        <a href="{{ route('subjects.index') }}" class="text-sm text-gray-600 underline">Cancel</a>
                        <x-primary-button class="bg-blue-600 px-10">
                            Save Attendance Record
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
