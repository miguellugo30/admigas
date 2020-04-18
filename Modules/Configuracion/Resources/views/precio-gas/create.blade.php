<div class="col">
    <div class="form-group">
        <label for="precio">Precio Gas *:</label>
        <input type="number" class="form-control form-control-sm" id="precio" placeholder="Precio Gas">
        @csrf
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
