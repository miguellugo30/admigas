@if ( $tanques->isEmpty() )
    <h3>No hay ningun tanque dado de alta.</h3>
@else

    <div class="row">
        <div class="col">
            <div class="form-group" >
                <label for="tipo">Tipo *:</label>
                <select name="tipo" id="tipo" class="form-control form-control-sm">
                    <option value="0">Edificio</option>
                    <option value="1">Punto de Venta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre *:</label>
                <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre ">
                @csrf
            </div>
            <div class="form-group tipo-punto-venta">
                <label for="descuento">Descuento *:</label>
                <input type="text" class="form-control form-control-sm" id="descuento" placeholder="Descuento">
            </div>
            <div class="form-group tipo-punto-venta">
                <label for="factor">Factor de Conversion *:</label>
                <input type="text" class="form-control form-control-sm" id="factor" placeholder="Factor de Conversion ">
            </div>
            <div class="form-group">
                <label for="gasto_admin">Gasto de Administracion *:</label>
                <input type="text" class="form-control form-control-sm" id="gasto_admin" placeholder="Gasto de Administracion">
            </div>
            <div class="form-group">
                <label for="fecha_lectura">Fecha de Lectura *:</label>
                <input type="date" class="form-control form-control-sm" id="fecha_lectura" placeholder="Fecha Lectura">
            </div>
        </div>
        <div class="col">
            <fieldset>
                <legend>Tanques</legend>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center"><input type="checkbox" name="todos" id="todos" value="0">  Todos</th>
                            <th>Tanque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tanques as $tanque)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="tanques[]" id="tanques[]" value="{{ $tanque->id }}"></td>
                                <td>{{ $tanque->marca." ".$tanque->num_serie }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </fieldset>
        </div>
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>

@endif
