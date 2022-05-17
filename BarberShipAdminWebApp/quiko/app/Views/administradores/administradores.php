<link href="<?php base_url() ?>css/dragndrop.css" rel="stylesheet">
<main>
  <div class="container-fluid px-4">
    <h3 class="mt-4">Tabla de datos</h3>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Tables</li>
    </ol>

    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                              <h4 class="modal-title w-100 font-weight-bold">Añadir un Administrador</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form id="formulario" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <input type="hidden" id="idAdministrador" value="0">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre">
                                  </div>
                                  <div class="form-group">
                                    <label for="apellido" class="col-form-label">Apellido:</label>
                                    <input type="text" name="apellidos" class="form-control" id="apellido">
                                  </div>
                                  <div class="form-group">
                                    <label for="apellido" class="col-form-label">Correo:</label>
                                    <input type="text" name="correo" class="form-control" id="correo">
                                  </div>
                                  <div class="form-group">
                                    <label for="telefono" class="col-form-label">Telefono:</label>
                                    <input type="number" name="telefono" class="form-control" id="telefono">
                                  </div>

                                  <div class="form-group">
                                    <label for="pasword" class="col-form-label">Contraseña:</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                  </div>
                                  
                                  </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="guardar()">Guardar</button>
                              </div>
                            </div>
                          </div>
                        </div>
    <div>
      <a class="btn btn-info" data-toggle="modal" data-target="#modalAgregar" onclick="reset()">Agregar</a>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Tabla de Administradores
      </div>
      <div class="card-body">
        <table id="table" class="table table-striped" style="width: 100%">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>Acciones</th>

            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
          <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
          <script>
  $(document).ready(function() {
    var table = $('#table').DataTable({
      "ajax": {
        "url": 'http://api.kikosbarbershop.online/public/administrador',
        "dataSrc": "administradores",
        "type": 'GET',
        "beforeSend": function(xhr) {
          xhr.setRequestHeader('token', localStorage.getItem("token"));
        }
      },
      "columns": [{
          "data": 'id'
        },
        {
          "data": 'nombre'
        },
        {
          "data": 'apellidos'
        },
        {
          "data": 'correo'
        },
        {
          "data": 'telefono'
        },
        {"targets": -1, "data": null, "defaultContent":'<button class="btn btn-warning" name="editar" data-toggle="modal" data-target="#modalAgregar">  <i class="fas fa-pen"></i>  </button> <button class="btn btn-danger" name="cancelar">  <i class="fas fa-trash"></i>  </button>'}
      ]
    });
    $('#table tbody').on('click', "button[name='cancelar']", function() {
      var data = table.row($(this).parents('tr')).data();
      eliminar(data.id);
    });
    $('#table tbody').on('click', "button[name='editar']", function() {
      var data = table.row($(this).parents('tr')).data();
      $("#idAdministrador").val(data.id)
      var id = $("#idAdministrador").val();
      obtenerData(id);
    });
  });
</script>
<script>

function reset(){
              $("#idAdministrador").val(0);
              $("#nombre").val("");
              $("#apellido").val("");
              $("#correo").val("");
              $("#telefono").val("");
              $("#password").val("");
            }
function obtenerData(id){
              $.ajax({   //iniciar ajax para crar token   
                url: 'http://api.kikosbarbershop.online/public/administrador/' + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
                .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data
                    console.log("info tabla")
                    console.log(data.administrador)
                    $("#nombre").val(data.administrador.nombre);
                    $("#apellido").val(data.administrador.apellidos);
                    $("#correo").val(data.administrador.correo);
                    $("#telefono").val(data.administrador.telefono);
                    $("#password").val(data.administrador.pasword);
    });
            }
</script>
<script src="<?php base_url() ?>javascript/administrador/administrador.js"></script>
          <script>
            function guardar(){
              var id = $("#idAdministrador").val();
              var url = "http://api.kikosbarbershop.online/public/";
              if(id == 0){
                url += "administrador";
              }else{
                url += "administrador/update/" + id;
              }
              // new FormData(document.getElementById("formulario") 
              // console.log( $( "#formulario" ).serialize())
              dataFormulario =  new FormData(document.getElementById("formulario"));
              $.ajax({   //iniciar ajax para editar registro   
              url:  url,
              data: dataFormulario,
              type: "POST",
              cache: false,
              contentType: false,
              processData: false,
              dataType: "json",
              headers:{
                token: localStorage.getItem("token")
              }
            })
          .done(function( data, textStatus, jqXHR ) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Los datos fueron guardados correctamente',
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
          return false;
            }

            
            function eliminar(id){
              $.ajax({
                url:"http://api.kikosbarbershop.online/public/administrador/"  + id,
                data:{},
                type: "DELETE",
                dataType: "json",
                headers:{
                  token: localStorage.getItem("token")
                }
              }).done(function(data, textStatus, jqXHR){
                Swal.fire({
                  title: '¿Estas seguro de eliminar este registro?',
                  text: "No podras revertir estos cambios!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Eliminar'
            }).then((result) => {
              if(result.isConfirmed){
                Swal.fire(
                'Eliminado',
                'El registro ah sido eliminado correctamente.',
                'success'
                )
                window.location.reload()
              }
            })
              });
            }
          </script>