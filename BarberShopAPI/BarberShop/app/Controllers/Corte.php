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
    public function show($id = NULL){
        $data=[
            "corte" => $this->model->find($id)
        ];
        return $this->respond($data);
    }

    public function create()
    {
        $data=[
                "nombre"  => $this->request->getPost("nombre"),
                "visualizacion"  => $this->request->getPost("visualizacion"),
                "idBarbero"  => $this->request->getPost("idBarbero")
        ];

        $id = $this->model->insert($data);

        if($id){
            return $this->respond($this->model->find($id));
        }else{
            return $this->respond(["error" => "hubo un error al insertar"]);
        }

    }

    public function update($id = null){
        $data = [];
        if(!empty($this->request->getPost("nombre")))
            $data["nombre"] = $this->request->getPost("nombre");
        if(!empty($this->request->getPost("visualizacion")))
            $data["visualizacion"] = $this->request->getPost("visualizacion");
        if(!empty($this->request->getPost("idBarbero")))
            $data["idBarbero"] = $this->request->getPost("idBarbero");
        
        $result = $this->model->update($id, $data);

        if($result){
            return $this->respond(["result" => "El registro se edito correctamente"]);
        }else{
            return $this->respond(["error" => "hubo un error al editar"]);
        }
    }

    public function delete($id = null)
    {
        $result = $this->model->delete($id);
        if($result){
            return $this->respond(["result"=> "El registro se elimino correctamente"]);
        }else{
            return $this->respond((["error" => "hubo un error al eliminar"]));
        }
    }

}

?>