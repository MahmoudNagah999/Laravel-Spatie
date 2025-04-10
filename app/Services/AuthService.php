<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService {
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    
    public function register(array $data) {
        $data['password'] = bcrypt($data['password']);
        $data['email_verified_at'] = now();
         
        $user = $this->userRepository->create($data);

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user->access_token = $token; 
        $user->save();
        return $user;
    }

    public function login(array $credentials) {
        if(!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = $this->userRepository->findByEmail($credentials['email']);
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user->access_token = $token;
        $user->save(); 

        return $user;
    }
}