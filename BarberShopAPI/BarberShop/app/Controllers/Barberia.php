<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarberiaModel;

class Barberia extends ResourceController{
    protected $modelName = 'App\Models\BarberiaModel';
    protected $format = 'json';

    public function index(){
        $data=[
            "barberias" => $this->model->findAll()
        ];
        return $this->respond($data);
    }
}

?>