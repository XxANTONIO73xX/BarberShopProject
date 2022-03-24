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
    
    public function show($id = NULL){
        $data=[
            "barberia" => $this->model->find($id)
        ];
        return $this->respond($data);
    }

    public function create()
    {
        $data=[
                "nombre"  => $this->request->getPost("nombre"),
                "direccion"  => $this->request->getPost("direccion"),
                "telefono"  => $this->request->getPost("telefono"),
                "correo"  => $this->request->getPost("correo"),
                "horario"  => $this->request->getPost("horario"),
                "estado"  => $this->request->getPost("estado")
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
        if(!empty($this->request->getPost("direccion")))
            $data["direccion"] = $this->request->getPost("direccion");
        if(!empty($this->request->getPost("telefono")))
            $data["telefono"] = $this->request->getPost("telefono");
        if(!empty($this->request->getPost("correo")))
            $data["correo"] = $this->request->getPost("correo");
        if(!empty($this->request->getPost("horario")))
            $data["horario"] = $this->request->getPost("horario");
        if(!empty($this->request->getPost("estado")))
            $data["estado"] = $this->request->getPost("estado");
        
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