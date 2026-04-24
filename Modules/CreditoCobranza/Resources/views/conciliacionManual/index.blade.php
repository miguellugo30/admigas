<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-money-bill-wave "></i>
            Pagos No Conciliados
          </h3>
          <div class="card-tools">
                <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body table-responsive">
        <table id="table-pagos-no-conciliados" class="table table-sm">
            <thead class="thead-light">
                <th class="buscar text-center"><i class="far fa-check-circle"></i></th>
                <th class="buscar">Fecha Pago</th>
                <th class="buscar">Referencia</th>
                <th class="buscar">Importe</th>
                <th>Autorizacion</th>
                <th>Medio Pago</th>
            </thead>
            <tbody>
                @foreach ($pagos as $pago)
                    <tr>
                        <td class="text-center"><input type="radio" name="pago_no_conciliado" id="pago_no_conciliado" value="{{ $pago->id }}"></td>
                        <td>{{ date('d-m-Y', strtotime( $pago->fecha_pago )) }}</td>
                        <td>{{ $pago->referencia }}</td>
                        <td>$ {{ number_format( $pago->importe, 2) }}</td>
                        <td>{{ $pago->autorizacion }}</td>
                        <td>{{ $pago->medio_pago }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-city"></i>
            Aplicacion a Departamento
        </h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Unidad</label>
                        <select class="form-control form-control-sm" id="unidad_no_conciliado">
                            <option value="">Selecciona una opcion</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
              <div class="col-sm result-search-edificio">

              </div>
              <div class="col-sm result-search-depto">

              </div>
            </div>
            <div class="col text-center">
                <button type="button" class="btn btn-primary btn-sm conciliar-button">Conciliar</button>
            </div>
          </div>
    </div>
</div>

<script>
$(function() {
    $('#table-pagos-no-conciliados').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "ordering": false,
        "searching": true,
        "lengthChange": false,
        "pageLength": 5
    });
});
</script>
