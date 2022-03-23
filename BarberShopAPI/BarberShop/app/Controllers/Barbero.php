<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarberoModel;

class Barbero extends ResourceController{
    protected $modelName = 'App\Models\BarberoModel';
    protected $format = 'json';

    public function index(){
        $data=[
            "barberos" => $this->model->findAll()
        ];
        return $this->respond($data);
    }
}

?>