<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Take Attendance for: <span class="text-blue-600">{{ $subject->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('attendance.store', $subject->id) }}" method="POST">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="mb-6 flex items-center gap-4 border-b pb-4">
                        <x-input-label for="date" value="Date:" />
                        <x-text-input id="date" name="date" type="date" value="{{ date('Y-m-d') }}"
                            required />
                    </div>

                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs uppercase text-gray-500 border-b">
                                <th class="p-4">Student Name</th>
                                <th class="p-4 text-center text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 font-medium">{{ $student->name }}</td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-3">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[{{ $student->id }}]" value="present"
                                                    class="peer hidden" checked>
                                                <span
                                                    class="px-4 py-2 rounded border text-xs font-bold transition-all peer-checked:bg-green-600 peer-checked:text-white border-green-600 text-green-600">PRESENT</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[{{ $student->id }}]" value="late"
                                                    class="peer hidden">
                                                <span
                                                    class="px-4 py-2 rounded border text-xs font-bold transition-all peer-checked:bg-orange-500 peer-checked:text-white border-orange-500 text-orange-500">LATE</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[{{ $student->id }}]" value="absent"
                                                    class="peer hidden">
                                                <span
                                                    class="px-4 py-2 rounded border text-xs font-bold transition-all peer-checked:bg-red-600 peer-checked:text-white border-red-600 text-red-600">ABSENT</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <x-text-input name="notes[{{ $student->id }}]" placeholder="Reason..."
                                            class="w-full text-sm" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-8 flex justify-end">
                        <x-primary-button>Save Attendance</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
