<main>
  <div class="container-fluid px-4">
    <h3 class="mt-4">Tabla de datos</h3>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Tables</li>
    </ol>

    <div>
      <p>
        <button type="button" class="btn btn-primary">Agreagr</button>
      </p>
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
        {
          "targets": -1,
          "data": null,
          "defaultContent": '<button class="btn btn-warning" name="editar">  <i class="fas fa-pen"></i>  </button> <button class="btn btn-danger" name="cancelar">  <i class="fas fa-trash"></i>  </button>'
        }
      ]
    });
    $('#table tbody').on('click', "button[name='cancelar']", function() {
      var data = table.row($(this).parents('tr')).data();
      alert("estas eliminando el: " + data.id + " => " + data.nombre);
    });
    $('#table tbody').on('click', "button[name='editar']", function() {
      var data = table.row($(this).parents('tr')).data();
      alert("estas editando el: " + data.id + " => " + data.nombre);
    });
  });
</script>