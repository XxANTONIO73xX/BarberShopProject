<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        return view('Usuario/index');
    }

    public function registro(){
        return view('Usuario/Registro');
    }
}