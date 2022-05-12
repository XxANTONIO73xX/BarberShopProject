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
                              <h4 class="modal-title w-100 font-weight-bold">Añadir una nueva barberia</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form id="formulario" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <input type="hidden" id="idBarberia" value="0">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre">
                                  </div>
                                  <div class="form-group">
                                    <label for="direccion" class="col-form-label">Direccion:</label>
                                    <input type="text" name="direccion" class="form-control" id="direccion">
                                  </div>
                                  <div class="form-group">
                                    <label for="telefono" class="col-form-label">Telefono:</label>
                                    <input type="number" name="telefono" class="form-control" id="telefono">
                                  </div>
                                  <div class="form-group">
                                    <label for="correo" class="col-form-label">Correo:</label>
                                    <input type="text" name="correo" class="form-control" id="correo">
                                  </div>
                                  <div class="form-group">
                                    <label for="horario" class="col-form-label">Horario:</label>
                                    <input type="text" name="horario" class="form-control" id="horario">
                                  </div>
                                  <div class="form-group">
                                    <label for="estado" class="col-form-label">Estado:</label>
                                    <input type="text" name="estado" class="form-control" id="estado">
                                  </div>
                                  <div class="form-group">
                                      <input type="file" name="featured_image" class="form-control" id="inputGroupFile02">
                                    <div class="preview">
                                      <label>Visualización</label>
                                      <img src="<?php base_url() ?>assets/img/ImageNotFound.png" alt="visualización">
                                    </div>
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
                                Tabla de Barberias
                            </div>
                            <div class="card-body">
                                <table id="table" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Direccion</th>
                                            <th>Telefono</th>
                                            <th>Correo</th>
                                            <th>Horario</th>
                                            <th>Estado</th>
                                            <th>URL</th>
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
                        "url": 'http://api.kikosbarbershop.online/public/barberia',
                        "dataSrc": "barberias",
                        "type": 'GET',
                        "beforeSend": function(xhr) {
                        xhr.setRequestHeader('token', localStorage.getItem("token"));
                        }
                    },
                    "columns":[
                        {"data": 'id'},
                        {"data": 'nombre'},
                        {"data": 'direccion'},
                        {"data":'telefono'},
                        {"data": 'correo'},
                        {"data":'horario'},
                        {"data":'estado'},
                        {"data": "visualizacion", "visible": false},
                        {"targets": -1, "data": null, "defaultContent":'<button class="btn btn-warning" name="editar" data-toggle="modal" data-target="#modalAgregar">  <i class="fas fa-pen"></i>  </button> <button class="btn btn-danger" name="cancelar">  <i class="fas fa-trash"></i>  </button> </button> <button class="btn btn-success" name="imagen">  <i class="fas fa-image"></i>  </button>'}      
                    ]
                    });

                    $('#table tbody').on( 'click', "button[name='cancelar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    eliminar(data.id);
                    });

                    $('#table tbody').on( 'click', "button[name='editar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $("#idBarberia").val(data.id)
                    var id = $("#idBarberia").val();
                    obtenerData(id);
                    });

                    $('#table tbody').on( 'click', "button[name='imagen']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    window.open(data.visualizacion);
                  });

                });
          </script>
          <script>
              function reset(){
              $("#idBarberia").val(0);
              $("#nombre").val("");
              $("#direccion").val("");
              $("#telefono").val("");
              $("#correo").val("");
              $("#horario").val("");
              $("#estado").val("");
              const preview = document.querySelector(".preview");
              const img = preview.querySelector('img');
              img.src = "<?php base_url() ?>assets/img/ImageNotFound.png";
              }

              function obtenerData(id){
              $.ajax({   //iniciar ajax para crar token   
                url: 'http://api.kikosbarbershop.online/public/barberia/' + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
                .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data
                    console.log("info tabla")
                    console.log(data.barberia)
                    $("#nombre").val(data.barberia.nombre);
                    $("#direccion").val(data.barberia.direccion);
                    $("#telefono").val(data.barberia.telefono);
                    $("#correo").val(data.barberia.correo);
                    $("#horario").val(data.barberia.horario);
                    $("#estado").val(data.barberia.estado);
                    const preview = document.querySelector(".preview");
                    const img = preview.querySelector('img');
                    img.src = data.barberia.visualizacion;
                    
    });
            }
</script>
<script src="<?php base_url() ?>javascript/viewImage.js"></script>
          <script>
            function guardar(){
              var id = $("#idBarberia").val();
              var url = "http://api.kikosbarbershop.online/public/";
              if(id == 0){
                url += "barberia";
              }else{
                url += "barberia/update/" + id;
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
            window.location.reload()
          })
          .fail(function(){
            alert("Sucedio un error, verifique si lleno todos los campos solicitados");
          });
          return false;
            }

            
            function eliminar(id){
              $.ajax({
                url:"http://api.kikosbarbershop.online/public/barberia/"  + id,
                data:{},
                type: "DELETE",
                dataType: "json",
                headers:{
                  token: localStorage.getItem("token")
                }
              }).done(function(data, textStatus, jqXHR){
                alert(data.result);
                window.location.reload()
              });
            }
          </script>
