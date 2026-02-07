<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance History
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">

                @if ($history->isEmpty())
                    <p class="text-center py-4 text-gray-500 italic">No attendance records yet.</p>
                @else
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b bg-gray-50 text-xs uppercase text-gray-600 font-bold">
                                <th class="p-4">Date</th>
                                <th class="p-4">Student</th>
                                <th class="p-4">Subject</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $record)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-sm">{{ $record->attendance_date }}</td>
                                    <td class="p-4 font-medium">{{ $record->student->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $record->subject->name }}</td>
                                    <td class="p-4 text-center">
                                        @php
                                            $color = match ($record->status) {
                                                'present' => 'bg-green-100 text-green-700',
                                                'late' => 'bg-orange-100 text-orange-700',
                                                'absent' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $color }}">
                                            {{ $record->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $history->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
