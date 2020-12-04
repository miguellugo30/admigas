<div class="card ">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tachometer-alt"></i>
            <b>Tanques</b>
          </h3>
          <div class="card-tools">
        </div>
    </div>
    <div class="card-body">
        <table id="table-tanques" class="table table-sm table-bordered table-striped dataTable compact" role="grid">
            <thead class="thead-light">
                <tr>
                    <th>Marca</th>
                    <th>Número de Serie</th>
                    <th>Capacidad</th>
                    <th>Fecha Fabricación</th>
                    <th>Estado al Recibir</th>
                    <th>Inventario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unidad->Tanques as $tanque)
                    <tr data-id='{{ $tanque->id }}'>
                        <td>{{ $tanque->marca }}</td>
                        <td>{{ $tanque->num_serie }}</td>
                        <td>{{ number_format( $tanque->capacidad ) }}</td>
                        <td>{{ date('d-m-Y', strtotime( $tanque->fecha_fabricacion )) }}</td>
                        <td>{{ $tanque->estado_al_recibir }} %</td>
                        <td>{{ Str::ucfirst($tanque->inventario ) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
