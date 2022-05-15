<?php

namespace App\Controllers;

class Corte extends BaseController
{
    public function index()
    {
        $data = ["titulo" => "Cortes"];
        echo view('header', $data);
        echo view('Corte/index');
    }
}