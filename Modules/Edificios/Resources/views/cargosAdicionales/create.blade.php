<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="nombre" class="col-sm-3 col-form-label text-right">Servicio*:</label>
            <div class="col-sm-9">
                <select name="servicio" id="servicio" class="form-control form-control-sm" >
                    <option value="">Selecciona un servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre." -- $ ".$servicio->costo }}</option>
                    @endforeach
                </select>
                @csrf
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="nombre" class="col-sm-3 col-form-label text-right">Plazo*:</label>
            <div class="col-sm-9">
                <input type="number" name="plazo" id="plazo" class="form-control form-control-sm" min="1" value="1">
            </div>
        </div>
    </div>
</div>
<form id="formCargosCapture">
    <table id="table-cargos" class="table table-sm  table-bordered table-striped tableNewForm">
        <thead class="thead-light">
            <tr class="text-center">
                <th>Departamento</th>
                <th><button type="button" id = "addDeptoCargos" class="btn btn-info btn-sm"><i class="fas fa-plus"></i></button></th>
            </tr>
        </thead>
        <tbody>
                <tr id="tr_1" class="text-center clonar">
                    <td>
                        <select name="depto_1" id="depto" class="form-control form-control-sm">
                            <option value="">Selecciona una opcion</option>
                            @for ($i = 0; $i < count( $deptos ); $i++)
                                @php
                                    $depto = $deptos[$i]
                                @endphp
                                <option value="{{ $depto->departamento_id }}">{{ $depto->numero_departamento." -- ".$depto->nombre." ".$depto->apellido_paterno." ".$depto->apellido_materno }}</option>
                            
                            @endfor
                            
                        </select>
                    </td>
                    <td class="tr_clone_remove text-center">
                        <button type="button" name="remove" class="btn btn-danger btn-sm" style="display: none"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
        </tbody>
    </table>
</form>
