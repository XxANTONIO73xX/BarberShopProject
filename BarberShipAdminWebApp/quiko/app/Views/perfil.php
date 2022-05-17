<div class="container-fluid px-4">
    <h3 class="mt-4">Datos de usuario</h3>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Gestión de perfil</li>
    </ol>
<div class="row">
  <div class="col-lg-4 col-xlg-3">
    <div class="card">
      <div class="card-body">
        <center class="mt-4"> <img src="<?php base_url() ?>assets/img/user.png" /> 
        <h5 class="card-text" name="titulo">Nombre de usuario</h5>
        <p class="card-text">Administrador actual.</p>
        </center>  
    </div>
    </div>
  </div>
  <div class="col-lg-8 col-xlg-9">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal form-material mx-2" id="formulario">
                                    <div class="form-group">
                                        <label class="col-md-12">Nombre</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Nombre" 
                                            class="form-control form-control-line" name="nombre" id="nombre">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellidos" class="col-md-12">Apellidos</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Apellido"
                                                class="form-control form-control-line" name="apellidos" id="apellidos">
                                        </div>
                                    <div class="form-group">
                                        <label for="correo" class="col-md-12">Correo electronico</label>
                                        <div class="col-md-12">
                                            <input type="email" placeholder="johnathan@admin.com"
                                                class="form-control form-control-line" name="correo" id="correo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Teléfono</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="123 456 7890"
                                                class="form-control form-control-line" name="telefono" id="telefono">
                                        </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Contraseña</label>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="password"
                                                class="form-control form-control-line" name="password" id="pasword">
                                        </div>
                                    </div>
                                    </div>
                                    </form>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-success" name="actualizar" id="actualizar">Actualizar perfil</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function formulario() { 
            var url = "http://api.kikosbarbershop.online/public/administrador/";

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
                var administrador = data.administrador; 

                
                $("h5[name='titulo']").text(administrador.nombre);
                $("input[name='nombre']").val(administrador.nombre);
                $("input[name='apellidos']").val(administrador.apellidos);
                $("input[name='correo']").val(administrador.correo);
                $("input[name='telefono']").val(administrador.telefono);
                $("input[name='password']").val(administrador.pasword);
                }); 
        }

        formulario();

        $('#actualizar').click(function() {

        console.log($("#nombre").val());
        console.log
        dataFormulario =  new FormData(document.getElementById("formulario"));
        console.log( $( "#formulario" ).serialize())
        $.ajax({
        url: "http://api.kikosbarbershop.online/public/administrador/update/" + localStorage.getItem("id"),
        data: dataFormulario,
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        headers: {
        token: localStorage.getItem("token")
        }
        })
        .done(function(data, res) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Los datos de la cuenta fueron guardados correctamente',
              showConfirmButton: true,
              timer: 6000
            }).then((result) => {
              if(result.isConfirmed){
                window.location.reload()
              }
            })
          })
          .fail(function(){
            alert("Sucedio un error, verifique si lleno todos los campos solicitados");
          });
        
        })
        .fail(function(data) {
            console.log(data);
            console.log($("#nombre").val());
            console.log($("#apellidos").val());
            console.log($("#correo").val());
            console.log($("#telefono").val());
            console.log($("#pasword").val());

        console.log("Error", "Ocurrio un problema al editar usuario")
        })
        
</script>