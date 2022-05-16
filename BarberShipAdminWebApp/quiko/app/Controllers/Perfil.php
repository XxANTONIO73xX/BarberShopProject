<?php

namespace App\Controllers;

Class Perfil extends BaseController
{
    public function index()
    {
        $data = ['titulo' => 'Perfil'];
        echo view('header', $data);
        echo view('perfil');
        echo view('footer');

    }
}

?>