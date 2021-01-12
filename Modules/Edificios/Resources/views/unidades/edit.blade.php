<div class="form-group">
    <label for="nombre">Nombre *:</label>
    <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $unidad->nombre }}">
    <input type="hidden" name="unidad_id" id="unidad_id" value="{{ $unidad->id }}">
    @csrf
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="calle">Calle :</label>
            <input type="text" class="form-control form-control-sm" id="calle" placeholder="Calle" value="{{ $unidad->calle }}">
        </div>
        <div class="form-group">
            <label for="colonia">Colonia :</label>
            <input type="text" class="form-control form-control-sm" id="colonia" placeholder="Colonia" value="{{ $unidad->colonia }}">
        </div>
        <div class="form-group">
            <label for="cp">C.P. :</label>
            <input type="text" class="form-control form-control-sm" id="cp" placeholder="C.P." value="{{ $unidad->cp }}">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="numero">Numero :</label>
            <input type="text" class="form-control form-control-sm" id="numero" placeholder="Numero" value="{{ $unidad->numero }}">
        </div>
        <div class="form-group">
            <label for="municipio">Municipio :</label>
            <input type="text" class="form-control form-control-sm" id="municipio" placeholder="Municipio" value="{{ $unidad->delegacion_municipio }}">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control form-control-sm" id="estado" placeholder="Estado" value="{{ $unidad->estado }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="entre_calles">Entre calles :</label>
    <input type="text" class="form-control form-control-sm" id="entre_calles" placeholder="Entre calles" value="{{ $unidad->entre_calle }}">
</div>
<div class="alert alert-primary" role="alert">
    <i class="fas fa-dollar-sign"></i> Precio de Gas
</div>
<div class="form-group">
    <label for="entre_calles">Precio de Gas :</label>
    <input type="number" min="0" value="{{ $unidad->precio_gas }}"  class="form-control form-control-sm" id="precio_gas" placeholder="Precio de Gas">
</div>
<div class="form-group">
    <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
