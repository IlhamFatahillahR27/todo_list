<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\AddTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddTaskRequest $request)
    {
        if ($request->wantsJson()) {
            try {

                $task = $this->taskService->create($request->all());

                return response()->json([
                    'success' => true,
                    'data'    => $task,
                ]);
            } catch (\Throwable $th) {
                throw new \ErrorException($th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($request->wantsJson()) {
            try {
                if (! $request->has('group_id') && $request->has('completed')) {
                    $request['group_id'] = Helper::completeGroup()->id;

                    if ($request->completed == 0) {
                        $request['group_id'] = Helper::onGoingGroup()->id;
                    }
                }

                $task = $this->taskService->update($request->all(), $task);

                return response()->json([
                    'success' => true,
                    'data'    => $task,
                ]);
            } catch (\Throwable $th) {
                throw new \ErrorException($th->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {

            $task = $this->taskService->destroy($task);

            return response()->json([
                'success' => true,
                'data'    => $task,
            ]);
        } catch (\Throwable $th) {
            throw new \ErrorException($th->getMessage());
        }
    }
}
