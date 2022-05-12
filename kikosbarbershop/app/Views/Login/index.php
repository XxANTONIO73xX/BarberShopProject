<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="<?php base_url() ?>Login/styles/estilos.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@700&family=Roboto+Condensed:wght@300&family=Roboto:wght@900&display=swap" rel="stylesheet">
    <title>Iniciar Sesion</title>
</head>

<div class="stripe">
    <div class="stripe_inner"></div>
</div>

<body>
    <div class="login-position">
        <div class="login-content">
            <img src="<?php base_url() ?>Cita/img/logoKikoNav.svg" class="logo_menu" width="390px" height="190px">
            <div class="login-content-body">
                <input id="user" placeholder="Username" type="text" />
                <input id="password" placeholder="Password" type="password" />
                <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" onclick="login()">Iniciar sesión</button>
            </div>
            <footer>
                <h6>Oh, ¿no te has registrado?</h6>
                <h5>Da click para registrarte: <a target="_blank" href="<?php base_url() ?>Registro">registrate aquí</a></h5>
            </footer>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        function login() { //inicio login al dar clic al boton
            var url = "http://api.kikosbarbershop.online/public/auth";

            $.ajax({   //iniciar ajax para crar token   
                url: url,
                data: {
                    "user": $("#user").val(),
                    "password": $("#password").val(),
                    "tipo": "cliente"
                },
                type: "POST",
                dataType: "json",
            })
                .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

                    console.log("hola le di clic al boton")
                    console.log(data)

                    if (typeof data.error !== "string") {
                        localStorage.setItem("token", data.token);
                        localStorage.setItem("tipo", data.tipo);
                        var user = JSON.parse(JSON.stringify(data.user));
                        localStorage.setItem("user", user);
                        localStorage.setItem("id", user["id"]);
                        console.log("Encontro el usuario");
                        location.href = "<?php base_url() ?>Inicio";
                    } else {
                        alert(data.error);
                    }


                })
                .fail(function (jqXHR, textStatus, errorThrown) { // si hay algun error, esta en textStatus

                    console.log("La solicitud a fallado: " + textStatus);

                })
        }
    </script>


</body>

</html>