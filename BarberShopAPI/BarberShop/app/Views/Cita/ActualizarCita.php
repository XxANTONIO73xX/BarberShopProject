<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Cita</h4>
            </div>
            <form method="post" action="/cita/create"> 
            <div class="modal-body">
                <div class="form-group">
                <label>Barberia</label><br>
                <select name="barberia" id="barberia" data-placeholder="Selecciona una barberia" class="form-control">
                    <option value=""></option>
                </select>  
                </div>
                
                <div class="form-group">
                <label>Barbero</label><br>
                <select name="barbero" id="barbero" data-placeholder="Selecciona un barbero" class="form-control">
                    <option value=""></option>
                </select>  
                </div>  

                <div class="form-group">
                <label>Corte</label><br>
                <select name="Corte" id="Corte" data-placeholder="Selecciona un corte" class="form-control">
                    <option value=""></option>
                </select>  
                </div>  

                <div class="form-group">
                <label>Fecha y Hora</label><br>
                <input type="date" name="fecha" id="fecha">
                <br>
                <input type="time" name="hora" id="hora">
                </div>  
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
</div>