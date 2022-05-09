                <main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4"><?php echo $titulo; ?></h3>
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
                                <form>
                                  <div class="form-group">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre">
                                  </div>
                                  <div class="form-group">
                                    <label for="apellido" class="col-form-label">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido">
                                  </div>
                                  <div class="form-group">
                                    <label for="apodo" class="col-form-label">Apodo:</label>
                                    <input type="text" class="form-control" id="apodo">
                                  </div>
                                  <div class="form-group">
                                    <label for="barberia" class="col-form-label">Barberia:</label>
                                    <input type="text" class="form-control" id="barberia">
                                  </div>
                                  <div class="form-group">
                                    <label for="telefono" class="col-form-label">Telefono:</label>
                                    <input type="text" class="form-control" id="telefono">
                                  </div>
                                  <div class="form-group">
                                    <label for="imagen" class="col-form-label">Foto:</label>
                                    <input type="file" class="form-control" id="imagen">
                                  </div>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Agregar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div>
                          <a class="btn btn-info" data-toggle="modal" data-target="#modalAgregar">Agregar
                          </a>
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
                        {"targets": -1, "data": null, "defaultContent":'<button class="btn btn-warning" name="editar">  <i class="fas fa-pen"></i>  </button> <button class="btn btn-danger" name="cancelar">  <i class="fas fa-trash"></i>  </button> </button> <button class="btn btn-success" name="imagen">  <i class="fas fa-image"></i>  </button>'}
                    ]
                    });

                  $('#table tbody').on( 'click', "button[name='cancelar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    alert("estas eliminando el: " + data.id +" => " + data.nombre);
                  });

                  $('#table tbody').on( 'click', "button[name='editar']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    alert("estas editando el: " + data.id +" => " + data.nombre);
                  });

                  $('#table tbody').on( 'click', "button[name='imagen']", function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    window.open(data.visualizacion);
                  });
                });
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