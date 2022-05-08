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
        </div>
    </nav>

    <div class="stripe">
        <div class="stripe_inner">
        </div>
    </div>


    <div action="">
        <div id="fitem_id_nombre" class="form-group row  fitem   ">
            <div class="col-md-3">
                <span class="float-sm-right text-nowrap">

                </span>
                <label>
                    Nombre
                </label>
            </div>
            <div class="col-md-9 form-inline felement" data-fieldtype="text">
                <input type="text" class="form-control " name="nombre" id="nombre">
            </div>
        </div>

        <br>

        <div id="fitem_id_apellidos" class="form-group row  fitem   ">
            <div class="col-md-3">
                <span class="float-sm-right text-nowrap">

                </span>
                <label class="col-form-label d-inline " for="id_apellidos">
                    Apellidos
                </label>
            </div>
            <div class="col-md-9 form-inline felement" data-fieldtype="text">
                <input type="text" class="form-control " name="apellidos" id="apellidos"
                 size="30" maxlength="100" autocomplete="given-name">
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
                <input type="text" class="form-control " name="email" id="correo"
                    value="jose.campa216584@potros.itson.edu.mx" size="30" maxlength="100" autocomplete="email">
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
                <input type="text" class="form-control " name="telefono" id="telefono" value="6221785566" size="30"
                    maxlength="100" autocomplete="email">
            </div>
        </div>
        
        <button id="guardar">guardar</button>

</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

  <script>

    var url = "http://api.kikosbarbershop.online/public/cliente/";

        function llenarForm() { 
        $.ajax({ 
            url: url + localStorage.getItem("id"),
            data: {},
            type: "GET",
            dataType: "json",
            headers:{
            token: localStorage.getItem("token")
            }
            })
            .done(function( data, textStatus, jqXHR ) {  
            var cliente = data.cliente; 

            console.log(data.cliente);

            $("input[name='nombre']").val(cliente.nombre);
            $("input[name='telefono']").val(cliente.telefono);
            $("input[name='email']").val(cliente.correo);
            $("input[name='apellidos']").val(cliente.apellidos);
            }); 
            }

            llenarForm();

        $('#guardar').click(function() {

        console.log($("#nombre").val());

        $.ajax({
            url: "http://api.kikosbarbershop.online/public/cliente/update/" + localStorage.getItem("id"),
            type: 'POST',
            data: {
            "nombre": $("#nombre").val(),
            "apellidos": $("#apellidos").val(),
            "correo": $("#correo").val(),
            "telefono": $("#telefono").val()
            },
            dataType: "json",
            headers: {
            token: localStorage.getItem("token")
            }
        })
        .done(function(data, res) {
            console.log("La cita ha sido guardada con exito");
            console.log(data);
        })
        .fail(function() {
            console.log("Error", "Ocurrio un problema al editar usuario")
        })
        });

  </script>


</body>

</html>