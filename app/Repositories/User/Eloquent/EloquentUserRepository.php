<?php

namespace App\Repositories\User\Eloqent;

use App\Repositories\EloquentRepository;
use App\Repositories\User\UserRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository {

    public function __construct(private $model)
    {
$this->model=$model;
    }
    public function all(){
return $this->model->all();
    }
    public function create($data){
return $this->model->create();
    }
    public function update($model,$data){

    }
    public function delete($id){
return $this->model->delete($id);
    }
    public function find($id){
return $this->model->findorfail($id);
    }
    public function updateprofile( array $data){
        return $this->model->updateprofile($data);
    }
}
