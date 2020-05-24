<div class="col">
    <div class="form-group">
        <label for="nombre">Nombre *:</label>
        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $zona->nombre }}">
        <input type="hidden" name="zona_id" id="zona_id" value="{{ $zona->id }}">
        @csrf
    </div>
    <div class="form-group">
        <label for="descripcion">Descripcion :</label>
        <input type="text" class="form-control form-control-sm" id="descripcion" placeholder="Descripcion" value="{{ $zona->descripcion }}">
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
