<div id="layoutSidenav_content">
    <main>
         <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
                <?php \Config\Services::validation()->listErrors(); ?>
            <form method ="POST" action="<?php echo base_url(); ?>/administrador/insertar" autocomplete = "off">
            <?php csrf_field(); ?>    
            <div class="form-group">
                    <div class ="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                             <input class="form-control" id="nombre" name="nombre" type="text" autofocus required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Apellidos</label>
                             <input class="form-control" id="apellidos" name="apellidos" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Correo</label>
                             <input class="form-control" id="correo" name="correo" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Telefono</label>
                             <input class="form-control" id="telefono" name="telefono" type="text" required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Password</label>
                             <input class="form-control" id="password" name="password" type="password" required />
                         </div>
                    </div>
                </div>
                <hr>
                <div>
                </div>

                    <a href="<?php echo base_url(); ?>/administrador" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                
            </form>
         </div>
    </main>
                