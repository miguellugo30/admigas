<div class="col">
    <div class="form-group">
        <label for="nombre">Nombre *:</label>
        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $lecturista->nombre }}">
        <input type="hidden" name="lecturista_id" id="lecturista_id" value="{{ $lecturista->id }}">
        @csrf
    </div>
    <div class="form-group">
        <label for="apellidos">Apellidos *:</label>
        <input type="text" class="form-control form-control-sm" id="apellidos" placeholder="Apellidos" value="{{ $lecturista->apellidos }}">
    </div>
    <div class="form-group">
        <label for="telefono">Telefono *:</label>
        <input type="text" class="form-control form-control-sm" id="telefono" placeholder="Telefono" value="{{ $lecturista->telefono }}">
    </div>
    <div class="form-group">
        <label for="celular">Celular *:</label>
        <input type="text" class="form-control form-control-sm" id="celular" placeholder="Celular" value="{{ $lecturista->celular }}">
    </div>
    <div class="form-group">
        <label for="correo_electronico">Correo Electronico *:</label>
        <input type="text" class="form-control form-control-sm" id="correo_electronico" placeholder="Correo Electronico" value="{{ $lecturista->correo_electronico }}">
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
