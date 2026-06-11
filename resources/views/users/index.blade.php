<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users') }}
            </h2>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition shadow-md">
                {{ __('+ Create User') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-r shadow dark:bg-emerald-800/20 dark:text-emerald-300 dark:border-emerald-600" role="alert">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r shadow dark:bg-red-800/20 dark:text-red-300 dark:border-red-600" role="alert">
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        {{ __('User Directory') }}
                    </h3>

                    @if($users->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No users found in the system.') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-900/50">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('User') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Role') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Projects') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Tasks Assigned') }}</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_manager)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                                        {{ __('Manager') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                        {{ __('Collaborator') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->projects_count }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->tasks_count }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center space-x-3 justify-end">
                                                    <a href="{{ route('users.show', $user->id) }}" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300">
                                                        {{ __('View') }}
                                                    </a>
                                                    <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    @if(auth()->id() !== $user->id)
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 dark:text-gray-500 italic text-xs">{{ __('You') }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
