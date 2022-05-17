
        <link href="<?php base_url() ?>Home/styles/estilos.css" rel="stylesheet">

    <div class="background-filter"></div>
    <div class="container-page">

        <div class="front_face">
            <img src="<?php base_url() ?>Home/img/logoKikosInicio2.png" id="imagen_frente" height="400px" width="400px">
            <h1>Hola, ¡bienvenidos!</h1>
            <p>Agradecemos su confianza! Siempre listos, y con mucho gusto. Ofreciendo un servicio de calidad 💈💇🏻‍♂️✂️</p>
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