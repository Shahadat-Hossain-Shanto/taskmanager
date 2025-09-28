<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tasks'             => 'required|array|min:1',
            'tasks.*.title'     => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.due_date'  => 'required|date',
            'tasks.*.status'    => 'required|integer|in:0,1,2',
        ]);

        $now = now();

        $rows = collect($validated['tasks'])->map(function ($task) use ($now) {
            return [
                'title'       => $task['title'],
                'description' => $task['description'] ?? null,
                'due_date'    => $task['due_date'] ?? null,
                'status'      => $task['status'] ?? 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        })->toArray();

        Task::insert($rows);

        return redirect()->route('tasks.list')->with('success', 'Task created successfully.');
    }

    public function index()
    {
        $tasks = Task::all();
        return view('index', compact('tasks'));
    }

    public function data()
    {
        $tasks = Task::all();
        return response()->json(['data' => $tasks]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2',
        ]);

        $task->update([
            'status' => $request->status
        ]);
        return response()->json(['success' => true]);
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.list')->with('success', 'Task deleted successfully.');
    }

    //api store
    public function apiStore(Request $request)
    {
        $Authorization = $request->header('Authorization');
        if ($Authorization !== 'hT9vXb2qLr8YnZp5S1QwKg==')
        {
            return response()->json([
                'status' => 400,
                'message' => 'Unauthorized Access',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'tasks'               => 'required|array|min:1',
            'tasks.*.title'       => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.due_date'    => 'required|date',
            'tasks.*.status'      => 'required|integer|in:0,1,2',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $now = now();
        $rows = collect($validator->validated()['tasks'])->map(function ($task) use ($now) {
            return [
                'title'       => $task['title'],
                'description' => $task['description'] ?? null,
                'due_date'    => $task['due_date'],
                'status'      => $task['status'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        })->toArray();

        Task::insert($rows);

        $responseData = collect($rows)->map(function($task)
        {
            return [
                'title'    => $task['title'],
                'due_date' => $task['due_date'],
                'status'   => $task['status'],
            ];
        });

        return response()->json([
            'status' => 200,
            'message' => 'Tasks created successfully.',
            'data'    => $responseData
        ], 200);
    }



}
