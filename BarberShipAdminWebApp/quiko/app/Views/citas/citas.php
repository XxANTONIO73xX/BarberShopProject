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
                              <h4 class="modal-title w-100 font-weight-bold">Añadir una nueva cita</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form id="formulario" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <input type="hidden" id="idCita" value="0">
                                  </div>
                                  <div class="form-group">
                                    <label for="cliente" class="col-form-label">Cliente:</label>
                                    <select name="idCliente" id="cliente" class="form-control">
                                      <option value="0">Seleccionar Cliente</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="barbero" class="col-form-label">Barbero:</label>
                                    <select name="idBarbero" id="barbero" class="form-control">
                                      <option value="0">Seleccionar Barbero</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="corte" class="col-form-label">Corte:</label>
                                    <select name="idCorte" id="corte" class="form-control">
                                      <option value="0">Seleccionar Corte</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="barberia" class="col-form-label">Barberia:</label>
                                    <select name="idBarberia" id="barberia" class="form-control">
                                      <option value="0">Seleccionar Barberia</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="fecha" class="col-form-label">Fecha:</label>
                                    <input type="date" min="<?php echo date('yyyy-mm-dd') ?>" name="fecha" class="form-control" id="fecha">
                                  </div>
                                  <div class="form-group">
                                    <label for="hora" class="col-form-label">Horario:</label>
                                    <input type="time" min="8:00" max="20:00" name="hora" class="form-control" id="hora">
                                  </div>
                                  <div class="form-group">
                                    <label for="estado" class="col-form-label">Estado:</label>
                                    <input type="text" name="estado" class="form-control" id="estado">
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
                                Tabla de Citas
                            </div>
                            <div class="card-body">
                                <table id="table" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Estado</th>
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
                        "url": 'http://api.kikosbarbershop.online/public/cita',
                        "dataSrc": "citas",
                        "type": 'GET',
                        "beforeSend": function(xhr) {
                        xhr.setRequestHeader('token', localStorage.getItem("token"));
                        }
                    },
                    "columns":[
                        {"data": 'id'},
                        {"data": 'fecha'},
                        {"data": 'hora'},
                        {"data":'estado'},
                        {"targets": -1, "data": null, "defaultContent":'<button class="btn btn-warning" name="editar" data-toggle="modal" data-target="#modalAgregar">  <i class="fas fa-pen"></i>  </button> <button class="btn btn-danger" name="cancelar">  <i class="fas fa-trash"></i>  </button>'}
                    ]
                    });
                    $('#table tbody').on( 'click', "button[name='cancelar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    eliminar(data.id);
                    });

                    $('#table tbody').on( 'click', "button[name='editar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $("#idCita").val(data.id)
                    var id = $("#idCita").val();
                    obtenerData(id);
                    });
                })
          </script>
          <script>
              $.ajax({
                url:"http://api.kikosbarbershop.online/public/cliente",
                data:{},
                type: "GET",
                dataType: "json",
                headers:{
                  token: localStorage.getItem("token")
                }
              }).done(function(data, textStatus, jqXHR){
                var optionsSelect = '<option value="0">Seleccionar Cliente</option>';

                data.clientes.forEach(r => {
                  optionsSelect+=`<option value="${r.id}">${r.correo}</option> `;
                });

                $("#cliente").html(optionsSelect);
              });

              $.ajax({
                url:"http://api.kikosbarbershop.online/public/barbero",
                data:{},
                type: "GET",
                dataType: "json",
                headers:{
                  token: localStorage.getItem("token")
                }
              }).done(function(data, textStatus, jqXHR){
                var optionsSelect = '<option value="0">Seleccionar Barbero</option>';

                data.barberos.forEach(r => {
                  optionsSelect+=`<option value="${r.id}">${r.nombre}</option> `;
                });

                $("#barbero").html(optionsSelect);
              });

              $.ajax({
                url:"http://api.kikosbarbershop.online/public/corte",
                data:{},
                type: "GET",
                dataType: "json",
                headers:{
                  token: localStorage.getItem("token")
                }
              }).done(function(data, textStatus, jqXHR){
                var optionsSelect = '<option value="0">Seleccionar Corte</option>';

                data.cortes.forEach(r => {
                  optionsSelect+=`<option value="${r.id}">${r.nombre}</option> `;
                });

                $("#corte").html(optionsSelect);
              });

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
              $("#idCita").val(0);
              $('select[name="idCliente"] option[selected="selected"]').removeAttr("selected");
              $('select[name="idBarbero"] option[selected="selected"]').removeAttr("selected");
              $('select[name="idCorte"] option[selected="selected"]').removeAttr("selected");
              $('select[name="idBarberia"] option[selected="selected"]').removeAttr("selected");
              $("#fecha").val("");
              $("#hora").val("");
              $("#estado").val("");
            }

            function obtenerData(id){
              $.ajax({   //iniciar ajax para crar token   
                url: 'http://api.kikosbarbershop.online/public/cita/' + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
                .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data
                    console.log("info tabla")
                    console.log(data.cita)
                    $("select[name='idCliente'] option[value='"+data.cita.cliente.id+"']").attr("selected","selected" );
                    $("select[name='idBarbero'] option[value='"+data.cita.barbero.id+"']").attr("selected","selected" );
                    $("select[name='idCorte'] option[value='"+data.cita.corte.id+"']").attr("selected","selected" );
                    $("select[name='idBarberia'] option[value='"+data.cita.barberia.id+"']").attr("selected","selected" );
                    $("#fecha").val(data.cita.fecha);
                    $("#hora").val(data.cita.hora);
                    $("#estado").val(data.cita.estado);
                    
    });
            }
            </script> 
            <script>
              function guardar(){
              var id = $("#idCita").val();
              var url = "http://api.kikosbarbershop.online/public/";
              if(id == 0){
                url += "cita";
              }else{
                url += "cita/update/" + id;
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
                url:"http://api.kikosbarbershop.online/public/cita/"  + id,
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

