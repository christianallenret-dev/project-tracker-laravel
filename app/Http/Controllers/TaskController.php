<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Task::with(['project', 'assignee']);

        if (!auth()->user()->is_manager) {
            $query->where('assignee_id', auth()->id());
        }

        $tasks = $query->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage-tasks');

        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-tasks');

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assignee_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'status' => 'required|string|in:pending,in_progress,done',
            'description' => 'nullable|string',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'assignee']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (Gate::allows('manage-tasks')) {
            // Managers can edit everything
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'assignee_id' => 'nullable|exists:users,id',
                'title' => 'required|string|max:255',
                'status' => 'required|string|in:pending,in_progress,done',
                'description' => 'nullable|string',
            ]);

            $task->update($validated);
        } else {
            // Non-managers can ONLY update status
            $validated = $request->validate([
                'status' => 'required|string|in:pending,in_progress,done',
            ]);

            $task->update([
                'status' => $validated['status'],
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('manage-tasks');

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
