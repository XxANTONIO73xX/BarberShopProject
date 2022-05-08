<main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4"><?php echo $titulo; ?></h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>

                        <div>
                            <p> 
                                <a href= "<?php echo base_url(); ?>/cita/nuevo" class="btn btn-info">Agregar</a>
                            </p>
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
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
          <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
          <script>
                $(document).ready(function() {
                    $('#table').DataTable({
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
                        {"data":'estado'}
  

                    ]
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