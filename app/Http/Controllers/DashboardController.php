<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the system dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Redirect collaborators to tasks page
        if (!$user->is_manager) {
            return redirect()->route('tasks.index')->with('info', 'Welcome back! You have been redirected to your tasks page.');
        }

        // Gather metrics for managers
        $totalUsers = User::count();
        
        // Active users: logged in within last 7 days, or has pending/in_progress tasks
        $activeUsers = User::where('last_seen', '>=', now()->subDays(7))
            ->orWhereHas('tasks', function ($query) {
                $query->whereIn('status', ['pending', 'in_progress']);
            })
            ->count();
        // Fallback to at least 1 (the current manager)
        $activeUsers = max(1, $activeUsers);

        $totalProjects = Project::count();
        // Completed projects: target date is in the past
        $completedProjects = Project::where('date', '<', now())->count();
        $activeProjects = max(0, $totalProjects - $completedProjects);

        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'done')->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();

        $taskCompletionRate = $totalTasks > 0 
            ? round(($completedTasks / $totalTasks) * 100) 
            : 0;

        return view('dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalProjects',
            'completedProjects',
            'activeProjects',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks',
            'taskCompletionRate'
        ));
    }
}
