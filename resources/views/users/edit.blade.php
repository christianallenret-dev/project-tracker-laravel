<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg divide-y divide-gray-200 dark:divide-gray-700">

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 lg:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Basic Info Section --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Account Details') }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-label for="name" value="{{ __('Full Name') }}" />
                                <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" required autofocus />
                                <x-input-error for="name" class="mt-2" />
                            </div>
                            <div>
                                <x-label for="email" value="{{ __('Email Address') }}" />
                                <x-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required />
                                <x-input-error for="email" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" id="is_manager" name="is_manager" value="1" {{ old('is_manager', $user->is_manager) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-0.5">
                                <div>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 block">{{ __('Grant Manager Role') }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Managers can create tasks, assign users, and access the dashboard.') }}</span>
                                </div>
                            </label>
                        </div>

                        <div class="mt-6 border-t border-gray-100 dark:border-gray-700 pt-5">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-200 mb-1">{{ __('Change Password') }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ __('Leave blank to keep the current password.') }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-label for="password" value="{{ __('New Password') }}" />
                                    <x-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    <x-input-error for="password" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="password_confirmation" value="{{ __('Confirm New Password') }}" />
                                    <x-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    <x-input-error for="password_confirmation" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Project Assignment Section --}}
                    @php
                        $cp = $currentProject;
                    @endphp
                    <div class="pt-6">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ __('Project Assignment') }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ __('Update or reassign this user to a project.') }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-label for="project_id" value="{{ __('Project') }}" />
                                <select id="project_id" name="project_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">{{ __('No project assigned') }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $cp?->id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="project_id" class="mt-2" />
                            </div>
                            <div>
                                <x-label for="project_role" value="{{ __('Project Role') }}" />
                                <select id="project_role" name="project_role" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">{{ __('Select role') }}</option>
                                    <option value="developer" {{ old('project_role', $cp?->pivot?->role) == 'developer' ? 'selected' : '' }}>{{ __('Developer') }}</option>
                                    <option value="manager" {{ old('project_role', $cp?->pivot?->role) == 'manager' ? 'selected' : '' }}>{{ __('Manager') }}</option>
                                    <option value="qa" {{ old('project_role', $cp?->pivot?->role) == 'qa' ? 'selected' : '' }}>{{ __('QA') }}</option>
                                </select>
                                <x-input-error for="project_role" class="mt-2" />
                            </div>
                            <div>
                                <x-label for="assigned_at" value="{{ __('Start Date') }}" />
                                <x-input id="assigned_at" name="assigned_at" type="date" class="mt-1 block w-full" value="{{ old('assigned_at', $cp?->pivot?->assigned_at) }}" />
                                <x-input-error for="assigned_at" class="mt-2" />
                            </div>
                            <div>
                                <x-label for="ended_at" value="{{ __('End Date') }}" />
                                <x-input id="ended_at" name="ended_at" type="date" class="mt-1 block w-full" value="{{ old('ended_at', $cp?->pivot?->ended_at) }}" />
                                <x-input-error for="ended_at" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition shadow-md">
                            {{ __('Update User') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
