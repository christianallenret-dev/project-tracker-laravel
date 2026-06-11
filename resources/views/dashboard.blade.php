<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('info'))
                <div class="p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded shadow dark:bg-blue-900/10 dark:text-blue-300 dark:border-blue-600">
                    <p class="text-sm font-medium">{{ session('info') }}</p>
                </div>
            @endif

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-xl shadow-lg p-6 lg:p-8 text-white">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="text-xl font-bold">{{ __('Welcome back,') }} {{ auth()->user()->name }}!</h3>
                        <p class="text-indigo-200 text-sm mt-1">{{ __("Here's an overview of the system today.") }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-indigo-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ now()->format('l, F j Y') }}
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Total Users --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700 flex items-center gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Total Users') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $totalUsers }}</p>
                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium mt-1">{{ $activeUsers }} {{ __('active') }}</p>
                    </div>
                </div>

                {{-- Total Projects --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700 flex items-center gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Projects') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $totalProjects }}</p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 font-medium mt-1">{{ $activeProjects }} {{ __('active') }} · {{ $completedProjects }} {{ __('done') }}</p>
                    </div>
                </div>

                {{-- Total Tasks --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700 flex items-center gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-orange-50 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-500 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Total Tasks') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $totalTasks }}</p>
                        <p class="text-xs text-orange-500 dark:text-orange-400 font-medium mt-1">{{ $inProgressTasks }} {{ __('in progress') }}</p>
                    </div>
                </div>

                {{-- Task Completion Rate --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700 flex items-center gap-5">
                    <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Completion Rate') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $taskCompletionRate }}<span class="text-lg font-medium text-gray-400">%</span></p>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium mt-1">{{ $completedTasks }} / {{ $totalTasks }} {{ __('tasks done') }}</p>
                    </div>
                </div>

            </div>

            {{-- Task Progress Bar Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-5">{{ __('Task Breakdown') }}</h3>
                <div class="space-y-4">
                    @php
                        $taskBarData = [
                            ['label' => __('Pending'), 'count' => $pendingTasks, 'total' => $totalTasks, 'color' => 'bg-gray-400 dark:bg-gray-500'],
                            ['label' => __('In Progress'), 'count' => $inProgressTasks, 'total' => $totalTasks, 'color' => 'bg-indigo-500'],
                            ['label' => __('Done'), 'count' => $completedTasks, 'total' => $totalTasks, 'color' => 'bg-emerald-500'],
                        ];
                    @endphp
                    @foreach($taskBarData as $bar)
                        @php $percent = $bar['total'] > 0 ? round(($bar['count'] / $bar['total']) * 100) : 0; @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $bar['label'] }}</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $bar['count'] }} <span class="text-gray-400 font-normal">({{ $percent }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                                <div class="{{ $bar['color'] }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <a href="{{ route('projects.index') }}" class="block bg-white dark:bg-gray-800 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-700 rounded-xl shadow-md p-5 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 transition">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Manage Projects') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalProjects }} {{ trans_choice('project|projects', $totalProjects) }}</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tasks.index') }}" class="block bg-white dark:bg-gray-800 hover:bg-orange-50 dark:hover:bg-orange-900/10 border border-gray-100 dark:border-gray-700 hover:border-orange-200 dark:hover:border-orange-700 rounded-xl shadow-md p-5 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-50 dark:bg-orange-900/30 rounded-lg flex items-center justify-center group-hover:bg-orange-100 dark:group-hover:bg-orange-900/50 transition">
                            <svg class="w-5 h-5 text-orange-500 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('View Tasks') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $pendingTasks }} {{ __('pending') }}</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('users.index') }}" class="block bg-white dark:bg-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 border border-gray-100 dark:border-gray-700 hover:border-emerald-200 dark:hover:border-emerald-700 rounded-xl shadow-md p-5 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/50 transition">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Manage Users') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalUsers }} {{ trans_choice('user|users', $totalUsers) }}</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
