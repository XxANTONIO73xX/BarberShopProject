<?php 
namespace App\Controllers;

use App\Models\CitaModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CorteModel;
class Corte extends Auth{
    protected $modelName = 'App\Models\CorteModel';
    protected $format = 'json';

    public function index(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $data=[
            "cortes" => $this->model->findAll()
        ];
        return $this->respond($data);
    }

    public function show($id = NULL){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        $data=[
            "corte" => $this->model->find($id)
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
        $file->move('./uploads/Cortes');
        $data=[
                "nombre"  => $this->request->getPost("nombre"),
                "visualizacion"  => "http://api.kikosbarbershop.online/public/uploads/Cortes/".$file->getName()
        ];

        $id = $this->model->insert($data);

        if($id){
            return $this->respond($this->model->find($id));
        }else{
            return $this->respond(["error" => "hubo un error al insertar"]);
        }

    }

    public function CorteMasPedido(){
        $citaModel = new CitaModel();
        $data = $citaModel->CorteMasPedido();
        $id = $data->idCorte;
        return $this->respond($this->model->find($id));
    }

    public function ConteoCortes(){
        $citaModel = new CitaModel();
        $list = $citaModel->ConteoCortes();
        $data=[];
        foreach ($list as $idCorte => $corte){
            $data["cortes"][] = [
                "total" => $corte["total"],
                "corte" => $this->model->find($corte["idCorte"])
            ];
        }
        return $this->respond($data);
    }

    public function uploadFile(){
        helper(['form']);
        $file = $this->request->getFile('featured_image');
        if(! $file->isValid())
            return $this->fail($file->getErrorString());
        $file->move('./uploads/Cortes');
        return $this->respond(["img" => "http://api.kikosbarbershop.online/public/uploads/Cortes/".$file->getName()]);
    }

    public function update($id = null){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        helper(['form', 'array']);
        $data = [];
        if(!empty($this->request->getPost("nombre"))){
            $data["nombre"] = $this->request->getPost("nombre");
        }
        if(!empty($this->request->getFile('featured_image'))){
            $fileName = dot_array_search('featured_image.name', $_FILES);
            $file = $this->request->getFile('featured_image');
            if(! $file->isValid())
            return $this->fail($file->getErrorString());
            $file->move('./uploads/Cortes');
            $data["visualizacion"] = "http://api.kikosbarbershop.online/public/uploads/Cortes/".$file->getName();
        }
        $result = $this->model->update($id, $data);
        if($result){
            return $this->respond(["result" => "El registro se edito correctamente", "Corte" => $this->model->find($id)]);
        }else{
            return $this->respond(["error" => "hubo un error al editar"]);
        }
    }

    public function delete($id = null){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador" || $this->tipoUsuario != "barbero" ){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $result = $this->model->delete($id);
        if($result){
            return $this->respond(["result"=> "El registro se elimino correctamente"]);
        }else{
            return $this->respond((["error" => "hubo un error al eliminar"]));
        }
    }

}
