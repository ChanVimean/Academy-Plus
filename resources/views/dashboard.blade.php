<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <li
                    class="group bg-white overflow-hidden shadow-sm sm:rounded-lg border border-transparent hover:border-blue-500 transition-all duration-200">
                    <a href="{{ route('subjects.index') }}" class="block p-6">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-500 transition-colors duration-200">
                                <span
                                    class="text-2xl group-hover:filter group-hover:brightness-0 group-hover:invert">📚</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Subjects</h3>
                                <p class="text-sm text-gray-500">Manage your classes</p>
                            </div>
                        </div>
                    </a>
                </li>

                <li
                    class="group bg-white overflow-hidden shadow-sm sm:rounded-lg border border-transparent hover:border-green-500 transition-all duration-200">
                    <a href="{{ route('students.index') }}" class="block p-6">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 bg-green-100 rounded-lg group-hover:bg-green-500 transition-colors duration-200">
                                <span
                                    class="text-2xl group-hover:filter group-hover:brightness-0 group-hover:invert">🎓</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Students</h3>
                                <p class="text-sm text-gray-500">Manage your roster</p>
                            </div>
                        </div>
                    </a>
                </li>

                <li
                    class="group bg-white overflow-hidden shadow-sm sm:rounded-lg border border-transparent hover:border-purple-500 transition-all duration-200">
                    <a href="{{ route('attendance.index') }}" class="block p-6">
                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-500 transition-colors duration-200">
                                <span
                                    class="text-2xl group-hover:filter group-hover:brightness-0 group-hover:invert">📋</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">History</h3>
                                <p class="text-sm text-gray-500">View past records</p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
