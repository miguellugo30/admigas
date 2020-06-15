<div class="row">
    <div class="col">
        <fieldset>
            <legend>Datos Cliente</legend>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="numero_departamento">Numero de Departamento *:</label>
                        <input type="hidden" name="admigas_departamentos_id" id="admigas_departamentos_id" value="{{ $depto->id }}">
                        <input type="text" class="form-control form-control-sm" id="numero_departamento" placeholder="Numero de Departamento" value="{{ $depto->numero_departamento }}">
                        @csrf
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre *:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $depto->Contacto_Depto->nombre }}">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono *:</label>
                        <input type="text" class="form-control form-control-sm" id="telefono" placeholder="Telefono" value="{{ $depto->Contacto_Depto->telefono }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="numero_referencia">Numero de Referencia *:</label>
                        <input type="text" class="form-control form-control-sm" id="numero_referencia" placeholder="Numero de Referencia" value="{{ $depto->numero_referencia }}">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos *:</label>
                        <input type="text" class="form-control form-control-sm" id="apellidos" placeholder="Apellidos" value="{{ $depto->Contacto_Depto->apellidos }}">
                    </div>
                    <div class="form-group">
                        <label for="celular">Telefono Celular :</label>
                        <input type="text" class="form-control form-control-sm" id="celular" placeholder="Telefono Celular" value="{{ $depto->Contacto_Depto->celular }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electronico *:</label>
                <input type="text" class="form-control form-control-sm" id="correo_electronico" placeholder="Correo Electronico" value="{{ $depto->Contacto_Depto->correo_electronico }}">
            </div>
        </fieldset>
    </div>

    <!--div class="col-4">
        <fieldset>
            <legend>Datos Medidor</legend>
            <--div class="form-group">
                <label for="tipo">Tipo *:</label>
            </div>
            <input type="hidden" class="form-control form-control-sm" id="tipo" placeholder="tipo" value="1">
            <div class="form-group">
                <label for="marca">Marca :</label>
                <input type="text" class="form-control form-control-sm" id="marca" placeholder="Marca" value="{{-- $depto->Medidores->marca --}}">
            </div>
            <div class="form-group">
                <label for="numero_serie">Numero de Serie *:</label>
                <input type="text" class="form-control form-control-sm" id="numero_serie" placeholder="Numero de Serie" value="{{-- $depto->Medidores->numero_serie --}}">
            </div>
            <div class="form-group">
                <label for="lectura">Lectura Inicial *:</label>
                <input type="text" class="form-control form-control-sm" id="lectura" placeholder="Lectura Inicial" value="{{-- $depto->Medidores->lectura --}}">
            </div>
            <div class="form-group">
                <label for="fecha_lectura">Fecha Lectura Inicial *:</label>
                <input type="date" class="form-control form-control-sm" id="fecha_lectura" placeholder="Fecha Lectura Inicial" value="">
            </div>
        </fieldset>
    </div-->
</div>
<div class="form-group">
    <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>