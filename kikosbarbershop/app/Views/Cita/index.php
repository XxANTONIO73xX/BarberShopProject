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
            <button class="btn-editar-corte" onclick="editarCorte(${r.id})">
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
              <input type="time" name="hora" id="hora" min="08:00" max="20:00" step="1800">
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

<!--Modal para ver cita-->
  <div class="modal-bg_cita">
    <div class="modal-dialog_cita">
      <div class="modal-content_cita">
        <div class="modal-title_cita">
          <button type="button" class="modal-close_cita" onclick="cerrarModal()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&hyphen;</span>
          </button>
        </div>
        <div class="modal-body_cita">
          <div class="left-column">
            <div class="body-barberia">
              <label>Barbería</label>
              <div class="barberia-div" name="barberia-mostrar" id="barberia-div">
                <img src="">
              </div>
            </div>
            <div class="body-barbero">
              <label>Barbero</label>
              <div class="barbero-div" name="barbero-mostrar" id="barbero-div"> <img src=""></div>
            </div>
          </div>
          <div class="body-corte">
            <label>Corte</label>
            <!--inserte imagen del corte aquí xd-->
            <div class="corte-div" name="corte-mostrar" id="corte-div"></div>
          </div>
          <div class="right-column">
            <div class="body-fecha">
              <label>Fecha</label>
              <div class="fecha-div" img src="" name="fecha-mostrar" id="fecha-div"></div>
            </div>
            <div class="body-hora">
              <label>Hora</label>
              <div class="fecha-div" name="hora-mostrar" id="hora-div"></div>
            </div>
            <div class="body-estado">
              <label>Estado</label>
              <div class="estado-div" name="estado-mostrar" id="estado-div"></div>
            </div>
          </div>
          <div class="modal-close">
            <button class="modal-close_cita" onclick="cerrarModal()">Cerrar modal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar Corte -->
  <div class="modal-bg_corte">
    <div class="modal-dialog_corte">
      <div class="modal-content_corte">
        <div class="modal-title_corte">
          <button type="button" class="modal-close_corte" onclick="cerrarEditarCorte()" data-dismiss="modal" aria-label="Close">
            <span onclick="cerrarEditarCorte()" aria-hidden="true">&hyphen;</span>
          </button>
        </div>
        <div class="modal-body_corte">
          <div class="modal-imagen_corte" id="imagen-div">
          <img src="">
          </div>
          <div class="modal-control_corte">
            <label>Nuevo corte: </label>
            <select placeholder="Corte" name="corte" id="idCorteEdit" class="form-control">
              <option class="placeholder-select" value="" disabled selected hidden>Selecciona una corte</option>
              <option value="idCorteEdit">Selecciona un corte</option>
            </select>
            <button id="actualizarCorte">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

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
        /*console.log("info citas tabla")
        console.log(data)*/

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
                          <button class="btn-editar-corte" onclick="editarCorte(${r.id})">
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
    $.ajax({
        type: "GET",
        url: 'http://api.kikosbarbershop.online/public/barberia',
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        /*console.log("info select barberia")
        console.log(data)*/

        data.barberias.forEach(r => {
          $('#idBarberia').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
        });

      });
  </script>

  <!-- Su funcion es obtener todos los barberos-->
  <script>
    
    $.ajax({
        type: "GET",
        url: 'http://api.kikosbarbershop.online/public/barbero',
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        /*console.log("info select barbero")
        console.log(data)*/

        data.barberos.forEach(r => {
          $('#idBarbero').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
        });

      });
  </script>

  <!-- Su funcion es obtener todos los cortes-->
  <script>
    $.ajax({
        type: "GET",
        url: 'http://api.kikosbarbershop.online/public/corte',
        data: {},
        dataType: "json",
        headers: {
          token: localStorage.getItem("token")
        }
      })
      .done(function(data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        /*console.log("info select corte")
        console.log(data)*/

        data.cortes.forEach(r => {
          $('#idCorte').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
          $('#idCorteEdit').append("<option value='" + r.id + "'>" + r.nombre + "</option>")

        });

      });
  </script>


  <!-- Este script sirve para enviar los datos del formulario y guardarlos
      en la base de datos del servidor-->
  <script>
    
    $('#guardar').click(function() {

      /*var url = 'http://api.kikosbarbershop.online/public/cita';*/
      $.ajax({
          url: 'http://api.kikosbarbershop.online/public/cita',
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
          /*console.log(data);*/
          location.href="<?php base_url() ?>Citas";

        })
        .fail(function() {
          console.log("Error", "Ocurrio un problema al guardar la cita")
        })
    });
  </script>

  <!-- Su funcion es cambiar el estado de la cita, cancelar la cita-->
  <script>
    
    function cancelar(id) {
      /*var url = 'http://api.kikosbarbershop.online/public/cita/update/';*/
      
      $.ajax({
          url: 'http://api.kikosbarbershop.online/public/cita/update/' + id,
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
          /*console.log(data);*/
          location.href="<?php base_url() ?>Citas";

        })
        .fail(function() {
          console.log("Error", "Ocurrio un problema al cancelar la cita")
        })

    }

  </script>

  <!-- Su funcion es cerrar la sesion del usuario-->
  <script>
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

    /*var url = 'http://api.kikosbarbershop.online/public/cita/';*/

    $.ajax({
                url: 'http://api.kikosbarbershop.online/public/cita/' + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
            .done(function(data, textStatus, jqXHR) {
                var cita = data.cita;

                /*console.log(data.cita);*/

                $('#barberia-div').html("<div id='" + cita.idBarberia + "'>" + cita.barberia.nombre + "</div>");
                $('#barbero-div').html("<div id='" + cita.idBarbero + "'>" + cita.barbero.nombre + "</div>");
                $('#corte-div').html("<div id='" + cita.idCorte + "'>" + "<img src='" +  cita.corte.visualizacion +"'>" + "</div>");
                $('#fecha-div').html("<div id='" + cita.fecha + "'>" + cita.fecha + "</div>");
                $('#hora-div').html("<div id='" + cita.hora + "'>" + cita.hora + "</div>");
                $('#estado-div').html("<div id='" + cita.estado + "'>" + cita.estado + "</div>");
            });
    }

    function cerrarModal() {
      var modalBgCita = document.querySelector('.modal-bg_cita');
      var modalCloseCita = document.querySelector('.modal-close_cita');
      modalBgCita.classList.remove('modal-bg_cita_active');


    }

  </script>

  <!-- Su funcion es abrir y cerrar el modal de editar corte -->
  <script>
    function editarCorte(id){
      var btnModalCorte = document.querySelectorAll('.btn-editar-corte');
      var modalBgCorte = document.querySelector('.modal-bg_corte');
      modalBgCorte.classList.add('modal-bg_corte_active');
      
      $.ajax({
                url: 'http://api.kikosbarbershop.online/public/cita/' + id,
                data: {},
                type: "GET",
                dataType: "json",
                headers: {
                    token: localStorage.getItem("token")
                }
            })
            .done(function(data, textStatus, jqXHR) {
                var cita = data.cita;

                /*console.log(data.cita);*/

                $('#imagen-div').html("<div id='" + cita.idCorte + "'>" + "<img src='" +  cita.corte.visualizacion +"'>" + "</div>");
                
                /*$('#idCorteEdit').html("<option id='" + cita.idCorte + "'>" + cita.corte.nombre + "</option>");*/
                
            });


            $('#actualizarCorte').click(function() {

              $.ajax({
                url: 'http://api.kikosbarbershop.online/public/cita/update/' + id,
                type: 'POST',
                data: {
                  "idCorte": $("#idCorteEdit").val(),
                },
                dataType: "json",
                headers: {
                  token: localStorage.getItem("token")
                }
              })
              .done(function(data, res) {
                console.log("El corte ha sido actualizado con exito");
                console.log(data.result);
                location.href="<?php base_url() ?>Citas";

              })
              .fail(function() {
                console.log("Error", "Ocurrio un problema al actualizar el corte")
              })
              });
      
    }
      
    function cerrarEditarCorte() {
      var modalBgCorte = document.querySelector('.modal-bg_corte');
      var modalCloseCorte = document.querySelector('.modal-close_corte');
      modalBgCorte.classList.remove('modal-bg_corte_active');
    }

  </script>


  <script src="<?php base_url() ?>Cita/js/cita.js"></script>
</body>

</html>