<div id="layoutSidenav_content">
    <main>
         <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
                
            <form method ="POST" action="<?php echo base_url(); ?>/barbero/actualizar" autocomplete = "off">

            <input type="hidden" value="<?php echo $datos['id']; ?>" name="id" />

                <div class="form-group">
                    <div class ="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                             <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre']; ?>" autofocus require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Apellidos</label>
                             <input class="form-control" id="apellidos" name="apellidos" type="text" value="<?php echo $datos['apellidos']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Apodo</label>
                             <input class="form-control" id="apodo" name="apodo" type="text" value="<?php echo $datos['apodo']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Correo</label>
                             <input class="form-control" id="correo" name="correo" type="text" value="<?php echo $datos['correo']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Telefono</label>
                             <input class="form-control" id="telefono" name="telefono" type="text"value="<?php echo $datos['telefono']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Id BARBERIA</label>
                             <input class="form-control" id="idBarberia" name="idBarberia" type="text" value="<?php echo $datos['idBarberia']; ?>" require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>Password</label>
                             <input class="form-control" id="password" name="password" type="password"value="<?php echo $datos['password']; ?>" require />
                         </div>
                    </div>
                </div>
                <hr>
                <div>
                </div>

                    <a href="<?php echo base_url(); ?>/cliente" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                
            </form>
         </div>
    </main>
                