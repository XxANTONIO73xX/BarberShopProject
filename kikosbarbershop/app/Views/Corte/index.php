<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="<?php base_url() ?>Corte/styles/estilos.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Akshar:wght@700&family=Roboto+Condensed:wght@300&family=Roboto:wght@900&display=swap"
        rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cortes</title>
</head>
<!--<img src="img/fondoKikos.png" class="pattern_background">-->
<nav class="navigation_bar">
    <img src="<?php base_url() ?>Corte/img/logoKikoNav.svg" class="logo_menu" width="150px" height="60px">
    <ul class="nv_list">
        <li><a href="../MainCliente/Main.html">Inicio</a></li>
        <li><a href="../Cita/index.html">Citas</a></li>
        <li><a href="../InformacionBarberia/index.html"">Más Información</a></li>
            <li><a href=" ../PerfilUsuario/index.html">⚙</a></li>
    </ul>

    <div class="bars__menu">
        <span class="line1__bars-menu"></span>
        <span class="line2__bars-menu"></span>
        <span class="line3__bars-menu"></span>
    </div>
</nav>

<div class="container__menu">
    <ul class="nv_list_mobile">
        <li><a href="../MainCliente/Main.html">Inicio</a></li>
        <li><a href="../Cita/index.html">Citas</a></li>
        <li><a href="../InformacionBarberia/index.html"">Más Información</a></li>
            <li><a href=" ../PerfilUsuario/index.html">⚙</a></li>
    </ul>
</div>

<div class="stripe">
    <div class="stripe_inner">
    </div>
</div>


<body>

    <div class="container" id="cardCortes">
        <div class="corte-card" >
            <img src="">
            <h4></h4>
        </div>
        

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        var url = 'http://api.kikosbarbershop.online/public/corte'
        $.ajax({
            type: "GET",
            url: url,
            data: {},
            dataType: "json",
            headers: {
                token: localStorage.getItem("token")
            }
        })
            .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

                console.log("info cortes")
                console.log(data)
                var div_cortes = "";

                data.cortes.forEach(r => {

                    div_cortes += `

                    <div class="corte-card" id="cardCortes">
                        <img src="${r.visualizacion}">
                        <h4>${r.nombre}</h4>
                    </div>
                    

                    `;

                });

                $("#cardCortes").html(div_cortes);

            });

    </script>

<script src="<?php base_url() ?>Corte/js/cortes.js"></script>
</body>

</html>