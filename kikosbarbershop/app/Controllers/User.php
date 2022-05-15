<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $data = ["titulo" => "Editar Usuario"];
        echo view('header', $data);
        echo view('Usuario/index');
    }

    public function registro(){
        return view('Usuario/Registro');
    }
}