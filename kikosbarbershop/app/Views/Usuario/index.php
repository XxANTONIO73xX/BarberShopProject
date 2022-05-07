<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kikos : Perfil Usuario </title>
</head>

<body>

    <!--<img src="img/fondoKikos.png" class="pattern_background">-->
    <nav class="navigation_bar">
        <img src="<?php base_url() ?>Usuario/Perfil/img/logoKikoNav.svg" class="logo_menu" width="150px" height="60px">
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

        <div class=" bars__menu">
                    <span class="line1__bars-menu"></span>
                    <span class="line2__bars-menu"></span>
                    <span class="line3__bars-menu"></span>
                    <span class="line4__bars-menu"></span>
                    </div>
    </nav>

    <div class="stripe">
        <div class="stripe_inner">
        </div>
    </div>


    <form action="" onload="getInfoUsuario()">
        <div id="fitem_id_nombre" class="form-group row  fitem   ">
            <div class="col-md-3">
                <span class="float-sm-right text-nowrap">

                </span>
                <label class="col-form-label d-inline " id="nombre">
                    Nombre
                </label>
            </div>
            <div class="col-md-9 form-inline felement" data-fieldtype="text">
                <input type="text" class="form-control " name="nombre" readonly=""  id="id_nombre"
                    value="Nombre-usuario" id="nombre" size="30" maxlength="100" autocomplete="given-name">
            </div>
        </div>

        <br>

        <div id="fitem_id_apellidos" class="form-group row  fitem   ">
            <div class="col-md-3">
                <span class="float-sm-right text-nowrap">

                </span>
                <label class="col-form-label d-inline " for="id_apellidos">
                    Nombre
                </label>
            </div>
            <div class="col-md-9 form-inline felement" data-fieldtype="text">
                <input type="text" class="form-control " name="apellidos" readonly=""  id="id_apellidos"
                    value="Apellidos-Usuario" size="30" maxlength="100" autocomplete="given-name">

            </div>
        </div>

        <br>

        <div id="fitem_id_email" class="form-group row  fitem   ">
            <div class="col-md-3">
                <label class="col-form-label d-inline " for="id_email">
                    Correo Electronico
                </label>
            </div>
            <div class="col-md-9 form-inline felement" data-fieldtype="text">
                <input type="text" class="form-control " name="email" id="id_email"
                    value="jose.campa216584@potros.itson.edu.mx" size="30" maxlength="100" autocomplete="email">
                <div class="form-control-feedback invalid-feedback" id="id_error_email">

                </div>
            </div>
        </div>

        <br>
        
        <div id="fitem_id_telefono" class="form-group row  fitem   ">
            <div class="col-md-3">
                <label class="col-form-label d-inline " for="id_email">
                    Telefono
                </label>
            </div>
            <div class="col-md-9 form-inline felement" data-fieldtype="text">
                <input type="text" class="form-control " name="email" id="id_email" value="6221785566" size="30"
                    maxlength="100" autocomplete="email">
                <div class="form-control-feedback invalid-feedback" id="id_error_email">

                </div>
            </div>
        </div>
        


    </form>

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