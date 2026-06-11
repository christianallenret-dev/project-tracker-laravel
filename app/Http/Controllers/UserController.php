<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount(['projects', 'tasks'])->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('users.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_manager' => 'sometimes|boolean',
            'project_id' => 'nullable|exists:projects,id',
            'project_role' => 'nullable|required_with:project_id|in:developer,manager,qa',
            'assigned_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:assigned_at',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_manager' => $request->has('is_manager'),
        ];

        $user = User::create($userData);

        if (!empty($validated['project_id'])) {
            $user->projects()->attach($validated['project_id'], [
                'role' => $validated['project_role'],
                'assigned_at' => $validated['assigned_at'] ?: now()->format('Y-m-d'),
                'ended_at' => $validated['ended_at'] ?: null,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['projects', 'tasks.project']);

        $projects = $user->projects;
        
        $activeProjects = $projects->filter(function ($project) {
            return is_null($project->pivot->ended_at) || Carbon::parse($project->pivot->ended_at)->isFuture();
        });
        
        $finishedProjects = $projects->filter(function ($project) {
            return !is_null($project->pivot->ended_at) && Carbon::parse($project->pivot->ended_at)->isPast();
        });

        $tasks = $user->tasks;
        $activeTasks = $tasks->whereIn('status', ['pending', 'in_progress']);
        $finishedTasks = $tasks->where('status', 'done');

        return view('users.show', compact(
            'user',
            'activeProjects',
            'finishedProjects',
            'activeTasks',
            'finishedTasks'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $projects = Project::all();
        $user->load('projects');
        $currentProject = $user->projects()->first();

        return view('users.edit', compact('user', 'projects', 'currentProject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'is_manager' => 'sometimes|boolean',
            'project_id' => 'nullable|exists:projects,id',
            'project_role' => 'nullable|required_with:project_id|in:developer,manager,qa',
            'assigned_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:assigned_at',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_manager' => $request->has('is_manager'),
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        if (!empty($validated['project_id'])) {
            $user->projects()->sync([
                $validated['project_id'] => [
                    'role' => $validated['project_role'],
                    'assigned_at' => $validated['assigned_at'] ?: now()->format('Y-m-d'),
                    'ended_at' => $validated['ended_at'] ?: null,
                ]
            ]);
        } else {
            $user->projects()->detach();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Don't allow a user to delete themselves
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
