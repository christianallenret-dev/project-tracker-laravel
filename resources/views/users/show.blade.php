<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Profile') }}
            </h2>
            @can('manage-tasks')
                <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition shadow-md">
                    {{ __('Edit User') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile Header Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <div class="flex-shrink-0">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900 shadow-md" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <div class="flex flex-wrap items-center gap-2 justify-center sm:justify-start">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                @if($user->is_manager)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                        {{ __('Manager') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ __('Collaborator') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ __('Member since') }} {{ $user->created_at->format('F d, Y') }}</p>
                        </div>

                        {{-- Stats Row --}}
                        <div class="flex gap-6 sm:gap-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $activeProjects->count() }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 whitespace-nowrap">{{ __('Active Projects') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $finishedProjects->count() }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 whitespace-nowrap">{{ __('Done Projects') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-orange-500 dark:text-orange-400">{{ $activeTasks->count() }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 whitespace-nowrap">{{ __('Active Tasks') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $finishedTasks->count() }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 whitespace-nowrap">{{ __('Done Tasks') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Active Projects --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 pb-3 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="inline-block w-2 h-2 bg-indigo-500 rounded-full"></span>
                            {{ __('Active Projects') }}
                            <span class="ml-auto text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded-full">{{ $activeProjects->count() }}</span>
                        </h4>
                        @forelse($activeProjects as $project)
                            <div class="p-3 border border-gray-100 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition mb-3 last:mb-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('projects.show', $project->id) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 block truncate">
                                            {{ $project->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->location ?? __('No location') }}</p>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 capitalize">
                                            {{ $project->pivot->role ?? '—' }}
                                        </span>
                                        @if($project->pivot->assigned_at)
                                            <span class="text-xs text-gray-400 dark:text-gray-500">From {{ \Carbon\Carbon::parse($project->pivot->assigned_at)->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 py-6 text-center italic">{{ __('No active projects.') }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Finished Projects --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 pb-3 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="inline-block w-2 h-2 bg-emerald-500 rounded-full"></span>
                            {{ __('Completed Projects') }}
                            <span class="ml-auto text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">{{ $finishedProjects->count() }}</span>
                        </h4>
                        @forelse($finishedProjects as $project)
                            <div class="p-3 border border-gray-100 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition mb-3 last:mb-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('projects.show', $project->id) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 block truncate">
                                            {{ $project->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->location ?? __('No location') }}</p>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 capitalize">
                                            {{ $project->pivot->role ?? '—' }}
                                        </span>
                                        @if($project->pivot->ended_at)
                                            <span class="text-xs text-gray-400 dark:text-gray-500">Ended {{ \Carbon\Carbon::parse($project->pivot->ended_at)->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 py-6 text-center italic">{{ __('No completed projects.') }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Active Tasks --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 pb-3 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="inline-block w-2 h-2 bg-orange-500 rounded-full"></span>
                            {{ __('Active Tasks') }}
                            <span class="ml-auto text-xs font-medium text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 px-2 py-0.5 rounded-full">{{ $activeTasks->count() }}</span>
                        </h4>
                        @forelse($activeTasks as $task)
                            <div class="p-3 border border-gray-100 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition mb-3 last:mb-0 flex items-center justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 block truncate">
                                        {{ $task->title }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-1">{{ $task->project ? $task->project->name : '—' }}</p>
                                </div>
                                @if($task->status === 'in_progress')
                                    <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">{{ __('In Progress') }}</span>
                                @else
                                    <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300">{{ __('Pending') }}</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 py-6 text-center italic">{{ __('No active tasks.') }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Finished Tasks --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 pb-3 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="inline-block w-2 h-2 bg-emerald-500 rounded-full"></span>
                            {{ __('Completed Tasks') }}
                            <span class="ml-auto text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">{{ $finishedTasks->count() }}</span>
                        </h4>
                        @forelse($finishedTasks as $task)
                            <div class="p-3 border border-gray-100 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition mb-3 last:mb-0 flex items-center justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 block truncate line-through decoration-gray-300">
                                        {{ $task->title }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-1">{{ $task->project ? $task->project->name : '—' }}</p>
                                </div>
                                <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">{{ __('Done') }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 py-6 text-center italic">{{ __('No completed tasks yet.') }}</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
