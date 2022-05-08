<main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4"><?php echo $titulo; ?></h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>

                        <div>
                            <p> 
                                <a href= "<?php echo base_url(); ?>/barberia/nuevo" class="btn btn-info">Agregar</a>
                            </p>
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
                        {"targets": -1, "data": null, "defaultContent":'<button class="btn btn-warning" name="editar">  <i class="fas fa-pen"></i>  </button> <button class="btn btn-danger" name="cancelar">  <i class="fas fa-trash"></i>  </button>'}       
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

                })
          </script>
<!-- Modal
<div class="modal fade" id="confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
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