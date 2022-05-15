<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = ["titulo" => "Inicio"];
        echo view('header', $data);
        echo view('Home/Main');
    }
}
