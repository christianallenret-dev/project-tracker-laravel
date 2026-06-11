<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Task Title -->
                        <div>
                            <x-label for="title" value="{{ __('Task Title') }}" />
                            <x-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" required autofocus />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">{{ old('description') }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Project Selection -->
                            <div>
                                <x-label for="project_id" value="{{ __('Project') }}" />
                                <select id="project_id" name="project_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="" disabled {{ !old('project_id') ? 'selected' : '' }}>{{ __('Select a project') }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', request('project_id')) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="project_id" class="mt-2" />
                            </div>

                            <!-- Assignee Selection -->
                            <div>
                                <x-label for="assignee_id" value="{{ __('Assignee') }}" />
                                <select id="assignee_id" name="assignee_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">{{ __('Unassigned') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="assignee_id" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-label for="status" value="{{ __('Status') }}" />
                                <select id="status" name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                    <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>{{ __('Done') }}</option>
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
                                {{ __('Save Task') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
