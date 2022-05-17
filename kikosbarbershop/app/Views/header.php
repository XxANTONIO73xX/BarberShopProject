<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
//hay session ?
if(!localStorage.getItem("user")){
  location.href="<?php base_url() ?>/Log-In";
}
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="<?php base_url() ?>header/estilosHeader.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@700&family=Roboto+Condensed:wght@300&family=Roboto:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titulo?> | Kiko's BarberShop</title>
</head>
<!--<img src="img/fondoKikos.png" class="pattern_background">-->
<nav class="navigation_bar">
  <img src="<?php base_url() ?>header/img/nuevoLogoKikoNav3.png" class="logo_menu" width="120px" height="60px">
  <ul class="nv_list">
    <li><a href="<?php base_url() ?>Inicio">Inicio</a></li>
    <li><a href="<?php base_url() ?>Citas">Tus Citas</a></li>
    <li><a href="<?php base_url() ?>Cortes">Cortes</a></li>
  </ul>

  <div class="bars__menu">
    <span class="line1__bars-menu"></span>
    <span class="line2__bars-menu"></span>
    <span class="line3__bars-menu"></span>
  </div>

  <div class="nav-desplegable">
    <ul class="menu-desplegable">
      <li><a>⚙</a>
        <ul class="menu-desplegable_options">
          <li id="edit-button"><a href="<?php base_url() ?>Cliente">Editar usuario</a></li>
          <li id="logout-button"><a href="#" onclick="out_confirmacion()">Cerrar sesión</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<div class="stripe">
  <div class="stripe_inner">
  </div>
</div>

<div class="container__menu">
  <ul class="nv_list_mobile">
    <li><a id="mobile-a" href="<?php base_url() ?>Inicio">Inicio</a></li>
    <li><a id="mobile-a" href="<?php base_url() ?>Citas">Tus Citas</a></li>
    <li><a id="mobile-a" href="<?php base_url() ?>Cortes">Cortes</a></li>
    <li id="edit-button_mobile"><a href="<?php base_url() ?>Cliente">Editar usuario</a></li>
    <li id="logout-button_mobile"><a href="#" onclick="out_confirmacion()">Cerrar sesión</a></li>
  </ul>
</div>

<!-- Instalar swalfire-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Cerrar sesion -->
<script>

    function out_confirmacion(){

    Swal.fire({
      title: '¿Desea cerrar sesion?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cerrar Sesion'
    }).then((result) => {
    if (result.isConfirmed) {
        getOut();   
    }
    });

    }

    function getOut(){
    localStorage.removeItem("token");
    localStorage.removeItem("tipo");
    localStorage.removeItem("user");
    location.href = "<?php base_url() ?>/Log-In";
    }

</script>

<body>

