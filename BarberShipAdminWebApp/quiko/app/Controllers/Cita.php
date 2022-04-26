<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\CitasModel;

class Cita extends BaseController
{
    protected $citas;
    //protected $cliente;

    public function __construct(){
        $this->citas = new CitasModel();
    }

    public function index(){
        $citas = $this->citas->findAll();
        $data = ['titulo' => 'Citas', 'datos' => $citas];

        echo view('header');
        echo view('citas/citas', $data);
        echo view('footer');

    }


    public function nuevo(){
        $data = ['titulo' => 'Agregar nuevo'];

        echo view('header');
        echo view('citas/nuevo', $data);
        echo view('footer');

    }

    public function insertar(){

        if($this->request->getMethod() == "post" && $this->validate(['fecha' => 'required', 'hora' => 'required', 'estado' => 'required', 'idCliente' => 'required', 'idCorte' => 'required','idBarbero' => 'required','idBarberia' => 'required'])){
        $this->citas->save(['fecha' => $this->request->getPost('fecha'),'hora' => $this->request->getPost('hora'), 'estado' => $this->request->getPost('estado'), 'idCliente' => $this->request->getPost('idCliente'),'idCorte' => $this->request->getPost('idCorte'),'idBarbero' => $this->request->getPost('idBarbero'), 'idBarberia' => $this->request->getPost('idBarberia')]);
        return redirect()->to(base_url().'/cita');
    }else{
        $data = ['titulo' => 'Agregar nuevo', 'validation' => $this->validator];

        echo view('header');
        echo view('citas/nuevo', $data);
        echo view('footer');
    }

        
    }

    public function editar($id){
        $cita = $this->citas->where('id',$id)->first();
        $data = ['titulo' => 'Editar unidad', 'datos'=>$cita];

        echo view('header');
        echo view('citas/editar', $data);
        echo view('footer');

    }

    public function actualizar(){
        $this->citas->update($this->request->getPost('id'),['fecha' => $this->request->getPost('fecha'),'hora' => $this->request->getPost('hora'), 'estado' => $this->request->getPost('estado'), 'idCliente' => $this->request->getPost('idCliente'),'idCorte' => $this->request->getPost('idCorte'),'idBarbero' => $this->request->getPost('idBarbero'), 'idBarberia' => $this->request->getPost('idBarberia')]);
        return redirect()->to(base_url().'/cita');
    }

    public function eliminar($id){

        $this->citas->delete($id);
        return redirect()->to(base_url().'/cita');
    }
}
