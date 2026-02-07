<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                My Subjects
            </h2>

            <form action="{{ route('subjects.store') }}" method="POST" class="flex items-center gap-2 w-full md:w-auto">
                @csrf
                <x-text-input name="name" placeholder="Enter Subject Name (e.g. Math 101)"
                    class="w-full md:w-64 text-sm" required />
                <x-primary-button class="whitespace-nowrap">
                    + Add Subject
                </x-primary-button>
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
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 font-medium">{{ $subject->name }}</td>
                                        <td class="p-4 text-right">
                                            <a href="{{ route('attendance.take', $subject->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                                📝 Take Attendance
                                            </a>
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
