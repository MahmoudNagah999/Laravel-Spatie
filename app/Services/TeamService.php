<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Model;

class TeamService {
    protected TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }
    
    public function create(array $data): Model {
        return $this->teamRepository->create($data);
    }

    public function find(int $id): Model {
        return $this->teamRepository->find($id);
    }

    public function update(int $id, array $data): Model {
        return $this->teamRepository->update($id, $data);
    }

    public function delete(int $id): bool {
        return $this->teamRepository->delete($id);
    }

    public function paginate(int $perPage = 10) {
        return $this->teamRepository->paginate($perPage);
    }

}