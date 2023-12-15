<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;

interface UserRepository extends BaseRepository{
    public function updateprofile(array $data);
}
