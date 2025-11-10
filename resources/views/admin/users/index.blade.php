<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            {{-- Back Button --}}
            <a href="{{ route('experiences.index') }}" 
               class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700">
                ← Back
            </a>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User List') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-3 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Summary / Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                {{-- Total Users --}}
                <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow text-center sm:text-left">
                    <h3 class="text-base sm:text-lg font-semibold">Total Users</h3>
                    <p class="text-xl sm:text-2xl font-bold mt-1">{{ $users->count() }}</p>
                </div>

                {{-- Logins Today --}}
                <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow text-center sm:text-left">
                    <h3 class="text-base sm:text-lg font-semibold">Logins Today</h3>
                    <p class="text-xl sm:text-2xl font-bold mt-1">{{ $todayLogins->count() }}</p>
                    <button 
                        type="button"
                        onclick="toggleTable('today-login-table')" 
                        class="mt-3 bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 text-sm sm:text-base w-full sm:w-auto transition">
                        View Details
                    </button>
                </div>

                {{-- Actions --}}
                <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow flex flex-col sm:flex-row sm:items-center sm:justify-between text-center sm:text-left">
                    <div class="mb-2 sm:mb-0">
                        <h3 class="text-base sm:text-lg font-semibold">Actions</h3>
                        <p class="text-xs sm:text-sm text-gray-500">Add a new user</p>
                    </div>
                    <a href="{{ route('users.create') }}" 
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm sm:text-base w-full sm:w-auto">
                        Create User
                    </a>
                </div>
            </div>

            {{-- All Users Table --}}
            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow">
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">All Users</h3>

                <div class="overflow-x-auto -mx-2 sm:mx-0">
                    <table class="min-w-full table-auto text-xs sm:text-sm md:text-base">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr class="border-b">
                                <th class="px-3 py-2 text-left whitespace-nowrap">No</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Created At</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Name</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Email</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Role</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $key + 1 }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $user->created_at }}</td>
                                    <td class="px-3 py-2">{{ $user->name }}</td>
                                    <td class="px-3 py-2">{{ $user->email }}</td>
                                    <td class="px-3 py-2">{{ $user->role }}</td>
                                    <td class="px-3 py-2 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <i class="fas fa-edit text-base sm:text-lg"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                                <i class="fas fa-trash text-base sm:text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

            {{-- Users Logged in Today --}}
            <div id="today-login-table" class="hidden bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow transition-all duration-500">
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Users Logged in Today</h3>
                <div class="overflow-x-auto -mx-2 sm:mx-0">
                    <table class="min-w-full table-auto text-xs sm:text-sm md:text-base">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr class="border-b">
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-left">Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayLogins as $user)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $user->name }}</td>
                                    <td class="px-3 py-2">{{ $user->email }}</td>
                                    <td class="px-3 py-2">
                                        {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">No users logged in today</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Script --}}
    <script>
        function toggleTable(id) {
            const el = document.getElementById(id);
            if (!el) return console.error("Table not found:", id);

            el.classList.toggle('hidden');

            if (!el.classList.contains('hidden')) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>
</x-app-layout>
