<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $groups = $this->groupService->all()->load('tasks');
        return Inertia::render('Index', compact('groups'));
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
