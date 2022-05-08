<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="<?php base_url() ?>Cita/styles/estilos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@700&family=Roboto+Condensed:wght@300&family=Roboto:wght@900&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Citas</title>
</head>

<!--<img src="img/fondoKikos.png" class="pattern_background">-->
<nav class="navigation_bar">
  <img src="<?php base_url() ?>Cita/img/logoKikoNav.svg" class="logo_menu" width="150px" height="60px">
  <ul class="nv_list">
    <li><a href="<?php base_url() ?>Inicio">Inicio</a></li>
    <li><a href="<?php base_url() ?>Citas">Citas</a></li>
    <li><a href="<?php base_url() ?>Cortes">Cortes</a></li>
    <li><a href="">Más Información</a></li>
    <li><a>⚙</a>
      <ul>
        <li id="nav-desplegable"><a href="<?php base_url() ?>Cliente">Editar usuario</a></li>
        <li id="nav-desplegable"><a href="#" onclick="getOut()">Cerrar sesión</a></li>
      </ul>
    </li>
  </ul>

  <div class="bars__menu">
    <span class="line1__bars-menu"></span>
    <span class="line2__bars-menu"></span>
    <span class="line3__bars-menu"></span>
  </div>
</nav>

<div class="stripe">
  <div class="stripe_inner">
  </div>
</div>

<body>

  <h1> Tus citas </h1>

  <div class="table-position">
    <button class="button-agendar-cita">Agendar cita</button>
    <table cellspacing="0" border="0" id="tabla-citas">
      <thead class="tbl-header">

        <tr>
          <th> Barbería </th>
          <th> Barbero </th>
          <th> Corte </th>
          <th> Fecha</th>
          <th> Estado </th>
          <th> Acciones </th>
        </tr>
      </thead>
      <tbody class="tbl-content">
        <tr class="btn-ver-cita">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="control-btns">
            <button class="btn-ver-cita" onclick="mostrarModal()">
              <img src="<?php base_url() ?>Cita/img/ojo.png" width="30px" height=25px">
              <p> Ver cita </p>
            </button>
            <button class="btn-editar-corte" onclick="mostrarModal()">
              <img src="<?php base_url() ?>Cita/img/CorteEditar.png" width="30px" height=25px">
              <p> Editar corte </p>
            </button>
            <button class="btn-cancelar" onclick="cancelar(${r.id})">
              <img src="<?php base_url() ?>Cita/img/eliminar.png" width="30px" height="25px">
              <p> Cancelar cita </p>
            </button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>


  <div class="container__menu">
    <ul class="nv_list_mobile">
      <li><a href="../MainCliente/Main.html">Inicio</a></li>
      <li><a href="../Corte/index.html">Cortes</a></li>
      <li><a href="../InformacionBarberia/index.html"">Más Información</a></li>
      </ul>
    </div>

<!-- Modal para agregar citas-->
  <div class="modal-bg">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&hyphen;</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Agregar nueva cita</h4>
        </div>
        <div id="form_cita">
          <div class="modal-body">
            <div class="form-group-barberia">
              <img src="<?php base_url() ?>Cita/img/BarberiaSelect.png" width="30px" height="30px">
              <select placeholder="Barberia" name="barberia" id="idBarberia" class="form-control">
                <option class="placeholder-select" value="" disabled selected hidden>Selecciona una barbería
                </option>
                <option value="idBarbería">Selecciona una barbería</option>
              </select>
            </div>

            <div class="form-group-barbero">
              <img src="<?php base_url() ?>Cita/img/BarberoSelect.png" width="30px" height="30px">
              <select placeholder="Barbero" name="barbero" id="idBarbero" class="form-control">
                <option class="placeholder-select" value="" hidden>Selecciona
                  un barbero</option>
                <option value="idBarbero">Selecciona un barbero</option>
              </select>
            </div>

            <div class="form-group-corte">
              <img src="<?php base_url() ?>Cita/img/CorteSelect.png" width="30px" height="30px">
              <select placeholder="Corte" name="corte" id="idCorte" class="form-control">
                <option class="placeholder-select" value="" disabled selected hidden>Selecciona una corte</option>
                <option value="idCorte">Selecciona un corte</option>
              </select>
            </div>

            <div class="form-group-fecha">
              <label>Fechas disponibles:</label><br>
              <input type="date" name="fecha" id="fecha">
            </div>

            <div class="form-group-hora">
              <label>Hora</label><br>
              <input type="time" name="hora" id="hora">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="button-close modal-close" data-dismiss="modal">Cerrar</button>
            <button id="guardar" class="button-accept">Agendar cita</button>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal para modificar corte de la cita
  <div class="modal-bg">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&hyphen;</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Editar Corte-Cita</h4>
        </div>
        <div id="form_cita">
          <div class="modal-body">
            <div class="form-group-barberia">
              <img src="<?php base_url() ?>Cita/img/BarberiaSelect.png" width="30px" height="30px">
              <select placeholder="Barberia" name="barberia" id="idBarberia" class="form-control" disabled>
                <option class="placeholder-select" value="" disabled selected hidden>Selecciona una barbería
                </option>
                <option value="idBarbería">Selecciona una barbería</option>
              </select>
            </div>

            <div class="form-group-barbero">
              <img src="<?php base_url() ?>Cita/img/BarberoSelect.png" width="30px" height="30px">
              <select placeholder="Barbero" name="barbero" id="idBarbero" class="form-control" disabled>
                <option class="placeholder-select" value="" hidden>Selecciona
                  un barbero</option>
                <option value="idBarbero">Selecciona un barbero</option>
              </select>
            </div>

            <div class="form-group-corte">
              <img src="<?php base_url() ?>Cita/img/CorteSelect.png" width="30px" height="30px">
              <select placeholder="Corte" name="corte" id="idCorte" class="form-control" disabled>
                <option class="placeholder-select" value="" disabled selected hidden>Selecciona una corte</option>
                <option value="idCorte">Selecciona un corte</option>
              </select>
            </div>

            <div class="form-group-fecha">
              <label>Fechas disponibles:</label><br>
              <input type="date" name="fecha" id="fecha" disabled>
            </div>

            <div class="form-group-hora">
              <label>Hora</label><br>
              <input type="time" name="hora" id="hora" disabled>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="button-close modal-close" data-dismiss="modal">Cerrar</button>
            <button id="guardar" class="button-accept">Guardar</button>
          </div>

          <div id="respuesta"></div>
        </div>
      </div>
    </div>
  </div>
  -->

<!--Modal para ver cita-->
  <div class="modal-bg_cita">
    <div class="modal-dialog_cita">
      <div class="modal-content_cita">
        <div class="modal-title_cita">
          <button type="button" class="modal-close_cita" onclick="cerrarModal()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&hyphen;</span>
          </button>
          <h1>Hola, soy un modal</h1>
        </div>
        <div class="modal-body_cita">
          <div class="left-column">
            <div class="body-barberia">
              <label>Barbería</label>
              <input class="barberia-name" name="barberia-mostrar"></input>
            </div>
            <div class="body-barbero">
              <label>Barbero</label>
              <input class="barbero-name" name="barbero-mostrar"></input>
            </div>
          </div>
          <div class="body-corte">
            <label>Corte</label>
            <!--inserte imagen del corte aquí xd-->
            <input class="corte-name" name="corte-mostrar"></input>
          </div>
          <div class="right-column">
            <div class="body-fecha">
              <label>Fecha</label>
              <input class="fecha-label" name="fecha-mostrar"></input>
            </div>
            <div class="body-hora">
              <label>Hora</label>
              <input class="fecha-label" name="hora-mostrar"></input>
            </div>
            <div class="body-estado">
              <label>Estado</label>
              <input class="estado-label" name="estado-mostrar"></input>
            </div>
          </div>
          <div class="modal-close">
            <button class="modal-close_cita" onclick="cerrarModal()">Cerrar modal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!--Su funcion es obtener todas las citas del cliente-->
  <script>
    var url = "http://api.kikosbarbershop.online/public/cliente_cita/" + localStorage.getItem("id");

    $.ajax({
        type: "GET",
        url: url,
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) {

        var rows = " ";
        console.log("info citas tabla")
        console.log(data)

        if (!data) {
          rows = "<h2 style='color:red; text-align:center;'>No hay registros</h2>";
        } else {
          data.citas.forEach(r => {
            rows += `
                  <tr>
                        <td>${r.barberia.nombre}</td>
                        <td>${r.barbero.nombre} </td>
                        <td>${r.corte.nombre}</td>
                        <td>${r.fecha}</td>
                        <td>${r.estado}</td>
                        <td class="control-btns">
                          <button class="btn-ver-cita" onclick="mostrarCita(${r.id})">
                            <img src="<?php base_url() ?>Cita/img/ojo.png" width="30px" height=25px">
                            <p> Ver cita </p>
                          </button>
                          <button class="btn-editar-corte" onclick="mostrarModal(${r.id})">
                            <img src="<?php base_url() ?>Cita/img/CorteEditar.png" width="30px" height=25px">
                            <p> Editar corte </p>
                          </button>
                          <button class="btn-cancelar" onclick="cancelar(${r.id})">
                            <img src="<?php base_url() ?>Cita/img/eliminar.png" width="30px" height="25px">
                            <p> Cancelar cita </p>
                          </button>
                        </td>
                  </tr>
            `;
          });
        }

        $("#tabla-citas tbody").html(rows);

      });
  </script>

  <!-- Su funcion es obtener todas las barberías-->
  <script>
    var url = 'http://api.kikosbarbershop.online/public/barberia'
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        console.log("info select barberia")
        console.log(data)

        data.barberias.forEach(r => {
          $('#idBarberia').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
        });

      });
  </script>

  <!-- Su funcion es obtener todos los barberos-->
  <script>
    var url = 'http://api.kikosbarbershop.online/public/barbero'
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        console.log("info select barbero")
        console.log(data)

        data.barberos.forEach(r => {
          $('#idBarbero').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
        });

      });
  </script>

  <!-- Su funcion es obtener todos los cortes-->
  <script>
    var url = 'http://api.kikosbarbershop.online/public/corte'
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        console.log("info select corte")
        console.log(data)

        data.cortes.forEach(r => {
          $('#idCorte').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
        });

      });
  </script>

<!-- Su funcion es obtener los datos de una cita y mostrarlos en un modal-->
<script>
    var url = 'http://api.kikosbarbershop.online/public/cliente_cita' + localStorage.getItem("id")
    function obtenerDatos() {
        $.ajax({
                url: url,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
            .done(function(data, textStatus, jqXHR) {
                var cita = data.cita;

                console.log(data.cita);

                $("select[name='barberia']").val(cita.barberia.nombre);
                $("select[name='barbero']").val(cita.barbero.nombre);
                $("select[name='corte']").val(cita.corte.nombre);
                $("select[name='fecha']").val(cita.fecha);
                $("select[name='hora']").val(cita.hora);
            });
    }

    llenarForm();
  </script>

  <!-- Su funcion es obtener los datos de una cita y mostrarlos en un modal-->
<script>

    var url = 'http://api.kikosbarbershop.online/public/cita/';
    function llenarModal(id) {
        $.ajax({
                url: url + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
            .done(function(data, textStatus, jqXHR) {
                var cita = data.cita;

                console.log(data.cita);

                $("input[name='barberia-mostrar']").val(cita.barberia.nombre);
                $("input[name='barbero-mostrar']").val(cita.barbero.nombre);
                $("input[name='corte-mostrar']").val(cita.corte.nombre);
                $("input[name='fecha-mostrar']").val(cita.fecha);
                $("input[name='hora-mostrar']").val(cita.hora);
                $("input[name='estado-mostrar']").val(cita.estado);

            });

    }

  </script>

  <!-- Este script sirve para evniar los datos del formulario y guardarlos
      en la base de datos del servidor-->
  <script>
    var url = 'http://api.kikosbarbershop.online/public/cita';
    $('#guardar').click(function() {

      $.ajax({
          url: url,
          type: 'POST',
          data: {
            "idCliente": localStorage.getItem("id"),
            "idBarbero": $("#idBarbero").val(),
            "idCorte": $("#idCorte").val(),
            "idBarberia": $("#idBarberia").val(),
            "fecha": $("#fecha").val(),
            "hora": $("#hora").val(),
            "estado": "Pendiente"
          },
          dataType: "json",
          headers: {
            token: localStorage.getItem("token")
          }
        })
        .done(function(data, res) {
          console.log("La cita ha sido guardada con exito");
          console.log(data);

        })
        .fail(function() {
          console.log("Error", "Ocurrio un problema al guardar la cita")
        })
    });
  </script>

  <!-- Su funcion es cambiar el estado de la cita, cancelar la cita-->
  <script>
    var url = 'http://api.kikosbarbershop.online/public/cita/update/';
    
    function cancelar(id) {
      
      $.ajax({
          url: url + id,
          type: 'POST',
          data: {
            "estado": "Cancelada"
          },
          dataType: "json",
          headers: {
            token: localStorage.getItem("token")
          }
        })
        .done(function(data, res) {
          console.log("La cita ha sido cancelada con exito");
          console.log(data);
          location.href="<?php base_url() ?>Citas";

        })
        .fail(function() {
          console.log("Error", "Ocurrio un problema al cancelar la cita")
        })

    }

  </script>


  <!-- Su funcion es cerrar la sesion del usuario-->
  <script>
    //hay session ?
    if(!localStorage.getItem("user")){
      location.href="<?php base_url() ?>/Log-In";
    }

    function getOut(){
        localStorage.removeItem("token");
        localStorage.removeItem("tipo");
        localStorage.removeItem("user");
        location.href = "<?php base_url() ?>/Log-In";
      }
  </script>

  <!-- Su funcion es abrir y cerrar el modal de ver cita -->
  <script>
    function mostrarCita(id){
    var btnModalCita = document.querySelectorAll('.btn-ver-cita');
    var modalBgCita = document.querySelector('.modal-bg_cita');
    modalBgCita.classList.add('modal-bg_cita_active');

    var url = 'http://api.kikosbarbershop.online/public/cita/';

    $.ajax({
                url: url + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
            .done(function(data, textStatus, jqXHR) {
                var cita = data.cita;

                console.log(data.cita);

                $("label[name='barberia']").val(cita.barberia.nombre);
                $("label[name='barbero']").val(cita.barbero.nombre);
                $("label[name='corte']").val(cita.corte.nombre);
                $("label[name='fecha']").val(cita.fecha);
                $("label[name='hora']").val(cita.hora);
                $("label[name='estado']").val(cita.estado);
            });
    }

    function cerrarModal() {
      var modalBgCita = document.querySelector('.modal-bg_cita');
      var modalCloseCita = document.querySelector('.modal-close_cita');
      modalBgCita.classList.remove('modal-bg_cita_active');
    }
  </script>

  <script src="<?php base_url() ?>Cita/js/cita.js"></script>
</body>

</html>