<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="<?php base_url() ?>template/css/styles.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    </head>

    <body>
        
    <div class="page">

        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo-container">
                    <div class="logo-container">
                        <a href="http://localhost/quiko/public/home"><img class="logo-sidebar" src="<?php base_url() ?>template/img/logoKikoNav.svg" /></a>
                    </div>
                    <div class="brand-name-container">
                        <p class="brand-name">
                            Admin
                            <span class="brand-subname">
                                Workspace
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="navigation-list">
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="http://localhost/quiko/public/Administrador">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                <div class="col-9">
                                    Administrador
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="http://localhost/quiko/public/Barbero">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="col-9">
                                    Barberos
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="http://localhost/quiko/public/Barberia">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-store-alt"></i>
                                </div>
                                <div class="col-9">
                                    Barberias
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="http://localhost/quiko/public/Cita">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="col-9">
                                    Citas
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="http://localhost/quiko/public/Corte">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-cut"></i>
                                </div>
                                <div class="col-9">
                                    Cortes
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="http://localhost/quiko/public/Cliente">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-address-book"></i>
                                </div>
                                <div class="col-9">
                                    Clientes
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a class="navigation-link" href="/">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-address-card"></i>
                                </div>
                                <div class="col-9">
                                    Perfil
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="content">
            <nav class="navigationBar">
                <h3>$variable titulo alv</h3>
                <div class="navigation-list-item-sing-out">
                    <a class="navigation-link" href="/">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div class="col-9">
                                Cerrar Sesión 
                            </div>
                        </div>
                    </a>
                </div>
            </nav>