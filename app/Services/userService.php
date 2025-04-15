<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService {
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    
    public function create(array $data): User {
        return $this->userRepository->create($data);
    }

    public function find(int $id): User {
        return $this->userRepository->find($id);
    }

    public function update(int $id, array $data): User {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id): bool {
        return $this->userRepository->delete($id);
    }

    public function paginate(int $perPage = 10) {
        return $this->userRepository->paginate($perPage);
    }

    public function toggleStatus(int $id): User {
        $user = $this->userRepository->find($id);
        $data['is_active'] = !$user->is_active;
        return $this->userRepository->update($id, $data);
    }


}