<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h3 class="mt-4"><?php echo $titulo; ?></h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>

                        <div>
                            <p> 
                                <a href= "<?php echo base_url(); ?>/cliente/nuevo" class="btn btn-info">Agregar</a>
                            </p>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabla de clientes
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach($datos as $dato) { ?>
                                        <tr>    
                                             <td><?php echo $dato['id']; ?></td>
                                             <td><?php echo $dato['nombre']; ?></td>
                                             <td><?php echo $dato['apellidos']; ?></td>
                                             <td><?php echo $dato['correo']; ?></td>
                                             <td><?php echo $dato['telefono']; ?></td>

                                             <td><a href= "<?php echo base_url(). '/cliente/editar/'. $dato['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></td>

                                             <td><a href= "#" data-href="<?php echo base_url(). '/cliente/eliminar/'. $dato['id']; ?>" data-bs-toggle="modal" data-bs-target="#confirma" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a></td>
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
<!-- Modal -->
<div class="modal fade" id="confirma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      ¿Esta seguro de eliminar este registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary btn-ok">Aceptar</a>
      </div>
    </div>
  </div>
</div>