<div id="layoutSidenav_content">
    <main>
         <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
                
            <form method ="POST" action="<?php echo base_url(); ?>/corte/actualizar" autocomplete = "off">

            <input type="hidden" value="<?php echo $datos['id']; ?>" name="id" />

                <div class="form-group">
                    <div class ="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                             <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre']; ?>" autofocus require />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>visualización</label>
                             <input class="form-control" id="visualización" name="visualización" type="text" value="<?php echo $datos['visualización']; ?>" require />
                         </div>

                    </div>
                </div>
                <hr>
                <div>
                </div>

                    <a href="<?php echo base_url(); ?>/corte" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                
            </form>
         </div>
    </main>
                