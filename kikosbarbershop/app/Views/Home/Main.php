
        <link href="<?php base_url() ?>Home/styles/estilos.css" rel="stylesheet">

        <!--<img src="img/fondoKikos.png" class="pattern_background">-->

        <div class="front_face">
            <img src="<?php base_url() ?>Home/img/logoKikoNav.svg" id="imagen_frente" height="250px" width="500px">
            <h1>Hola, ¡bienvenidos!</h1>
            <p>En Kiko's rescatamos el arte de las antiguas barberías y la experiencia que en ellas se vivía.
Conjuntamos tradiciones, servicios de altos estándares de calidad e higiene.

Aquí encontrarás ese espacio que hemos perdido los hombres, donde cortarse el pelo y afeitarse se convierten en una terapia de amigos y relajación, más que en un hábito.</p>
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

            function getOut(){
                localStorage.removeItem("token");
                localStorage.removeItem("tipo");
                localStorage.removeItem("user");
                location.href = "<?php base_url() ?>/Log-In";
            }
        </script>
    </body>
</html>