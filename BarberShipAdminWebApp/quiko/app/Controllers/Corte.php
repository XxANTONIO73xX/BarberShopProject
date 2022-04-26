<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\CortesModel;

class Corte extends BaseController
{
    protected $cortes;
    //protected $cliente;

    public function __construct(){
        $this->cortes = new CortesModel();
    }

    public function index(){
        $cortes = $this->cortes->findAll();
        $data = ['titulo' => 'Cortes', 'datos' => $cortes];

        echo view('header');
        echo view('cortes/cortes', $data);
        echo view('footer');

    }


    public function nuevo(){
        $data = ['titulo' => 'Agregar nuevo'];

        echo view('header');
        echo view('cortes/nuevo', $data);
        echo view('footer');

    }

    public function insertar(){

        if($this->request->getMethod() == "post" && $this->validate(['nombre' => 'required', 'visualización' => 'required'])){
        $this->cortes->save(['nombre' => $this->request->getPost('nombre'),'visualización' => $this->request->getPost('visualización')]);
        return redirect()->to(base_url().'/corte');
    }else{
        $data = ['titulo' => 'Agregar nuevo', 'validation' => $this->validator];

        echo view('header');
        echo view('cortes/nuevo', $data);
        echo view('footer');
    }

        
    }

    public function editar($id){
        $corte = $this->cortes->where('id',$id)->first();
        $data = ['titulo' => 'Editar unidad', 'datos'=>$corte];

        echo view('header');
        echo view('cortes/editar', $data);
        echo view('footer');

    }

    public function actualizar(){
        $this->cortes->update($this->request->getPost('id'),['nombre' => $this->request->getPost('nombre'),'visualización' => $this->request->getPost('visualización')]);
        return redirect()->to(base_url().'/corte');
    }

    public function eliminar($id){

        $this->cortes->delete($id);
        return redirect()->to(base_url().'/cortes');
    }
}
