<?php

namespace App\Controllers;

use App\Controllers\BaseCntroller;
use App\Models\CortesModel;

class Corte extends BaseController
{


    public function index(){

        $data = ['titulo' => 'Cortes'];

        echo view('header', $data);
        echo view('cortes/cortes');
        echo view('footer');

    }
}
