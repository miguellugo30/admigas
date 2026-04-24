<div class="col">
    <div class="form-group">
        <label for="nombre">Nombre *:</label>
        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre">
        @csrf
    </div>
    <div class="form-group">
        <label for="apellidos">Apellidos *:</label>
        <input type="text" class="form-control form-control-sm" id="apellidos" placeholder="Apellidos">
    </div>
    <div class="form-group">
        <label for="telefono">Telefono *:</label>
        <input type="text" class="form-control form-control-sm" id="telefono" placeholder="Telefono">
    </div>
    <div class="form-group">
        <label for="celular">Celular *:</label>
        <input type="text" class="form-control form-control-sm" id="celular" placeholder="Celular">
    </div>
    <div class="form-group">
        <label for="correo_electronico">Correo Electronico *:</label>
        <input type="text" class="form-control form-control-sm" id="correo_electronico" placeholder="Correo Electronico">
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
