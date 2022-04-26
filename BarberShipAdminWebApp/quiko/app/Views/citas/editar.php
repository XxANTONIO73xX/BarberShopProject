<div id="layoutSidenav_content">
    <main>
         <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
                
            <form method ="POST" action="<?php echo base_url(); ?>/cita/actualizar" autocomplete = "off">

            <input type="hidden" value="<?php echo $datos['id']; ?>" name="id" />

                <div class="form-group">
                    <div class ="row">
                        <div class="col-12 col-sm-6">
                            <label>Fecha</label>
                             <input class="form-control" id="fecha" name="fecha" type="text" value="<?php echo $datos['fecha']; ?>" autofocus require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Hora</label>
                             <input class="form-control" id="hora" name="hora" type="text" value="<?php echo $datos['hora']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>estado</label>
                             <input class="form-control" id="estado" name="estado" type="text" value="<?php echo $datos['estado']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>idCliente</label>
                             <input class="form-control" id="idCliente" name="idCliente" type="text"value="<?php echo $datos['idCliente']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>idCorte</label>
                             <input class="form-control" id="idCorte" name="idCorte" type="text"value="<?php echo $datos['idCorte']; ?>" require />
                         </div>
                         <div class="col-12 col-sm-6">
                            <label>idBarbero</label>
                             <input class="form-control" id="idBarbero" name="idBarbero" type="text"value="<?php echo $datos['idBarbero']; ?>" require />
                         </div>
                         <div class="col-12 col-sm-6">
                            <label>idBarberia</label>
                             <input class="form-control" id="idBarberia" name="idBarberia" type="text"value="<?php echo $datos['idBarberia']; ?>" require />
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
                