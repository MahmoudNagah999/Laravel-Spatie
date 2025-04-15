<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository extends BaseRepository
{
   public function __construct(Team $model)
   {
       parent::__construct($model);
   }



   public function removeUser(int $id, int $userId): bool {
    return $this->model->find($id)->users()->detach($userId);
   }

}
