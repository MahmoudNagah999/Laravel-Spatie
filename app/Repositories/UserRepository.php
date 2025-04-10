<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class UserRepository extends BaseRepository implements BaseRepositoryInterface
{
   public function __construct(User $model)
   {
       parent::__construct($model);
   }

   // You can add any user-specific methods 
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

}
