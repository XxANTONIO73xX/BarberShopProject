<?php 
namespace App\Controllers;

use App\Models\BarberiaModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\BarberoModel;
use App\Models\CitaModel;

class Barbero extends Auth{
    protected $modelName = 'App\Models\BarberoModel';
    protected $format = 'json';

    public function index(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        //if($this->tipoUsuario != "administrador" || $this->tipoUsuario != "cliente"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta", "tipoUsuario" => $this->tipoUsuario]);}
        $barberiaModel = new BarberiaModel();
        $barberos = $this->model->findAll();
        $data["barberos"]=[];
        foreach($barberos as $idBarbero => $barbero){
            $data["barberos"][] = [
                "id" => $barbero["id"],
                "nombre"  => $barbero["nombre"],
                "apodo"  => $barbero["apodo"],
                "apellidos"  => $barbero["apellidos"],
                "telefono"  => $barbero["telefono"],
                "visualizacion" => $barbero["visualizacion"],
                "barberia"  => $barberiaModel->find($barbero["idBarberia"])
            ];
        }
        return $this->respond($data);
    }

    public function barbero_barberia($id){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $barberiaModel = new BarberiaModel();
        $barberos = $this->model->obtenerPorBarberia($id);
        $data["barberos"]=[];
        $data["barberia"] = $barberiaModel->find($id);
        foreach($barberos as $idBarbero => $barbero){
            $data["barberos"][]=[
                "id" => $barbero["id"],
                "nombre"  => $barbero["nombre"],
                "apodo"  => $barbero["apodo"],
                "apellidos"  => $barbero["apellidos"],
                "telefono"  => $barbero["telefono"],
                "visualizacion" => $barbero["visualizacion"],
            ];
        }
        return $this->respond($data);
    }

    public function show($id = NULL){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        //if($this->tipoUsuario == "cliente" || $this->barbero["id"] != $id){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        
        $barbero = $this->model->find($id);
        $barberiaModel = new BarberiaModel();
        $data=[
            "barbero" => [
                "id" => $barbero["id"],
                "nombre"  => $barbero["nombre"],
                "apodo"  => $barbero["apodo"],
                "apellidos"  => $barbero["apellidos"],
                "telefono"  => $barbero["telefono"],
                "visualizacion" => $barbero["visualizacion"],
                "barberia"  => $barberiaModel->find($barbero["idBarberia"])
            ]
        ];
        return $this->respond($data);
    }

    public function create(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        helper(['form']);
        $file = $this->request->getFile('featured_image');
        if(! $file->isValid())
            return $this->fail($file->getErrorString());
        $file->move('./uploads/Barberos');
        $data=[
                "nombre"  => $this->request->getPost("nombre"),
                "apodo"  => $this->request->getPost("apodo"),
                "apellidos"  => $this->request->getPost("apellidos"),
                "telefono"  => $this->request->getPost("telefono"),
                "idBarberia"  => $this->request->getPost("idBarberia"),
                "visualizacion"  => "http://api.kikosbarbershop.online/public/uploads/Barberos/".$file->getName()
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
        helper(['form', 'array']);
        $data = [];
        if(!empty($this->request->getPost("nombre")))
            $data["nombre"] = $this->request->getPost("nombre");
        if(!empty($this->request->getPost("apodo")))
            $data["apodo"] = $this->request->getPost("apodo");
        if(!empty($this->request->getPost("apellidos")))
            $data["apellidos"] = $this->request->getPost("apellidos");
        if(!empty($this->request->getPost("telefono")))
            $data["telefono"] = $this->request->getPost("telefono");
        if(!empty($this->request->getPost("idBarberia")))
            $data["idBarberia"] = $this->request->getPost("idBarberia");
        if(!empty($this->request->getFile('featured_image'))){
            $fileName = dot_array_search('featured_image.name', $_FILES);
            $file = $this->request->getFile('featured_image');
            if(! $file->isValid())
            return $this->fail($file->getErrorString());
            $file->move('./uploads/Barberos');
            $data["visualizacion"] = "http://api.kikosbarbershop.online/public/uploads/Barberos/".$file->getName();
        }
        
        $result = $this->model->update($id, $data);

        if($result){
            return $this->respond(["result" => "El registro se edito correctamente", "barbero" => $this->model->find($id)]);
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

    public function BarberoMasPedido(){
        $citaModel = new CitaModel();
        $data = $citaModel->BarberoMasPedido();
        $id = $data->idBarbero;
        return $this->respond($this->model->find($id));
    }

    public function ConteoBarberos(){
        $citaModel = new CitaModel();
        $list = $citaModel->ConteoBarberos();
        $data=[];
        foreach ($list as $idBarbero => $barbero){
            $data["barberos"][] = [
                "total" => $barbero["total"],
                "barbero" => $this->model->find($barbero["idBarbero"])
            ];
        }
        return $this->respond($data);
    }
}

?>