    <link href="<?php base_url() ?>Corte/styles/estilos.css" rel="stylesheet">

    <div class="container" id="cardCortes">
        <div class="corte-card" >
            <img src="">
            <h4></h4>
        </div>
        

    </div>

    <!-- Su funcion es obtener todos los cortes y mostrarlos-->
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

                /*console.log("info cortes")
                console.log(data)*/
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

    <script>
        function getOut(){
            localStorage.removeItem("token");
            localStorage.removeItem("tipo");
            localStorage.removeItem("user");
            location.href = "<?php base_url() ?>/Log-In";
        }
    </script>

<script src="<?php base_url() ?>Corte/js/cortes.js"></script>
</body>

</html>