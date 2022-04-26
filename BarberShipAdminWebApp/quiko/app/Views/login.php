<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BarberShop</title>
        <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
        <script src="<?php echo base_url(); ?>/js/all.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar sesion</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo base_url(); ?>/Administrador/valida">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="Administrador" type="email" placeholder="Ingresa tu correo electronico" />
                                                <label for="Administrador">Correo Electronico</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" type="password" placeholder="Contraseña" />
                                                <label for="password">Contraseña</label>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div>

                                            <?php if (isset($validation)) { ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $validation->listErrors (); ?>
                                                </div>
                                            <?php } ?>
                                            
                                            <?php if (isset($error)) { ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $error; ?>
                                                </div>
                                            <?php } ?>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Kiko's BarberShop <?php echo date('Y')?></div>
                            <div>
                            <a href="https://www.facebook.com/kikosbarbershopp" target="_blank" >Facebook Kiko's BarberShop</a>
                                &middot;
                                <a href="https://twitter.com/kikosbarbershop?lang=es" target="_blank" >Twitter Kiko's BarberShop</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>/js/datatables-simple-demo.js"></script>
        <script src="<?php echo base_url(); ?>/js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/demo/datatables-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
</html>
