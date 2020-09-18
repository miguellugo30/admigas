<div class="row">
    <div class="col">
        <fieldset>
            <legend>Datos Cliente</legend>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="numero_departamento">Numero de Departamento *:</label>
                        <input type="text" class="form-control form-control-sm" id="numero_departamento" placeholder="Numero de Departamento">
                        @csrf
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre *:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono :</label>
                        <input type="text" class="form-control form-control-sm" id="telefono" placeholder="Telefono">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="numero_referencia">Numero de Referencia *:</label>
                        <input type="text" class="form-control form-control-sm" id="numero_referencia" placeholder="Numero de Referencia">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos *:</label>
                        <input type="text" class="form-control form-control-sm" id="apellidos" placeholder="Apellidos">
                    </div>
                    <div class="form-group">
                        <label for="celular">Telefono Celular *:</label>
                        <input type="text" class="form-control form-control-sm" id="celular" placeholder="Telefono Celular">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electronico *:</label>
                <input type="text" class="form-control form-control-sm" id="correo_electronico" placeholder="Correo Electronico">
            </div>
        </fieldset>
    </div>

    <div class="col-4">
        <fieldset>
            <legend>Datos Medidor</legend>
            <!--div class="form-group">
                <label for="tipo">Tipo *:</label>
            </div-->
            <div class="form-group">
                <input type="hidden" class="form-control form-control-sm" id="tipo" placeholder="tipo" value="1">
                <label for="marca">Marca :</label>
                <input type="text" class="form-control form-control-sm" id="marca" placeholder="Marca">
            </div>
            <div class="form-group">
                <label for="numero_serie">Numero de Serie *:</label>
                <input type="text" class="form-control form-control-sm" id="numero_serie" placeholder="Numero de Serie">
            </div>
            <div class="form-group">
                <label for="lectura">Lectura Inicial *:</label>
                <input type="text" class="form-control form-control-sm" id="lectura" placeholder="Lectura Inicial">
            </div>
            <div class="form-group">
                <label for="fecha_lectura">Fecha Lectura Inicial *:</label>
                <input type="date" class="form-control form-control-sm" id="fecha_lectura" placeholder="Fecha Lectura Inicial">
            </div>
        </fieldset>
    </div>
</div>
<div class="form-group">
    <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
