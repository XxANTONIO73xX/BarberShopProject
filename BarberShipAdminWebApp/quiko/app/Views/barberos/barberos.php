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
                              <h4 class="modal-title w-100 font-weight-bold">Añadir un Barbero</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form id="formulario" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <input type="hidden" id="idBarbero" value="0">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre">
                                  </div>
                                  <div class="form-group">
                                    <label for="apellido" class="col-form-label">Apellido:</label>
                                    <input type="text" name="apellidos" class="form-control" id="apellido">
                                  </div>
                                  <div class="form-group">
                                    <label for="apodo" class="col-form-label">Apodo:</label>
                                    <input type="text" name= "apodo" class="form-control" id="apodo">
                                  </div>
                                  <div class="form-group">
                                    <label for="barberia" class="col-form-label">Barberia:</label>
                                    <select name="idBarberia" id="barberia" class="form-control">
                                      <option value="0">Seleccionar Barberia</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="telefono" class="col-form-label">Telefono:</label>
                                    <input type="number" name="telefono" class="form-control" id="telefono">
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
                                Tabla de Barberos
                            </div>
                            <div class="card-body">
                                <table id="table" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Apodo</th>
                                            <th>Barberia</th>
                                            <th>telefono</th>
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
                  var table =$('#table').DataTable({
                    "ajax": {
                        "url": 'http://api.kikosbarbershop.online/public/barbero',
                        "dataSrc": "barberos",
                        "type": 'GET',
                        "beforeSend": function(xhr) {
                        xhr.setRequestHeader('token', localStorage.getItem("token"));
                        }
                    },
                    "columns":[
                        {"data": 'id'},
                        {"data": 'nombre'},
                        {"data": 'apellidos'},
                        {"data":'apodo'},
                        {"data": 'barberia.nombre'},
                        {"data":'telefono'},
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
                    $("#idBarbero").val(data.id)
                    var id = $("#idBarbero").val();
                    obtenerData(id);
                  });

                  $('#table tbody').on( 'click', "button[name='imagen']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    window.open(data.visualizacion);
                  });
                });
          </script>
          <script>
              $.ajax({
                url:"http://api.kikosbarbershop.online/public/barberia",
                data:{},
                type: "GET",
                dataType: "json",
                headers:{
                  token: localStorage.getItem("token")
                }
              }).done(function(data, textStatus, jqXHR){
                var optionsSelect = '<option value="0">Seleccionar Barberia</option>';

                data.barberias.forEach(r => {
                  optionsSelect+=`<option value="${r.id}">${r.nombre}</option> `;
                });

                $("#barberia").html(optionsSelect);
              });
            function reset(){
              $("#idBarbero").val(0);
              $("#nombre").val("");
              $("#apellido").val("");
              $("#apodo").val("");
              $("#telefono").val("");
              $('select[name="idBarberia"] option[selected="selected"]').removeAttr("selected");
              const preview = document.querySelector(".preview");
              const img = preview.querySelector('img');
              img.src = "<?php base_url() ?>assets/img/ImageNotFound.png";
            }

            function obtenerData(id){
              $.ajax({   //iniciar ajax para crar token   
                url: 'http://api.kikosbarbershop.online/public/barbero/' + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
                .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data
                    console.log("info tabla")
                    console.log(data.barbero)
                    $("#nombre").val(data.barbero.nombre);
                    $("#apellido").val(data.barbero.apellidos);
                    $("#apodo").val(data.barbero.apodo);
                    $("#telefono").val(data.barbero.telefono);
                    const preview = document.querySelector(".preview");
                    const img = preview.querySelector('img');
                    img.src = data.barbero.visualizacion;
                    console.log(data.barbero.barberia.id);
                    $("select[name='idBarberia'] option[value='"+data.barbero.barberia.id+"']").attr("selected","selected" );
    });
            }
          </script> 
          <script src="<?php base_url() ?>javascript/viewImage.js"></script>
          <script>
            function guardar(){
              var id = $("#idBarbero").val();
              var url = "http://api.kikosbarbershop.online/public/";
              if(id == 0){
                url += "barbero";
              }else{
                url += "barbero/update/" + id;
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
                url:"http://api.kikosbarbershop.online/public/barbero/"  + id,
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
