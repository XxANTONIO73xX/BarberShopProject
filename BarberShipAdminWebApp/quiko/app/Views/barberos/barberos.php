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
                                    <div class="drop-area">
                                        <label>Arrastra y suelta una imagen</label>
                                        <span>O</span>
                                        <button type="button">Selecciona tu imagen</button>
                                        <input type="file" name="featured_image" id="input-file" hidden/>
                                    </div>
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
                    alert("estas eliminando el: " + data.id +" => " + data.nombre);
                  });

                  $('#table tbody').on( 'click', "button[name='editar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $("#idBarbero").val(data.id)
                    var id = $("#idBarbero").val();
                    obtenerData(id);
                    llenarCbxBarberias();
                  });

                  $('#table tbody').on( 'click', "button[name='imagen']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    window.open(data.visualizacion);
                  });
                });
          </script>
          <script>
            function llenarCbxBarberias(){
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
            }
            function reset(){
              $("#idBarbero").val(0);
              $("#nombre").val("");
              $("#apellido").val("");
              $("#apodo").val("");
              $("#telefono").val("");
              const preview = document.querySelector(".preview");
              const img = preview.querySelector('img');
              img.src = "<?php base_url() ?>assets/img/ImageNotFound.png";
              llenarCbxBarberias();
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
                    $("select[name='barberia_select'] option[value='"+data.barbero.barberia.id+"']").attr("selected","selected" );
    });
            }
          </script> 
          <script src="<?php base_url() ?>javascript/barbero/barbero.js"></script>
          <script>
            function guardar(){
              console.log(fileCurrent);
              var formData = new FormData();
              formData.append("featured_image", fileCurrent);
              formData.append("nombre", $("#nombre").val());
              formData.append("apodo", $("#apodo").val());
              formData.append("apellidos", $("#apellido").val());
              formData.append("telefono", $("#telefono").val());
              formData.append("idBarberia", $("#barberia").val());
              var id = $("#idBarbero").val();
              var url = "http://api.kikosbarbershop.online/public/";
              if(id == 0){
                url += "barbero";
                console.log(url)
              }else{
                url += "barbero/update/" + id;
                console.log(url)
              }
              console.log("si estas acá")
              // new FormData(document.getElementById("formulario") 
              // console.log( $( "#formulario" ).serialize())
              dataFormulario =  new FormData(document.getElementById("formulario"));
              console.log(dataFormulario);
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
            console.log(data);
            console.log("si jalo");
          });
          return false;
            }
          </script>
<!-- Modal
<div class="modal fade" id="confirma" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarLabel">Eliminar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Desea eliminar este registro
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancalar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div> -->