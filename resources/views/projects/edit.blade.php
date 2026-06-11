<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Project') }}: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Project Name -->
                        <div>
                            <x-label for="name" value="{{ __('Project Name') }}" />
                            <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $project->name) }}" required autofocus />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">{{ old('description', $project->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Location -->
                            <div>
                                <x-label for="location" value="{{ __('Location') }}" />
                                <x-input id="location" name="location" type="text" class="mt-1 block w-full" value="{{ old('location', $project->location) }}" />
                                <x-input-error for="location" class="mt-2" />
                            </div>

                            <!-- Date -->
                            <div>
                                <x-label for="date" value="{{ __('Project Date') }}" />
                                <x-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ old('date', $project->date ? $project->date->format('Y-m-d') : '') }}" />
                                <x-input-error for="date" class="mt-2" />
                            </div>

                            <!-- Slots -->
                            <div>
                                <x-label for="slots" value="{{ __('Available Slots') }}" />
                                <x-input id="slots" name="slots" type="number" min="0" class="mt-1 block w-full" value="{{ old('slots', $project->slots) }}" required />
                                <x-input-error for="slots" class="mt-2" />
                            </div>
                        </div>

                        <!-- Team Members (Users assignment) -->
                        <div>
                            <x-label value="{{ __('Assign Team Members') }}" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ __('Select team members associated with this project') }}</p>
                            
                            <div class="border border-gray-300 dark:border-gray-700 rounded-md p-4 max-h-48 overflow-y-auto dark:bg-gray-900 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @php
                                    $assignedUserIds = $project->users->pluck('id')->toArray();
                                @endphp
                                @foreach($users as $user)
                                    <label class="flex items-center space-x-3 cursor-pointer p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}" {{ in_array($user->id, old('users', $assignedUserIds)) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error for="users" class="mt-2" />
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                                {{ __('Update Project') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
