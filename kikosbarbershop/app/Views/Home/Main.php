<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=, initial-scale=1.0">
        <link href="<?php base_url() ?>Home/styles/estilos.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@700&family=Roboto+Condensed:wght@300&family=Roboto:wght@900&display=swap" rel="stylesheet">  
        <title>Kiko's Barber Shop</title>
    </head>

    <div class="stripe">
        <div class="stripe_inner">
        </div>
    </div>

    <body>
        <!--<img src="img/fondoKikos.png" class="pattern_background">-->
        <nav class="navigation_bar">
        <img src="<?php base_url() ?>Cita/img/logoKikoNav.svg" class="logo_menu" width="150px" height="60px">
        <ul class="nv_list">
            <li><a href="<?php base_url() ?>Inicio">Inicio</a></li>
            <li><a href="<?php base_url() ?>Citas">Citas</a></li>
            <li><a href="<?php base_url() ?>Cortes">Cortes</a></li>
            <li><a href="">Más Información</a></li>
            <li><a>⚙</a>
            <ul>
                <li id="nav-desplegable"><a href="<?php base_url() ?>Cliente">Editar usuario</a></li>
                <li id="nav-desplegable"><a href="#" onclick="getOut()">Cerrar sesión</a></li>
            </ul>
            </li>
        </ul>

        <div class="bars__menu">
            <span class="line1__bars-menu"></span>
            <span class="line2__bars-menu"></span>
            <span class="line3__bars-menu"></span>
        </div>
        </nav>

        <div class="front_face">
            <img src="<?php base_url() ?>Home/img/logoKikoNav.svg" id="imagen_frente" height="250px" width="500px">
            <h1>Hola, ¡bienvenidos!</h1>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempora nam, nemo libero minus tenetur fugit optio ipsum dolorum at aut laboriosam numquam repellendus sed. Modi placeat repellendus exercitationem officiis quam!</p>
        </div>

        <div class="position-slider">
            <div class="slider1">
                <div class="slides1">

                    <input type="radio" name="boton_radio" id="radio1">
                    <input type="radio" name="boton_radio" id="radio2">
                    <input type="radio" name="boton_radio" id="radio3">
                    <input type="radio" name="boton_radio" id="radio4">

                    <div class="slide first">
                        <img src="<?php base_url() ?>Home/img/barberia1.jpg" width="100%" height="100%" alt="">
                    </div>
                    <div class="slide1">
                        <img src="<?php base_url() ?>Home/img/barberia2.jpg" width="100%" height="100%" alt="">
                    </div>
                    <div class="slide1">
                        <img src="<?php base_url() ?>Home/img/barberia3.jpg" width="100%" height="100%" alt="">
                    </div>
                    <div class="slide1">
                        <img src="<?php base_url() ?>Home/img/barberia4.jpg" width="100%" height="100%" alt="">
                    </div>

                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                        <div class="auto-btn4"></div>
                    </div>
                </div>

                <div class="navigation-manual">
                    <label for="radio1" class="manual-btn"></label>
                    <label for="radio2" class="manual-btn"></label>
                    <label for="radio3" class="manual-btn"></label>
                    <label for="radio4" class="manual-btn"></label>
                </div>
            </div>
        </div>

        <div class="container__menu">
            <ul class="nv_list_mobile">
                <li><a href="../Cita/index.html">Cita</a></li>
                <li><a href="../Corte/index.html">Cortes</a></li>
                <li><a href="../InformacionBarberia/index.html"">Más Información</a></li>
            </ul>
        </div>

        <script src="<?php base_url() ?>Home/js/main.js"></script>

        <script>
    //hay session ?
    if(!localStorage.getItem("user")){
      location.href="<?php base_url() ?>/Log-In";
    }

    function getOut(){
        localStorage.removeItem("token");
        localStorage.removeItem("tipo");
        localStorage.removeItem("user");
        location.href = "<?php base_url() ?>/Log-In";
    }
  </script>
    </body>
</html>