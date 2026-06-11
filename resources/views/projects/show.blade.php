<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Project Details') }}: {{ $project->name }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition shadow-md">
                    {{ __('Edit Project') }}
                </a>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Project Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $project->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                                <span class="font-semibold">{{ __('Created:') }}</span> {{ $project->created_at->format('M d, Y') }}
                                @if($project->updated_at != $project->created_at)
                                    <span class="mx-2">•</span> <span class="font-semibold">{{ __('Updated:') }}</span> {{ $project->updated_at->format('M d, Y') }}
                                @endif
                            </p>
                            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                                {!! nl2br(e($project->description ?? __('No description provided.'))) !!}
                            </div>
                        </div>

                        <!-- Info Sidebar/Meta tags -->
                        <div class="w-full lg:w-72 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 space-y-4">
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Location') }}</h4>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mt-1 flex items-center">
                                    <svg class="mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $project->location ?? __('N/A') }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Target Date') }}</h4>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mt-1 flex items-center">
                                    <svg class="mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $project->date ? $project->date->format('F d, Y') : __('N/A') }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Team Capacity') }}</h4>
                                <div class="flex items-center justify-between text-sm mt-1">
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Filled Slots') }}</span>
                                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $project->users->count() }} / {{ $project->slots }}</span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full mt-2 overflow-hidden">
                                    @php
                                        $percent = $project->slots > 0 ? min(100, ($project->users->count() / $project->slots) * 100) : 0;
                                    @endphp
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Assigned Users List -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg lg:col-span-1">
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                            {{ __('Team Members') }} ({{ $project->users->count() }})
                        </h4>
                        
                        @if($project->users->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400 py-4 text-center">{{ __('No team members assigned.') }}</p>
                        @else
                            <ul class="divide-y divide-gray-150 dark:divide-gray-700">
                                @foreach($project->users as $user)
                                    <li class="py-3 flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('users.show', $user->id) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 truncate block">
                                                {{ $user->name }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                        </div>
                                        @if($user->is_manager)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                                {{ __('Manager') }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Associated Tasks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2">
                    <div class="p-6">
                        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Project Tasks') }} ({{ $project->tasks->count() }})
                            </h4>
                            @can('manage-tasks')
                                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    {{ __('+ Add Task') }}
                                </a>
                            @endcan
                        </div>

                        @if($project->tasks->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400 py-8 text-center">{{ __('No tasks created for this project.') }}</p>
                        @else
                            <div class="space-y-3">
                                @foreach($project->tasks as $task)
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition flex items-center justify-between">
                                        <div class="min-w-0 flex-1 pr-4">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 block truncate">
                                                {{ $task->title }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                                                {{ __('Assignee:') }} <span class="font-medium">{{ $task->assignee ? $task->assignee->name : __('Unassigned') }}</span>
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
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
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-xs font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                                                {{ __('Edit') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
