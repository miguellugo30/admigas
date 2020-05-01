<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i>
        <b>{{ $condominio->first()->nombre }}</b>
      </h3>
      <div class="card-tools">
          <button type="button" class="btn btn-primary btn-sm saveLecturas" ><i class="fas fa-list-ol"></i> Generar Recibos</button>
          <button type="button" class="btn btn-success btn-sm saveLecturas" ><i class="fas fa-print"></i> Imprimir Recibos</button>
          <button type="button" class="btn btn-info btn-sm saveLecturas" ><i class="fas fa-mail-bulk"></i> Enviar Recibos</button>
          <button type="button" class="btn btn-danger btn-sm saveLecturas" ><i class="fas fa-trash-alt"></i> Cancelar Recibos</button>
          <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
          <input type="hidden" name="admigas_condominios_id" id="admigas_condominios_id" value="{{ $condominio->first()->id }}">
    </div>
</div>
<div class="card-body">
    <div class="col">
        <div class="form-group">
            <label for="nombre">Fecha de Recibos *:</label>
            <input type="date" class="form-control form-control-sm" id="fecha_lectura" placeholder="Fecha de Lectura">
            @csrf
        </div>
    </div>
    <form id="formLecturasCapture">
        <table id="table-departamentos" class="table table-sm  table-bordered table-striped">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>Depto.</th>
                    <th>Nombre</th>
                    <th>Medidor</th>
                    <th>Lectura Anterior</th>
                    <th>Lectura Actual</th>
                    <th>Consumo Mes</th>
                    <th>Adeudo Anterior</th>
                    <th>Saldo al Corte</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count( $deptos ); $i++)
                    @php
                        $depto = $deptos[$i]
                    @endphp
                    <tr data-id='{{ $depto->departamento_id }}' class="text-center">
                        <th>{{ $depto->numero_departamento }}</th>
                        <th>{{ $depto->nombre." ".$depto->apellidos }}</th>
                        <th>{{ $depto->numero_serie }}</th>
                        <th>{{ $depto->lectura_anterior }}</th>
                        <th>{{ $depto->lectura_actual }}</th>
                        <th>{{ number_format( ( ( $depto->lectura_actual - $depto->lectura_anterior ) * $condominio->first()->factor ) * $precio->precio, 2 ) }} </th>
                        <th> </th>
                        <th></th>
                    </tr>
                @endfor
            </tbody>
        </table>
    </form>
</div>
