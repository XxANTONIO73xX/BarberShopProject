<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClienteModel;
class Cliente extends Auth{
    protected $modelName = 'App\Models\ClienteModel';
    protected $format = 'json';

    public function index(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $data=[
            "clientes" => $this->model->findAll()
        ];
        return $this->respond($data);
    }

    public function show($id = NULL){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $data=[
            "cliente" => $this->model->find($id)
        ];
        return $this->respond($data);
    }

    public function create()
    {
        $data=[
                "nombre"  => $this->request->getPost("nombre"),
                "apellidos"  => $this->request->getPost("apellidos"),
                "correo"  => $this->request->getPost("correo"),
                "telefono"  => $this->request->getPost("telefono"),
                "pasword"  => $this->request->getPost("password")
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
        $data = [];
        if(!empty($this->request->getPost("nombre")))
            $data["nombre"] = $this->request->getPost("nombre");
        if(!empty($this->request->getPost("apellidos")))
            $data["apellidos"] = $this->request->getPost("apellidos");
        if(!empty($this->request->getPost("correo")))
            $data["correo"] = $this->request->getPost("correo");
        if(!empty($this->request->getPost("telefono")))
            $data["telefono"] = $this->request->getPost("telefono");
        if(!empty($this->request->getPost("password")))
            $data["pasword"] = $this->request->getPost("password");
        
        $result = $this->model->update($id, $data);

        if($result){
            return $this->respond(["result" => "El registro se edito correctamente", "cliente" => $this->model->find($id)]);
        }else{
            return $this->respond(["error" => "hubo un error al editar"]);
        }
    }

    public function delete($id = null){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $result = $this->model->delete($id);
        if($result){
            return $this->respond(["result"=> "El registro se elimino correctamente"]);
        }else{
            return $this->respond((["error" => "hubo un error al eliminar"]));
        }
    }

}

?>