<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class TeamService {
    protected TeamRepository $teamRepository;
    protected UserRepository $userRepository;

    public function __construct(TeamRepository $teamRepository, UserRepository $userRepository) {
        $this->teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
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

    public function addUser(int $id, array $data): bool {
        foreach ($data['users'] as $user) {
            $user = $this->userRepository->find($user);
            if (!$user) {
                throw new \Exception('User not found');
            }   
            $user->team_id = $id;
            $user->save();
        }
        return true;
    }

    public function removeUser(int $id, int $data): bool {
        foreach ($data['users'] as $user) {
            $user = $this->userRepository->find($user);
            if (!$user) {
                throw new \Exception('User not found');
            }   
            $user->team_id = null;
            $user->save();
        }
        return true;
    }

}