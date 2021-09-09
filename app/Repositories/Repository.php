<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use \App\Http\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface{

    protected $model;

    //Constructor to bind model into repository
    public function __construst(Model $model){
        $this->model = $model;
    }

    public function all(){
        return $this->model->all();
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update(array $data,$id){
        $record = $this->find($id);
        return $record->update($data);
    }

    public function delete($id){
        return $this->model->delete($id);
    }

    public function show($id){
        return $this->model->findOrFail($id);
    }

    //get the associated model
    public function getModel(){
        return $this->model;
    }

    //set the associated model
    public function setModel(){
        $this->model = $model;
        return $this;
    }

    //Eager load database relationships
    public function with($relations){
        return $this->model->with($relations);
    }
}