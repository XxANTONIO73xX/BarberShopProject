<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\AdministradoresModel;

class Administrador extends BaseController
{
    protected $administradores;
    protected $reglasLogin;
    //protected $cliente;

    public function __construct(){
        $this->administradores = new AdministradoresModel();

        helper(['form']);

        $this->reglasLogin = [
            'correo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo (field} es obligatorio.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo (field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index(){
        $administradores = $this->administradores->findAll();
        $data = ['titulo' => 'Administradores', 'datos' => $administradores];

        echo view('header');
        echo view('administradores/administradores', $data);
        echo view('footer');

    }


    public function nuevo(){
        $data = ['titulo' => 'Agregar nuevo'];

        echo view('header');
        echo view('administradores/nuevo', $data);
        echo view('footer');

    }

    public function insertar(){

        if($this->request->getMethod() == "post" && $this->validate(['nombre' => 'required', 'apellidos' => 'required', 'correo' => 'required', 'telefono' => 'required', 'password' => 'required'])){
        $this->administradores->save(['nombre' => $this->request->getPost('nombre'),'apellidos' => $this->request->getPost('apellidos'), 'correo' => $this->request->getPost('correo'), 'telefono' => $this->request->getPost('telefono'), 'password' => $this->request->getPost('password')]);
        return redirect()->to(base_url().'/cliente');
    }else{
        $data = ['titulo' => 'Agregar nuevo', 'validation' => $this->validator];

        echo view('header');
        echo view('administradores/nuevo', $data);
        echo view('footer');
    }

        
    }

    public function editar($id){
        $administradores = $this->clientes->where('id',$id)->first();
        $data = ['titulo' => 'Editar unidad', 'datos'=>$cliente];

        echo view('header');
        echo view('administradores/editar', $data);
        echo view('footer');

    }

    public function actualizar(){
        $this->administradores->update($this->request->getPost('id'),['nombre' => $this->request->getPost('nombre'),'apellidos' => $this->request->getPost('apellidos'), 'correo' => $this->request->getPost('correo'), 'telefono' => $this->request->getPost('telefono'), 'password' => $this->request->getPost('password')]);
        return redirect()->to(base_url().'/administrador');
    }

    public function eliminar($id){

        $this->clientes->delete($id);
        return redirect()->to(base_url().'/administrador');
    }
    public function login(){
        echo view('login');
    }

    public function valida(){
        if($this->request->getMethod() == "post" && $this->validate(['correo' => 'required', 'password' => 'required'])){
            $administrador = $this->request->getPost('correo');
            $password = $this->request->getPost('password');
            $datoaAdministrador = $this->administradores->where('correo', $administrador)->first();

            if($datoaAdministrador != null){
                if(password_verify($password, $datoaAdministrador['password'])){
                    $datosSesion = [
                        'id_administrador' => $datoaAdministrador['id'],
                        'nombre' => $datoaAdministrador['nombre'],
                        'apellidos' => $datoaAdministrador['apellidos']
                    ];
                    $session = session();
                    $session->set($datosSesion);
                    return redirect()->to(base_url(). '/home');
                }else{
                    $data['error'] = "La clave no existe";
                    echo view('login', $data);
                }

              
            }else{
                $data['error'] = "El usuario no existe";
                echo view('login', $data);
            }
        }else{
            $data = ['validation' => $this->validator];
            echo view('login', $data);
        }
    }
}
