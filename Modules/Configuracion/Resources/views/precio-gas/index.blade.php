<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-dollar-sign"></i>
            Precio de Gas
          </h3>
          <div class="card-tools">
              <button type="button" class="btn btn-danger btn-sm deletePrecioGas" style="display:none"><i class="fas fa-trash-alt"></i> Elminar</button>
              <button type="button" class="btn btn-warning btn-sm editPrecioGas" style="display:none"><i class="fas fa-edit"></i> Editar</button>
              <button type="button" class="btn btn-primary btn-sm newPrecioGas"><i class="fas fa-plus"></i> Nuevo</button>
              <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-light">
                <th>Precio</th>
                <th>Fecha</th>
            </thead>
            <tbody>
                @foreach ($precios as $precio)
                <tr data-id="{{ $precio->id }}">
                    <td>{{ '$ '.number_format( $precio->precio,2 ) }}</td>
                    <td>{{ date('d-m-Y', strtotime( $precio->fecha )) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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

