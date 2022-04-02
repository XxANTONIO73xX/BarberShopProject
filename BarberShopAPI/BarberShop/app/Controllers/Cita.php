<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CitaModel;

class Cita extends Auth{
    protected $modelName = 'App\Models\CitaModel';
    protected $format = 'json';

    public function index(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $data=[
            "citas" => $this->model->findAll()
        ];
        return $this->respond($data);
    }

    public function cliente_cita($id){
        $data=[
            "citas" => $this->model->obtenerPorCliente($id)
        ];
        return $this->respond($data);
    }

    public function barbero_cita($id){
        $data=[
            "citas" => $this->model->obtenerPorBarbero($id)
        ];
        return $this->respond($data);
    }

    public function show($id = NULL){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $data=[
            "cita" => $this->model->find($id)
        ];
        return $this->respond($data);
    }

    public function create(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador" || $this->tipoUsuario != "cliente"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $data=[
                "idCliente"  => $this->request->getPost("idCliente"),
                "idBarbero"  => $this->request->getPost("idBarbero"),
                "idCorte"  => $this->request->getPost("idCorte"),
                "idBarberia"  => $this->request->getPost("idBarberia"),
                "fecha"  => $this->request->getPost("fecha"),
                "hora"  => $this->request->getPost("hora"),
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
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $data = [];
        if(!empty($this->request->getPost("idCliente")))
            $data["idCliente"] = $this->request->getPost("idCliente");
        if(!empty($this->request->getPost("idBarbero")))
            $data["idBarbero"] = $this->request->getPost("idBarbero");
        if(!empty($this->request->getPost("idCorte")))
            $data["idCorte"] = $this->request->getPost("idCorte");
        if(!empty($this->request->getPost("idBarberia")))
            $data["idBarberia"] = $this->request->getPost("idBarberia");
        if(!empty($this->request->getPost("fecha")))
            $data["fecha"] = $this->request->getPost("fecha");
        if(!empty($this->request->getPost("hora")))
            $data["hora"] = $this->request->getPost("hora");
        if(!empty($this->request->getPost("estado")))
            $data["estado"] = $this->request->getPost("estado");
        
        $result = $this->model->update($id, $data);

        if($result){
            return $this->respond(["result" => "El registro se edito correctamente"]);
        }else{
            return $this->respond(["error" => "hubo un error al editar"]);
        }
    }

    public function delete($id = null){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $result = $this->model->delete($id);
        if($result){
            return $this->respond(["result"=> "El registro se elimino correctamente"]);
        }else{
            return $this->respond((["error" => "hubo un error al eliminar"]));
        }
    }
}

?>