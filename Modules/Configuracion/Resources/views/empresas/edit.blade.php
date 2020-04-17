<div class="col">
    <div class="form-group">
        <label for="razon-social">Razon Social *:</label>
        <input type="text" class="form-control form-control-sm" id="razon_social" placeholder="Razon Social" value="{{ $empresa->razon_social }}">
        @csrf
    </div>
    <div class="form-group">
        <label for="rfc">RFC *:</label>
        <input type="text" class="form-control form-control-sm" id="rfc" placeholder="RFC" value="{{ $empresa->rfc }}">
    </div>
    <div class="form-group">
        <label for="calle">Calle :</label>
        <input type="text" class="form-control form-control-sm" id="calle" placeholder="Calle" value="{{ $empresa->calle }}">
    </div>
    <div class="form-group">
        <label for="numero">Numero :</label>
        <input type="text" class="form-control form-control-sm" id="numero" placeholder="Numero" value="{{ $empresa->numero }}">
    </div>
    <div class="form-group">
        <label for="colonia">Colonia :</label>
        <input type="text" class="form-control form-control-sm" id="colonia" placeholder="Colonia" value="{{ $empresa->colonia }}">
    </div>
    <div class="form-group">
        <label for="municipio">Municipio :</label>
        <input type="text" class="form-control form-control-sm" id="municipio" placeholder="Municipio" value="{{ $empresa->municipio }}">
    </div>
    <div class="form-group">
        <label for="cp">C.P. :</label>
        <input type="text" class="form-control form-control-sm" id="cp" placeholder="C.P." value="{{ $empresa->cp }}">
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
