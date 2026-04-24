<div class="row">
    <div class="col">
        <fieldset>
            <legend>Datos Cliente</legend>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="numero_departamento">Numero de Departamento *:</label>
                                <input type="hidden" name="admigas_departamentos_id" id="admigas_departamentos_id" value="{{ $depto->id }}">
                                <input type="text" class="form-control form-control-sm" id="numero_departamento" placeholder="Numero de Departamento" value="{{ $depto->numero_departamento }}" readonly>
                                @csrf
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="numero_referencia">Numero de Referencia *:</label>
                                <input type="text" class="form-control form-control-sm" id="numero_referencia" placeholder="Numero de Referencia" value="{{ $depto->numero_referencia }}">
                                <input type="hidden" name="referencia_anterior" id="referencia_anterior" value="{{ $depto->numero_referencia }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre *:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $depto->Contacto_Depto->nombre }}">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="apellido_paterno">Apellido Paterno *:</label>
                                <input type="text" class="form-control form-control-sm" id="apellido_paterno" placeholder="Apellido Paterno" value="{{ $depto->Contacto_Depto->apellido_paterno }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="apellido_materno">Apellido Materno *:</label>
                                <input type="text" class="form-control form-control-sm" id="apellido_materno" placeholder="Apellido Materno" value="{{ $depto->Contacto_Depto->apellido_materno }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="telefono">Telefono :</label>
                                <input type="text" class="form-control form-control-sm" id="telefono" placeholder="Telefono" value="{{ $depto->Contacto_Depto->telefono }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="celular">Telefono Celular *:</label>
                                <input type="text" class="form-control form-control-sm" id="celular" placeholder="Telefono Celular" value="{{ $depto->Contacto_Depto->celular }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electronico *:</label>
                <input type="text" class="form-control form-control-sm" id="correo_electronico" placeholder="Correo Electronico" value="{{ $depto->Contacto_Depto->correo_electronico }}">
            </div>
            <div class="form-group">
                <label for="">Clasificación *:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="clasificacion" id="clasificacion1" value="propio" checked>
                    <label class="form-check-label" for="clasificacion1">Propio</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="clasificacion" id="clasificacion2" value="arrendado">
                    <label class="form-check-label" for="clasificacion2">Arrendado</label>
                  </div>
            </div>
            <div class="form-group">
                <label for="">Medio de Recepción de recibo *:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="medio" id="medio1" value="digital" checked>
                    <label class="form-check-label" for="medio1">Electronico</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="medio" id="medio2" value="fisico">
                    <label class="form-check-label" for="medio2">Impreso</label>
                  </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="celular">Gasto de Administracion :</label>
                    <input type="text" class="form-control form-control-sm" id="gasto_admin" placeholder="Gasto de Administracion" value="{{ $depto->gasto_admin }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="telefono">Lectura Inicial :</label>
                        <input type="text" class="form-control form-control-sm" id="lectura_inicial" placeholder="Lectura Inicial" value="{{ $depto->Contacto_Depto->telefono }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="celular">Fecha Lectura Inicial:</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_lectura_inical" placeholder="Fecha Lectura Inicial" value="{{ $depto->Contacto_Depto->celular }}">
                    </div>
                </div>
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
