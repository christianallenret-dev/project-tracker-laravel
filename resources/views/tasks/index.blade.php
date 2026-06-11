<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tasks') }}
            </h2>
            @can('manage-tasks')
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition shadow-md">
                    {{ __('+ Create Task') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-r shadow dark:bg-emerald-800/20 dark:text-emerald-300 dark:border-emerald-600" role="alert">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        {{ __('All Tasks') }}
                    </h3>

                    @if($tasks->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __('No tasks found') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                @can('manage-tasks')
                                    {{ __('Get started by creating a new task.') }}
                                @else
                                    {{ __('There are no tasks assigned to the system right now.') }}
                                @endcan
                            </p>
                            @can('manage-tasks')
                                <div class="mt-6">
                                    <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition">
                                        {{ __('New Task') }}
                                    </a>
                                </div>
                            @endcan
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-900/50">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Title') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Project') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Assignee') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($tasks as $task)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-sm text-gray-900 dark:text-gray-100">{{ $task->title }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $task->description }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                @if($task->project)
                                                    <a href="{{ route('projects.show', $task->project->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                                        {{ $task->project->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">{{ __('N/A') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                @if($task->assignee)
                                                    <div class="flex items-center space-x-2">
                                                        <img class="h-6 w-6 rounded-full object-cover" src="{{ $task->assignee->profile_photo_url }}" alt="{{ $task->assignee->name }}">
                                                        <a href="{{ route('users.show', $task->assignee->id) }}" class="hover:underline">{{ $task->assignee->name }}</a>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 italic">{{ __('Unassigned') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($task->status === 'done')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                        {{ __('Done') }}
                                                    </span>
                                                @elseif($task->status === 'in_progress')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                                        {{ __('In Progress') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-300">
                                                        {{ __('Pending') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center space-x-3 justify-end">
                                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300">
                                                        {{ __('View') }}
                                                    </a>
                                                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    @can('manage-tasks')
                                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $tasks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
