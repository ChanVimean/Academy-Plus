<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📋 Attendance Reporting Engine</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('attendance.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label value="Search Student" class="text-[10px] font-bold" />
                        <x-text-input name="search_student" value="{{ request('search_student') }}"
                            placeholder="Enter name..." class="w-full text-sm" />
                    </div>

                    <div class="w-48">
                        <x-input-label value="Class" class="text-[10px] font-bold" />
                        <select name="filter_subject" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All Subjects</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ request('filter_subject') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-40">
                        <x-input-label value="Status" class="text-[10px] font-bold" />
                        <select name="filter_status" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Any Status</option>
                            <option value="present" {{ request('filter_status') == 'present' ? 'selected' : '' }}>
                                Present</option>
                            <option value="absent" {{ request('filter_status') == 'absent' ? 'selected' : '' }}>Absent
                            </option>
                            <option value="late" {{ request('filter_status') == 'late' ? 'selected' : '' }}>Late
                            </option>
                        </select>
                    </div>

                    <x-primary-button class="h-10">Filter</x-primary-button>
                    @if (request()->anyFilled(['search_student', 'filter_subject', 'filter_status']))
                        <a href="{{ route('attendance.index') }}"
                            class="text-xs text-gray-400 hover:text-gray-600 mb-2 underline">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-[10px] uppercase text-gray-400 font-black tracking-widest">
                            <th class="p-4">Date & Time</th>
                            <th class="p-4">Student</th>
                            <th class="p-4">Subject</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($history as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-500">{{ $log->created_at->format('M d, Y') }} <span
                                        class="text-[10px] block opacity-50">{{ $log->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="p-4 font-bold text-gray-800">{{ $log->student->name }}</td>
                                <td class="p-4 text-sm text-indigo-600">{{ $log->subject->name }}</td>
                                <td class="p-4 text-center">
                                    @php
                                        $colors = [
                                            'present' => 'bg-green-100 text-green-700',
                                            'absent' => 'bg-red-100 text-red-700',
                                            'late' => 'bg-orange-100 text-orange-700',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $colors[$log->status] ?? 'bg-gray-100' }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 bg-gray-50 border-t">
                    {{ $history->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
