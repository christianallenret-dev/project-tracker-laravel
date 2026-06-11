<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Basic Info --}}
            <div>
                <x-label for="name" value="{{ __('Full Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email Address') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            {{-- Project Assignment Section --}}
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-5">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">{{ __('Project Assignment') }}</h4>

                <div>
                    <x-label for="project_id" value="{{ __('Project') }}" />
                    <select id="project_id" name="project_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="" disabled selected>{{ __('Select a project') }}</option>
                        @foreach($projects ?? [] as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="project_role" value="{{ __('Role in Project') }}" />
                    <select id="project_role" name="project_role" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="" disabled selected>{{ __('Select a role') }}</option>
                        <option value="developer" {{ old('project_role') == 'developer' ? 'selected' : '' }}>{{ __('Developer') }}</option>
                        <option value="manager" {{ old('project_role') == 'manager' ? 'selected' : '' }}>{{ __('Manager') }}</option>
                        <option value="qa" {{ old('project_role') == 'qa' ? 'selected' : '' }}>{{ __('QA') }}</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <x-label for="assigned_at" value="{{ __('Start Date') }}" />
                        <x-input id="assigned_at" class="block mt-1 w-full" type="date" name="assigned_at" :value="old('assigned_at')" />
                    </div>
                    <div>
                        <x-label for="ended_at" value="{{ __('End Date') }}" />
                        <x-input id="ended_at" class="block mt-1 w-full" type="date" name="ended_at" :value="old('ended_at')" />
                    </div>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
