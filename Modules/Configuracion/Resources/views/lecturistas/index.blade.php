<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-comment-dots"></i>
            Lecturistas
          </h3>
          <div class="card-tools">
            @can('delete lecturista')
                <button type="button" class="btn btn-danger btn-sm deleteLecturista" style="display:none"><i class="fas fa-trash-alt"></i> Elminar</button>
            @endcan
            @can('edit lecturista')
                <button type="button" class="btn btn-warning btn-sm editLecturista" style="display:none"><i class="fas fa-edit"></i> Editar</button>
            @endcan
            @can('create lecturista')
                <button type="button" class="btn btn-primary btn-sm newLecturista"><i class="fas fa-plus"></i> Nuevo</button>
            @endcan
                <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body">
        <table id="table-lecturistas" class="table table-sm">
            <thead class="thead-light">
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Telefono</th>
                <th>Celular</th>
                <th>Correo Electronico</th>
            </thead>
            <tbody>
                @foreach ($lecturistas as $lecturista)
                    <tr data-id="{{ $lecturista->id }}">
                        <td>{{ $lecturista->nombre }}</td>
                        <td>{{ $lecturista->apellidos }}</td>
                        <td>{{ $lecturista->telefono }}</td>
                        <td>{{ $lecturista->celular }}</td>
                        <td>{{ $lecturista->correo_electronico }}</td>
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
