<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GroupService
{
    protected Model $model;

    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    public function model(): Group
    {
        return $this->model;
    }

    public function all(): Collection
    {
        $group = $this->model->all();

        return $group;
    }

    public function regularGroup()
    {
        $group = $this->model
            ->where('for_complete', false)
            ->with(['tasks' => function ($query) {
                $query->orderBy('updated_at', 'desc');
            }])
            ->get();

        return $group;
    }

    public function paginate(int $page): LengthAwarePaginator
    {
        $group = $this->model->paginate($page);

        return $group;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $group = $this->model->create($request);
            $group = $this->show($group->id);

            DB::commit();

            return $group;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \ErrorException($th->getMessage());
        }
    }

    public function show($id): Group
    {
        return $this->model->find($id);
    }

    public function findMany(array $id): Collection
    {
        return $this->model->find($id);
    }

    public function update(array $data, $group): Group
    {
        DB::beginTransaction();
        try {
            $group->update($data);

            DB::commit();

            return $group;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \ErrorException($th->getMessage());
        }
    }

    public function destroy(Group $group): bool
    {
        try {
            $group = $group->delete();

            return $group;
        } catch (\Throwable $th) {
            throw new \ErrorException($th->getMessage());
        }
    }


    public function findByName($name)
    {
        return $this->model
            ->with(['tasks' => function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%')->orderBy('updated_at', 'desc');
            }])
            ->get();
    }
}
