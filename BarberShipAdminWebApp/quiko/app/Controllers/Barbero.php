<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\BarberosModel;

class Barbero extends BaseController
{
    protected $barberos;
    //protected $cliente;

    public function __construct(){
        $this->barberos = new BarberosModel();
    }

    public function index(){
        $barberos = $this->barberos->findAll();
        $data = ['titulo' => 'Barberos', 'datos' => $barberos];

        echo view('header');
        echo view('barberos/barberos', $data);
        echo view('footer');

    }


    public function nuevo(){
        $data = ['titulo' => 'Agregar nuevo'];

        echo view('header');
        echo view('barberos/nuevo', $data);
        echo view('footer');

    }

    public function insertar(){

        if($this->request->getMethod() == "post" && $this->validate(['nombre' => 'required', 'apellidos' => 'required','apodo' => 'required', 'correo' => 'required', 'telefono' => 'required', 'password' => 'required', 'idBarberia' => 'required'])){
        $this->barberos->save(['nombre' => $this->request->getPost('nombre'),'apellidos' => $this->request->getPost('apellidos'),'apodo' => $this->request->getPost('apodo'), 'correo' => $this->request->getPost('correo'), 'telefono' => $this->request->getPost('telefono'), 'password' => $this->request->getPost('password'),'idBarberia' => $this->request->getPost('idBarberia')]);
        return redirect()->to(base_url().'/barbero');
    }else{
        $data = ['titulo' => 'Agregar nuevo', 'validation' => $this->validator];

        echo view('header');
        echo view('barberos/nuevo', $data);
        echo view('footer');
    }

        
    }

    public function editar($id){
        $barbero = $this->barberos->where('id',$id)->first();
        $data = ['titulo' => 'Editar unidad', 'datos'=>$barbero];

        echo view('header');
        echo view('barberos/editar', $data);
        echo view('footer');

    }

    public function actualizar(){
        $this->barberos->update($this->request->getPost('id'),['nombre' => $this->request->getPost('nombre'),'apellidos' => $this->request->getPost('apellidos'),'apodo' => $this->request->getPost('apodo'), 'correo' => $this->request->getPost('correo'), 'telefono' => $this->request->getPost('telefono'), 'password' => $this->request->getPost('password'),'idBarberia' => $this->request->getPost('idBarberia')]);
        return redirect()->to(base_url().'/barbero');
    }

    public function eliminar($id){

        $this->barberos->delete($id);
        return redirect()->to(base_url().'/barbero');
    }
}
