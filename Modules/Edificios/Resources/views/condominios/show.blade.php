<div class="card list-deptos">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-building"></i>
            <b>{{ $condominio->first()->nombre }}</b>
          </h3>
          <div class="card-tools">
              <button type="button" class="btn btn-info btn-sm capturarLecturas" ><i class="fas fa-list-ol"></i> Lecturas</button>
              <button type="button" class="btn btn-info btn-sm generarRecibos" ><i class="fas fa-money-check-alt"></i> Recibos</button>
            @can('delete departamentos')
                <button type="button" class="btn btn-danger btn-sm deleteDepartamento" style="display:none"><i class="fas fa-trash-alt"></i> Elminar</button>
            @endcan
            @can('edit departamentos')
                <button type="button" class="btn btn-warning btn-sm editDepartamento" style="display:none"><i class="fas fa-edit"></i> Editar</button>
            @endcan
            @can('create departamentos')
                <button type="button" class="btn btn-primary btn-sm newDepartamento"><i class="fas fa-plus"></i> Nuevo</button>
            @endcan
              <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
              <input type="hidden" name="admigas_condominios_id" id="admigas_condominios_id" value="{{ $condominio->first()->id }}">
        </div>
    </div>
    <div class="card-body">
        <table id="table-departamentos" class="table table-sm table-bordered table-striped dataTable" role="grid">
            <thead class="thead-light">
                <tr>
                    <th>Depto</th>
                    <th>Nombre</th>
                    <th>Medidor</th>
                    <th>Lectura Inicial</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deptos as $depto)
                    <tr data-id='{{ $depto->id }}'>
                        <td>{{ $depto->numero_departamento }}</td>
                        <td>{{ $depto->Contacto_Depto()->first()->nombre." ".$depto->Contacto_Depto()->first()->apellidos }}</td>
                        <td>{{ $depto->Medidores()->first()->numero_serie }}</td>
                        <td>{{ $depto->Medidores()->first()->lectura }}</td>
                        <td>Estatus</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card list-deptos-capture" style="display:none">
</div>

<!-- MODAL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                    ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-sm btn-primary" id="action"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->
