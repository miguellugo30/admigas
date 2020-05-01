
    <div class="form-group">
        <label for="num_serie">Numero de Serie *:</label>
        <input type="text" class="form-control form-control-sm" id="num_serie" placeholder="Numero de Serie">
        @csrf
    </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="marca">Marca :</label>
            <input type="text" class="form-control form-control-sm" id="marca" placeholder="Marca">
        </div>
        <div class="form-group">
            <label for="estado_al_recibir">Porcentaje Inicial * :</label>
            <input type="text" class="form-control form-control-sm" id="estado_al_recibir" placeholder="Porcentaje Inicial ">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="capacidad">Capacidad * :</label>
            <input type="text" class="form-control form-control-sm" id="capacidad" placeholder="Capacidad">
        </div>
        <div class="form-group" >
            <label for="inventario">Inventario *:</label>
            <select name="inventario" id="inventario" class="form-control form-control-sm">
                <option value="propio">Propio</option>
                <option value="comodato">Comodato</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
