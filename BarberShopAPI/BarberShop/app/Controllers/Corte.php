<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CorteModel;

class Corte extends ResourceController{
    protected $modelName = 'App\Models\CorteModel';
    protected $format = 'json';

    public function index(){
        $data=[
            "cortes" => $this->model->findAll()
        ];
        return $this->respond($data);
    }
}

?>