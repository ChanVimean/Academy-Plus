<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Attendance History
            </h2>

            <form action="{{ route('attendance.index') }}" method="GET" class="flex items-center gap-2">
                <select name="subject_id" onchange="this.form.submit()"
                    class="rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500">
                    <option value="">All Subjects</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
                @if (request('subject_id'))
                    <a href="{{ route('attendance.index') }}" class="text-xs text-red-500 hover:underline">Clear
                        Filter</a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($history->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 italic">No attendance records found for this selection.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-xs uppercase text-gray-600 font-bold border-b">
                                        <th class="p-4">Date</th>
                                        <th class="p-4">Student</th>
                                        <th class="p-4">Subject</th>
                                        <th class="p-4">Status</th>
                                        <th class="p-4">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $record)
                                        <tr class="border-b hover:bg-gray-50 transition">
                                            <td class="p-4 text-sm whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}
                                            </td>
                                            <td class="p-4 font-bold text-gray-800">
                                                {{ $record->student->name }}
                                            </td>
                                            <td class="p-4">
                                                <span
                                                    class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] rounded border border-blue-100 uppercase font-semibold">
                                                    {{ $record->subject->name }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                @php
                                                    $color = match ($record->status) {
                                                        'present' => 'bg-green-100 text-green-700 border-green-200',
                                                        'late' => 'bg-orange-100 text-orange-700 border-orange-200',
                                                        'absent' => 'bg-red-100 text-red-700 border-red-200',
                                                        default => 'bg-gray-100 text-gray-700 border-gray-200',
                                                    };
                                                @endphp
                                                <span
                                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $color }}">
                                                    {{ $record->status }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-sm text-gray-500 italic">
                                                {{ $record->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $history->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
