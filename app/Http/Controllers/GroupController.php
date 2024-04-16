<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\AddGroupRequest;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    public $groupService;
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = $this->groupService->regularGroup();
        $complete_group = Helper::completeGroup()->load('tasks');
        $search_feature = config('features.search');

        return Inertia::render('Index', compact('groups', 'complete_group', 'search_feature'));
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
    public function store(AddGroupRequest $request)
    {
        if ($request->wantsJson()) {
            try {
                $group = $this->groupService->create($request->all());

                return response()->json([
                    'success' => true,
                    'data'    => $group,
                ]);
            } catch (\Throwable $th) {
                throw new \ErrorException($th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        if ($request->wantsJson()) {
            try {
                $group = $this->groupService->update($request->all(), $group);

                return response()->json([
                    'success' => true,
                    'data'    => $group,
                ]);
            } catch (\Throwable $th) {
                throw new \ErrorException($th->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        try {

            $group = $this->groupService->destroy($group);

            return response()->json([
                'success' => true,
                'data'    => $group,
            ]);
        } catch (\Throwable $th) {
            throw new \ErrorException($th->getMessage());
        }
    }

    public function findByName(Request $request)
    {
        return response()->json($this->groupService->findByName($request->name));
    }
}
