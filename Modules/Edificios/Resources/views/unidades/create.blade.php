<div class="form-group">
    <label for="nombre">Nombre *:</label>
    <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre">
    @csrf
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="calle">Calle :</label>
            <input type="text" class="form-control form-control-sm" id="calle" placeholder="Calle">
        </div>
        <div class="form-group">
            <label for="colonia">Colonia :</label>
            <input type="text" class="form-control form-control-sm" id="colonia" placeholder="Colonia">
        </div>
        <div class="form-group">
            <label for="cp">C.P. :</label>
            <input type="text" class="form-control form-control-sm" id="cp" placeholder="C.P.">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="numero">Numero :</label>
            <input type="text" class="form-control form-control-sm" id="numero" placeholder="Numero">
        </div>
        <div class="form-group">
            <label for="municipio">Municipio :</label>
            <input type="text" class="form-control form-control-sm" id="municipio" placeholder="Municipio">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control form-control-sm" id="estado" placeholder="Estado">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="entre_calles">Entre calles :</label>
    <input type="text" class="form-control form-control-sm" id="entre_calles" placeholder="Entre calles">
</div>
<div class="alert alert-primary" role="alert">
    <i class="fas fa-dollar-sign"></i> Precio de Gas
</div>
<div class="form-group">
    <label for="entre_calles">Precio de Gas :</label>
    <input type="number" min="0" value="0"  class="form-control form-control-sm" id="precio_gas" placeholder="Precio de Gas">
</div>
<div class="form-group">
    <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
