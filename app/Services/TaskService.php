<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaskService
{
    protected Model $model;

    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function model(): Task
    {
        return $this->model;
    }

    // public function select2()
    // {
    //     $task = $this->model()
    //         ->selectRaw('id as value, nama as label')
    //         ->get();

    //     return $task;
    // }

    public function all(): Collection
    {
        $task = $this->model->all();

        return $task;
    }

    public function paginate(int $page): LengthAwarePaginator
    {
        $task = $this->model->paginate($page);

        return $task;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $task = $this->model->create($request);

            DB::commit();

            return $task;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \ErrorException($th->getMessage());
        }
    }

    public function show($id): Task
    {
        return $this->model->find($id);
    }

    public function findMany(array $id): Collection
    {
        return $this->model->find($id);
    }

    public function update(array $data, $task): Task
    {
        DB::beginTransaction();
        try {
            $task->update($data);

            DB::commit();

            return $task;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \ErrorException($th->getMessage());
        }
    }

    public function destroy(Task $task): bool
    {
        try {
            $task = $task->delete();

            return $task;
        } catch (\Throwable $th) {
            throw new \ErrorException($th->getMessage());
        }
    }
}
