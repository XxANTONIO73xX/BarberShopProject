<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CitaModel;

class Cita extends ResourceController{
    protected $modelName = 'App\Models\CitaModel';
    protected $format = 'json';

    public function index(){
        $data=[
            "cita" => $this->model->findAll()
        ];
        return $this->respond($data);
    }
}

?>