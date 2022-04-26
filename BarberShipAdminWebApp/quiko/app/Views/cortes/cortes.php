<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4"><?php echo $titulo; ?></h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>

                        <div>
                            <p> 
                                <a href= "<?php echo base_url(); ?>/corte/nuevo" class="btn btn-info">Agregar</a>
                            </p>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabla de cortes
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>visualización</th>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach($datos as $dato) { ?>
                                        <tr>    
                                             <td><?php echo $dato['id']; ?></td>
                                             <td><?php echo $dato['nombre']; ?></td>
                                             <td><?php echo $dato['visualización']; ?></td>


                                             <td><a href= "<?php echo base_url(). '/corte/editar/'. $dato['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></td>

                                             <td><a href= "<?php echo base_url(). '/corte/eliminar/'. $dato['id']; ?>" data-toggle="modal" data-target="#confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a></td>
                                            <!-- Se elimino lo siguiente de la linea 45 para que funcione el eliminar sin modal, ya que no jala el visualizar modal
                                        #" data-href="
                                        -->
                                       </tr>
                                      <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
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