<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\ClientesModel;

class Cliente extends BaseController
{

    public function index(){

        $data = ['titulo' => 'Clientes'];

        echo view('header', $data);
        echo view('clientes/clientes');
        echo view('footer');

    }
}
