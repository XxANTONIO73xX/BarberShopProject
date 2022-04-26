<div id="layoutSidenav_content">
    <main>
         <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
                <?php \Config\Services::validation()->listErrors(); ?>
            <form method ="POST" action="<?php echo base_url(); ?>/corte/insertar" autocomplete = "off">
            <?php csrf_field(); ?>    
            <div class="form-group">
                    <div class ="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                             <input class="form-control" id="nombre" name="nombre" type="text" autofocus required />
                         </div>

                         <div class="col-12 col-sm-6">
                            <label>visualización</label>
                             <input class="form-control" id="visualización" name="visualización" type="text" required />
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
                