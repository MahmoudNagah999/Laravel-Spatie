<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Services\TeamService;
use App\Traits\ApiResponse;

class TeamController extends Controller
{
    use ApiResponse;
    protected TeamService $teamService;

    public function __construct(TeamService $teamService) {
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = $this->teamService->paginate(10);
        return $this->paginatedResponse(
            TeamResource::collection($teams), 
            'Teams fetched successfully', 
            200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        try {
            $team = $this->teamService->create($request->validated());
            return $this->successResponse(
                TeamResource::make($team), 
                'Team created successfully', 
                201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = $this->teamService->find($id);
        return $this->successResponse(
            TeamResource::make($team), 
            'Team fetched successfully', 
            200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, string $id)
    {
        try {
            $team = $this->teamService->update($id, $request->validated());
            return $this->successResponse(
                TeamResource::make($team), 
                'Team updated successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->teamService->delete($id);
            return $this->successResponse(
               null, 
                'Team deleted successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
