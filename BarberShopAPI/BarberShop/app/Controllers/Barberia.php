<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarberiaModel;
use App\Models\CitaModel;

class Barberia extends Auth{
    protected $modelName = 'App\Models\BarberiaModel';
    protected $format = 'json';

    public function index(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $data=[
            "barberias" => $this->model->findAll()
        ];
        return $this->respond($data, 200);
    }
    
    public function show($id = NULL){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $data=[
            "barberia" => $this->model->find($id)
        ];
        return $this->respond($data, 200);
    }

    public function create(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        helper(['form']);
        $file = $this->request->getFile('featured_image');
        if(! $file->isValid())
            return $this->fail($file->getErrorString());
        $file->move('./uploads/Barberias');
        $data=[
                "nombre"  => $this->request->getPost("nombre"),
                "direccion"  => $this->request->getPost("direccion"),
                "telefono"  => $this->request->getPost("telefono"),
                "correo"  => $this->request->getPost("correo"),
                "horario"  => $this->request->getPost("horario"),
                "estado"  => $this->request->getPost("estado"),
                "visualizacion"  => "http://api.kikosbarbershop.online/public/uploads/Barberias/".$file->getName()
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
        if(!empty($this->request->getFile('featured_image'))){
                $fileName = dot_array_search('featured_image.name', $_FILES);
                $file = $this->request->getFile('featured_image');
                if(! $file->isValid())
                return $this->fail($file->getErrorString());
                $file->move('./uploads/Barberias');
                $data["visualizacion"] = "http://api.kikosbarbershop.online/public/uploads/Barberias/".$file->getName();
            }
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
            return $this->respond(["result"=> "El registro se elimino correctamente"], 200);
        }else{
            return $this->respond(["error" => "hubo un error al eliminar"], 200);
        }
    }

    public function BarberiaMasPedido(){
        $citaModel = new CitaModel();
        $data = $citaModel->BarberiaMasPedido();
        $id = $data->idBarberia;
        return $this->respond($this->model->find($id));
    }

    public function ConteoBarberias(){
        $citaModel = new CitaModel();
        $list = $citaModel->ConteoBarberias();
        $data=[];
        foreach ($list as $idBarberia => $barberia){
            $data["barberias"][] = [
                "total" => $barberia["total"],
                "barberia" => $this->model->find($barberia["idBarberia"])
            ];
        }
        return $this->respond($data);
    }
}

?>