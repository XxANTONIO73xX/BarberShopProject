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
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="control-btns">
            <button class="btn-ver-cita">
              <img src="<?php base_url() ?>Cita/img/ojo.png" width="30px" height="30px">
            </button>
            <button class="btn-cancelar">
              <img src="<?php base_url() ?>Cita/img/eliminar.png" width="30px" height="30px">
            </button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>

  <!--
  <div class="accordion">

    

    <div class="accordion-item">
      <div class="accordion-item-header">
        <div class="accordion-cita-datos">
          <div class="accordion-cita-datos-header" id="idBarberia">Barberia:
          </div>
          <div class="accordion-cita-datos-header" id="idBarbero">Barbero:
          </div>
          <div class="accordion-cita-datos-header" id="idCorte">Corte:
          </div>
          <div class="accordion-cita-datos-header" id="fecha">Fecha:
          </div>
          <div class="accordion-cita-datos-header" id="estado">Estado:
          </div>
        </div>
      </div>
      <div class="accordion-item-body">
        <div class="accordion-item-body-content">
          <div class="accordion-barbero-box">
            <label>Tu barbero:</label>
            <div class="accordion-cita-datos-body-barbero" id="idBarbero_box">* FOTO BARBERO *</div>
          </div>
          <div class="accordion-corte-box">
            <label>Corte:</label>
            <div class="accordion-cita-datos-body-corte" id="idCorte_box">* FOTO CORTE *</div>
          </div>
          <div class="accordion-cita-datos-body-datos__minimos">
            <div class="accordion-fecha-box">
              <label>Fecha de la cita:</label>
              <div class="accordion-cita-datos-body-fecha" id="fecha_box"></div>
            </div>
            <div class="accordion-hora-box">
              <label>Hora de la cita:</label>
              <div class="accordion-cita-datos-body-hora" id="hora_box"></div>
            </div>


            <div class="accordion-estado-box">
              <label>Estado de la cita:</label>
              <label id="status-label" class="accordion-cita-datos-body-estado"> </label>
            </div>

          </div>
          <button id="button-cancelar" class="button-cancelar" onclick="statusCita()">Cancelar cita</button>
        </div>
      </div>
    </div>
  </div>
-->

  <div class="container__menu">
    <ul class="nv_list_mobile">
      <li><a href="../MainCliente/Main.html">Inicio</a></li>
      <li><a href="../Corte/index.html">Cortes</a></li>
      <li><a href="../InformacionBarberia/index.html"">Más Información</a></li>
      </ul>
    </div>

    <div class=" modal-cita-bg">

  </div>



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

          <div id="respuesta"></div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                          <button class="btn-ver-cita">
                            <img src="<?php base_url() ?>Cita/img/ojo.png" width="30px" height="30px">
                          </button>
                          <button class="btn-cancelar">
                            <img src="<?php base_url() ?>Cita/img/eliminar.png" width="30px" height="30px">
                          </button>
                        </td>
                  </tr>
            `;
          });
        }

        $("#tabla-citas tbody").html(rows);

      });
  </script>

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
          /**
           * !Esto para regresar al index de citas y se recargue, en el dato caso
           * !de que marque error el metodo se quita la linea de abajo
           **/
          //location.href = "/Cita/";
        })
        .fail(function() {
          console.log("Error", "Ocurrio un problema al guardar la cita")
        })
    });
  </script>
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

  <script src="<?php base_url() ?>Cita/js/cita.js"></script>
</body>

</html>