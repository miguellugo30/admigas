    <!--div class="form-group">
        <label for="num_serie">Numero de Serie *:</label>
        <input type="text" class="form-control form-control-sm" id="num_serie" placeholder="Numero de Serie">
        @csrf
    </div-->
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="num_serie">Numero de Serie *:</label>
            <input type="text" class="form-control form-control-sm" id="num_serie" placeholder="Numero de Serie">
            @csrf
        </div>
        <div class="form-group">
            <label for="fecha_fabricacion">Fecha de fabricación *:</label>
            <input type="date" class="form-control form-control-sm" id="fecha_fabricacion" placeholder="Fecha de fabricación ">
        </div>
    </div>
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
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="capacidad">Capacidad * :</label>
            <input type="text" class="form-control form-control-sm" id="capacidad" placeholder="Capacidad">
        </div>
        <div class="form-group" >
            <label for="inventario">Inventario *:</label><br>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="inventario1" name="inventario" class="custom-control-input" value="propio" checked>
                <label class="custom-control-label" for="inventario">Propio</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="inventario2" name="inventario" class="custom-control-input" value="comodato">
                <label class="custom-control-label" for="inventario">Comodato</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
