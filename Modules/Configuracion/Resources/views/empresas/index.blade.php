<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-industry"></i>
            Empresas
          </h3>
          <div class="card-tools">
            @can('delete menus')
                <button type="button" class="btn btn-danger btn-sm deleteEmpresa" style="display:none"><i class="fas fa-trash-alt"></i> Elminar</button>
            @endcan
            @can('edit menus')
                <button type="button" class="btn btn-warning btn-sm editEmpresa" style="display:none"><i class="fas fa-edit"></i> Editar</button>
            @endcan
            @can('create menus')
                <button type="button" class="btn btn-primary btn-sm newEmpresa"><i class="fas fa-plus"></i> Nuevo</button>
            @endcan
                <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body">
        <table id="table-empresas" class="table table-sm">
            <thead class="thead-light">
                <th>Razon Social</th>
                <th>RFC</th>
                <th>Calle</th>
                <th>Numero</th>
                <th>Colonia</th>
                <th>Municipio</th>
                <th>C.P.</th>
            </thead>
            <tbody>
                @foreach ($empresas as $empresa)
                    <tr data-id="{{ $empresa->id }}">
                        <td>{{ $empresa->razon_social }}</td>
                        <td>{{ $empresa->rfc }}</td>
                        <td>{{ $empresa->calle }}</td>
                        <td>{{ $empresa->numero }}</td>
                        <td>{{ $empresa->colonia }}</td>
                        <td>{{ $empresa->municipio }}</td>
                        <td>{{ $empresa->cp }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
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
