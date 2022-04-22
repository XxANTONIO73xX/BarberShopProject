<?php 
namespace App\Controllers;

use App\Models\BarberiaModel;
use App\Models\BarberoModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CitaModel;
use App\Models\ClienteModel;
use App\Models\CorteModel;

class Cita extends Auth{
    protected $modelName = 'App\Models\CitaModel';
    protected $format = 'json';
    protected $cliente;
    protected $cita;
    protected $corte;
    protected $barberia;
    protected $barbero;
    
    public function index(){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "administrador"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        
        $clienteModel = new ClienteModel();
        $corteModel = new CorteModel();
        $barberoModel = new BarberoModel();
        $barberiaModel = new BarberiaModel();

        $this->cita = $this->model->findAll();
        
        $data["citas"]=[];

        foreach ($this->cita as $idCita => $cita){
            $data["citas"][] = [
                "id" => $cita["id"],
                "fecha" => $cita["fecha"],
                "hora" => $cita["hora"],
                "estado" => $cita["estado"],
                "cliente" => $clienteModel->find($cita["idCliente"]),
                "corte" => $corteModel->find($cita["idCorte"]),
                "barbero" => $barberoModel->find($cita["idBarbero"]),
                "barberia" =>$barberiaModel->find($cita["idBarberia"])
            ];
        }

        return $this->respond($data);
    }

    public function cliente_cita($id){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "cliente"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        
        $clienteModel = new ClienteModel();
        $corteModel = new CorteModel();
        $barberoModel = new BarberoModel();
        $barberiaModel = new BarberiaModel();

        $this->cliente = $clienteModel->find($id);  
        $this->cita = $this->model->obtenerPorCliente($id);

        $data["citas"]=[];
        $data["cliente"]= $this->cliente;

        foreach ($this->cita as $idCita => $cita) {   

            $data["citas"][] = [
                "id" => $cita["id"],
                "fecha" => $cita["fecha"],
                "hora" => $cita["hora"],
                "estado" => $cita["estado"], 
                "corte" => $corteModel->find($cita["idCorte"]),
                "barbero" => $barberoModel->find($cita["idBarbero"]),
                "barberia" =>$barberiaModel->find($cita["idBarberia"])
            ];

        }

        return $this->respond($data);
    }

    public function barbero_cita($id){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        if($this->tipoUsuario != "barbero"){return $this->respond(["error" => "No tienes permisos para acceder a esta ruta"]);}
        $barberoModel = new BarberoModel();
        $data=[
            "citas" => $this->model->obtenerPorBarbero($id),
            "barbero" => $barberoModel->find($id)
        ];
        return $this->respond($data);
    }

    public function show($id = NULL){
        if(!$this->verifyToken()){return $this->respond(["error" =>"Token expirado"]);}
        
        $clienteModel = new ClienteModel();
        $corteModel = new CorteModel();
        $barberoModel = new BarberoModel();
        $barberiaModel = new BarberiaModel();
        
        $this->cita = $this->model->find($id);
        $data=[
            "cita" => [
                "id" => $this->cita["id"],
                "fecha" => $this->cita["fecha"],
                "hora" => $this->cita["hora"],
                "estado" => $this->cita["estado"],
                "cliente" => $clienteModel->find($this->cita["idCliente"]),
                "corte" => $corteModel->find($this->cita["idCorte"]),
                "barbero" => $barberoModel->find($this->cita["idBarbero"]),
                "barberia" => $barberiaModel->find($this->cita["idBarberia"])
            ]
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