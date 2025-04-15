<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
   public function __construct(User $model)
   {
       parent::__construct($model);
   }

    // You can add any user-specific methods here
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

}
