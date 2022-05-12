<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\AdministradoresModel;

class Administrador extends BaseController
{


    public function index(){

        $data = ['titulo' => 'Administradores'];

        echo view('header', $data);
        echo view('administradores/administradores');
        echo view('footer');

    }
}
