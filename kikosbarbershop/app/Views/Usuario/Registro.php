<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="<?php base_url() ?>Usuario/Registro/styles/estilos.css" rel="stylesheet">
    <a href=""></a>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Akshar:wght@700&family=Roboto+Condensed:wght@300&family=Roboto:wght@900&display=swap"
        rel="stylesheet">
    <title>Registrarse</title>
</head>

<body>

    <div class="stripe">
        <div class="stripe_inner">
        </div>
    </div>

    <div class="login-pos">
        <div class="login-box">

            <h1>
                <img src="<?php base_url() ?>Usuario/Registro/img/logoKikosInicio2.png" width="250px" height="200px">
            </h1>

            <form class="login-form">
                <input id="nombre" placeholder="Nombre" type="text" required>
                <input id="apellidos" placeholder="Apellidos" type="text" required>
                <input id="correo" placeholder="Correo" type="email" required>
                <input id="telefono" placeholder="Teléfono" type="tel" required>
                <input id="password" placeholder="Contraseña" type="password" required>
                <input id="check_password" placeholder="Confirmar contraseña" type="password" required>
                <span id="error_pssd"></span>


                <button type="button" id="registrar_usuario">Registrarse</button>
            </form>

        </div>
    </div>

    <!--
        Este script sirve para verificar si las contraseñas ingresadas en el
        registro concuerdan, dando diferentes mensajes.
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).keyup(function () {
            var password = $('#password').val();
            var check_password = $('#check_password').val();

            if (password == check_password) {
                $('#error_pssd').text("Contraseñas coinciden!");
            } else {
                $('#error_pssd').text("Contraseñas no coinciden!");
            }

            if (check_password == "") {
                $('#error_pssd').text("No se puede dejar en blanco!");
            }
        })
    </script>

    <!-- Este script sirve para evniar los datos del formulario 
        de registro de cliente y guardarlos en la 
        base de datos del servidor-->
    <script>

        var url = 'http://api.kikosbarbershop.online/public/cliente';
        $('#registrar_usuario').click(function () {

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "nombre": $("#nombre").val(),
                    "apellidos": $("#apellidos").val(),
                    "correo": $("#correo").val(),
                    "telefono": $("#telefono").val(),
                    "password": $("#password").val()
                },
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
                .done(function (data) {
                    $('#respuesta').html(data);
                    /*console.log("El usuarios se ha registrado con exito");
                    console.log(data);*/
                    
                    location.href = "<?php base_url()?>Log-In";
                })
                .fail(function () {
                    console.log("Error", "Ocurrio un problema al registrar el usuario")
                })
        });

    </script>

</body>

</html>