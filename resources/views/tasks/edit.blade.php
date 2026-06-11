<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Task') }}: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    
                    @cannot('manage-tasks')
                        <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-700 rounded shadow dark:bg-amber-900/10 dark:text-amber-300 dark:border-amber-600">
                            <p class="text-sm font-semibold flex items-center">
                                <svg class="mr-2 h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                {{ __('You are in Collaborator view. Only managers can edit task details or reassign team members. You can only update the task status.') }}
                            </p>
                        </div>
                    @endcannot

                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Task Title -->
                        <div>
                            <x-label for="title" value="{{ __('Task Title') }}" />
                            <x-input id="title" name="title" type="text" class="mt-1 block w-full {{ auth()->user()->is_manager ? '' : 'opacity-70 bg-gray-50 dark:bg-gray-900/50' }}" value="{{ old('title', $task->title) }}" required :disabled="!auth()->user()->is_manager" />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full {{ auth()->user()->is_manager ? '' : 'opacity-70 bg-gray-50 dark:bg-gray-900/50' }}" :disabled="!auth()->user()->is_manager">{{ old('description', $task->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Project Selection -->
                            <div>
                                <x-label for="project_id" value="{{ __('Project') }}" />
                                <select id="project_id" name="project_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full {{ auth()->user()->is_manager ? '' : 'opacity-70 bg-gray-50 dark:bg-gray-900/50' }}" required :disabled="!auth()->user()->is_manager">
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="project_id" class="mt-2" />
                            </div>

                            <!-- Assignee Selection -->
                            <div>
                                <x-label for="assignee_id" value="{{ __('Assignee') }}" />
                                <select id="assignee_id" name="assignee_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full {{ auth()->user()->is_manager ? '' : 'opacity-70 bg-gray-50 dark:bg-gray-900/50' }}" :disabled="!auth()->user()->is_manager">
                                    <option value="">{{ __('Unassigned') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assignee_id', $task->assignee_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="assignee_id" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-label for="status" value="{{ __('Status') }}" />
                                <select id="status" name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                    <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>{{ __('Done') }}</option>
                                </select>
                                <x-input-error for="status" class="mt-2" />
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                                {{ __('Update Task') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
