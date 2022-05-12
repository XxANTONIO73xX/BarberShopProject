<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\BarberiasModel;

class Barberia extends BaseController
{

    public function index(){
        $data = ['titulo' => 'Barberias'];

        echo view('header', $data);
        echo view('barberias/barberias');
        echo view('footer');

    }

}
