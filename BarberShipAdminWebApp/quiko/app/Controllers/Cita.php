<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\CitasModel;

class Cita extends BaseController
{


    public function index(){

        $data = ['titulo' => 'Citas'];

        echo view('header', $data);
        echo view('citas/citas');
        echo view('footer');

    }
}
