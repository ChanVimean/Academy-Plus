<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($editTeacher) ? 'Edit Teacher' : 'Teacher Management' }}
            </h2>

            <form
                action="{{ isset($editTeacher) ? route('teachers.update', $editTeacher->id) : route('teachers.store') }}"
                method="POST" class="flex flex-wrap items-center gap-2 w-full xl:w-auto">
                @csrf
                @if (isset($editTeacher))
                    @method('PUT')
                @endif

                <x-text-input name="name" :value="old('name', $editTeacher->name ?? '')" placeholder="Full Name" class="text-sm" required />
                <x-text-input name="email" :value="old('email', $editTeacher->email ?? '')" type="email" placeholder="Email" class="text-sm"
                    required />

                @if (!isset($editTeacher))
                    <x-text-input name="password" type="password" placeholder="Password" class="text-sm" required />
                @endif

                <x-primary-button class="{{ isset($editTeacher) ? 'bg-orange-600' : 'bg-blue-500' }}">
                    {{ isset($editTeacher) ? 'Update' : '+ Add Teacher' }}
                </x-primary-button>

                @if (isset($editTeacher))
                    <a href="{{ route('teachers.index') }}" class="text-xs text-gray-500">Cancel</a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-end">
                <form action="{{ route('teachers.index') }}" method="GET" class="flex gap-2">
                    <x-text-input name="search" value="{{ request('search') }}" placeholder="Search by Name or ID..."
                        class="w-64 text-sm" />
                    <button type="submit" class="px-4 py-2 bg-sky-400 text-white rounded-md text-sm">Search</button>
                    @if (request('search'))
                        <a href="{{ route('teachers.index') }}"
                            class="px-4 py-2 bg-gray-200 rounded-md text-sm">Clear</a>
                    @endif
                </form>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-xs uppercase text-gray-500">ID</th>
                            <th class="p-4 text-xs uppercase text-gray-500">Teacher Name</th>
                            <th class="p-4 text-xs uppercase text-gray-500">Email</th>
                            <th class="p-4 text-end text-xs uppercase text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $teacher)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-500">#{{ $teacher->id }}</td>
                                <td class="p-4 font-bold">{{ $teacher->name }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $teacher->email }}</td>
                                <td class="p-4 text-center flex justify-evenly items-center gap-3">
                                    <a href="{{ route('teachers.index', ['edit' => $teacher->id]) }}"
                                        class="text-blue-600 text-sm">Edit</a>
                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this teacher?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
