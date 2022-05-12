<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\BarberosModel;

class Barbero extends BaseController
{

    public function index(){
        $data = ['titulo' => 'Barberos'];

        echo view('header', $data);
        echo view('barberos/barberos');
        echo view('footer');

    }

}
