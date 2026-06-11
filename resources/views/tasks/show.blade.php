<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Task Details') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition shadow-md">
                    {{ __('Edit Task') }}
                </a>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-8">
                        
                        <!-- Main Details -->
                        <div class="flex-1 space-y-6">
                            <div>
                                <div class="flex items-center space-x-3 mb-2 flex-wrap gap-y-2">
                                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Task Title') }}</span>
                                    
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
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $task->title }}</h3>
                            </div>

                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">{{ __('Description') }}</h4>
                                <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/40 rounded-lg p-4 border border-gray-100 dark:border-gray-700/80">
                                    {!! nl2br(e($task->description ?? __('No description provided.'))) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar / Meta Details -->
                        <div class="w-full lg:w-80 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-xl p-6 space-y-6">
                            
                            <!-- Project Info -->
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">{{ __('Parent Project') }}</h4>
                                @if($task->project)
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-150 dark:border-gray-700 shadow-sm">
                                        <a href="{{ route('projects.show', $task->project->id) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 block truncate">
                                            {{ $task->project->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $task->project->location ?? __('No location') }}</p>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500 italic">{{ __('None') }}</span>
                                @endif
                            </div>

                            <!-- Assignee Info -->
                            <div>
                                <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">{{ __('Assigned To') }}</h4>
                                @if($task->assignee)
                                    <div class="flex items-center space-x-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-150 dark:border-gray-700 shadow-sm">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $task->assignee->profile_photo_url }}" alt="{{ $task->assignee->name }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('users.show', $task->assignee->id) }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:underline truncate block">
                                                {{ $task->assignee->name }}
                                            </a>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 truncate block">{{ $task->assignee->email }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-150 dark:border-gray-700 shadow-sm text-center">
                                        <span class="text-sm text-gray-500 italic">{{ __('Unassigned') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Meta timeline -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                <p><span class="font-medium">{{ __('Created At:') }}</span> {{ $task->created_at->format('M d, Y H:i') }}</p>
                                <p><span class="font-medium">{{ __('Updated At:') }}</span> {{ $task->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
