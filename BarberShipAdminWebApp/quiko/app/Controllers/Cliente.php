<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\ClientesModel;

class Cliente extends BaseController
{
    protected $clientes;
    //protected $cliente;

    public function __construct(){
        $this->clientes = new ClientesModel();
    }

    public function index(){
        $clientes = $this->clientes->findAll();
        $data = ['titulo' => 'Clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/clientes', $data);
        echo view('footer');

    }


    public function nuevo(){
        $data = ['titulo' => 'Agregar nuevo'];

        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');

    }

    public function insertar(){

        if($this->request->getMethod() == "post" && $this->validate(['nombre' => 'required', 'apellidos' => 'required', 'correo' => 'required', 'telefono' => 'required', 'password' => 'required'])){
        $this->clientes->save(['nombre' => $this->request->getPost('nombre'),'apellidos' => $this->request->getPost('apellidos'), 'correo' => $this->request->getPost('correo'), 'telefono' => $this->request->getPost('telefono'), 'password' => $this->request->getPost('password')]);
        return redirect()->to(base_url().'/cliente');
    }else{
        $data = ['titulo' => 'Agregar nuevo', 'validation' => $this->validator];

        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

        
    }

    public function editar($id){
        $cliente = $this->clientes->where('id',$id)->first();
        $data = ['titulo' => 'Editar unidad', 'datos'=>$cliente];

        echo view('header');
        echo view('clientes/editar', $data);
        echo view('footer');

    }

    public function actualizar(){
        $this->clientes->update($this->request->getPost('id'),['nombre' => $this->request->getPost('nombre'),'apellidos' => $this->request->getPost('apellidos'), 'correo' => $this->request->getPost('correo'), 'telefono' => $this->request->getPost('telefono'), 'password' => $this->request->getPost('password')]);
        return redirect()->to(base_url().'/cliente');
    }

    public function eliminar($id){

        $this->clientes->delete($id);
        return redirect()->to(base_url().'/cliente');
    }
}
