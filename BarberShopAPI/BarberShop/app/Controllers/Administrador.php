<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AdministradorModel;

class Administrador extends ResourceController{
    protected $modelName = 'App\Models\AdministradorModel';
    protected $format = 'json';

    public function index(){
        $data=[
            "administradores" => $this->model->findAll()
        ];
        return $this->respond($data);
    }
}

?>