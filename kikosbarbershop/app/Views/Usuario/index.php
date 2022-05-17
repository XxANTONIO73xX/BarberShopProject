
    <link href="<?php base_url() ?>Usuario/EditarUsuario/styles/estilosUsuario.css" rel="stylesheet">

    <div class="stripe">
        <div class="stripe_inner">
        </div>
    </div>

    <div class="editar-perfil_container">
        <div class="editar-perfil_content">
            <div id="fitem_id_nombre" class="group-editar_nombre">
                <div class="col-md-3">
                    <label>Nombre:</label>
                </div>
                <div class="col-md-9 form-inline felement" data-fieldtype="text">
                    <input type="text" class="form-control " name="nombre" id="nombre">
                </div>
            </div>

            <div id="fitem_id_apellidos" class="group-editar_apellidos">
                <div class="col-md-3">
                    <label class="col-form-label d-inline " for="id_apellidos">Apellidos:</label>
                </div>
                <div class="col-md-9 form-inline felement" data-fieldtype="text">
                    <input type="text" class="form-control " name="apellidos" id="apellidos" size="30" maxlength="100" autocomplete="given-name">
                </div>
            </div>

            <div id="fitem_id_email" class="group-editar_correo">
                <div class="col-md-3">
                    <label class="col-form-label d-inline " for="id_email">Correo:</label>
                </div>
                <div class="col-md-9 form-inline felement" data-fieldtype="text">
                    <input type="text" class="form-control " name="email" id="correo"
                        value="" size="30" maxlength="100" autocomplete="email">
                </div>
            </div>
            
            <div id="fitem_id_telefono" class="group-editar_telefono">
                <div class="col-md-3">
                    <label class="col-form-label d-inline " for="id_email">Teléfono:</label>
                </div>
                <div class="col-md-9 form-inline felement" data-fieldtype="text">
                    <input type="text" class="form-control " name="telefono" id="telefono" value="" size="30" maxlength="100" autocomplete="email">
                </div>
            </div>
        
        <button id="guardar">guardar</button>
        </div>
</div>

    <script>

        function getOut(){
            localStorage.removeItem("token");
            localStorage.removeItem("tipo");
            localStorage.removeItem("user");
            location.href = "<?php base_url() ?>/Log-In";
        }
    </script>
<script src="<?php base_url() ?>Usuario/EditarUsuario/js/usuario.js"></script>
    <script>     

        function llenarForm() { 
            var url = "http://api.kikosbarbershop.online/public/cliente/";

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

                /*console.log(data.cliente);*/

                $("input[name='nombre']").val(cliente.nombre);
                $("input[name='telefono']").val(cliente.telefono);
                $("input[name='email']").val(cliente.correo);
                $("input[name='apellidos']").val(cliente.apellidos);
                }); 
        }

        llenarForm();

        $('#guardar').click(function() {

        /*console.log($("#nombre").val());*/

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
            /*console.log(data);*/
            location.href = "<?php base_url() ?>Cliente";
        })
        .fail(function() {
            console.log("Error", "Ocurrio un problema al editar usuario")
        })
        });

    </script>


</body>

</html>