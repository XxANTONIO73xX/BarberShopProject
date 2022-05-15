<?php

namespace App\Controllers;

class Cita extends BaseController
{
    public function index()
    {
        $data = ["titulo" => "Citas"];
        echo view('header', $data);
        echo view('Cita/index');
    }
}