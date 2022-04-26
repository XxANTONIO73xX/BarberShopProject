<div id="layoutSidenav_content">
    <main>
         <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
                <?php \Config\Services::validation()->listErrors(); ?>
            <form method ="POST" action="<?php echo base_url(); ?>/cita/insertar" autocomplete = "off">
            <?php csrf_field(); ?>    
            <div class="form-group">
                    <div class ="row">
                        <div class="col-12 col-sm-6">
                            <label>Fecha</label>
                             <input class="form-control" id="fecha" name="fecha" type="text" autofocus required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Hora</label>
                             <input class="form-control" id="hora" name="hora" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Estado</label>
                             <input class="form-control" id="estado" name="estado" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>idCliente</label>
                             <input class="form-control" id="idCliente" name="idCliente" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>idcorte</label>
                             <input class="form-control" id="idCorte" name="idCorte" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>idBarbero</label>
                             <input class="form-control" id="idBarbero" name="idBarbero" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>idBarberia</label>
                             <input class="form-control" id="idBarberia" name="idBarberia" type="text" required />
                         </div>
                    </div>
                </div>
                <hr>
                <div>
                </div>

                    <a href="<?php echo base_url(); ?>/cita" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                
            </form>
         </div>
    </main>
                