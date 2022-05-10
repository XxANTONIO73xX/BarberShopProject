<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = ['titulo' => 'Dashboard'];
        echo view('header', $data);
        echo view('inicio');
        echo view('footer');
    }
}
