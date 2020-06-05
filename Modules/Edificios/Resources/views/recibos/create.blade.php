<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i>
        <b>{{ $condominio->first()->nombre }}</b>
      </h3>
      <div class="card-tools">
        <button type="button" class="btn btn-info btn-sm returnCondominio" ><i class="fas fa-arrow-left"></i> Regresar</button>
          <button type="button" class="btn btn-primary btn-sm generateRecibos" ><i class="fas fa-list-ol"></i> Generar Recibos</button>
          <button type="button" class="btn btn-success btn-sm printRecibos" ><i class="fas fa-print"></i> Imprimir Recibos</button>
          <button type="button" class="btn btn-info btn-sm sendRecibos" ><i class="fas fa-mail-bulk"></i> Enviar Recibos</button>
          <button type="button" class="btn btn-danger btn-sm cancelRecibos" ><i class="fas fa-trash-alt"></i> Cancelar Recibos</button>
          <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
          <input type="hidden" name="admigas_condominios_id" id="admigas_condominios_id" value="{{ $condominio->first()->id }}">
    </div>
</div>
<div class="card-body">
    <div class="col">
        <div class="form-group">
            <label for="nombre">Fecha de Recibos *:</label>
            <input type="date" class="form-control form-control-sm" id="fecha_recibo" name="fecha_recibo" placeholder="Fecha de Lectura">
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
                    <th>Cargos del Periodo</th>
                    <th>Adeudo Anterior</th>
                    <th>Saldo al Corte</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count( $data ); $i++)
                    @php
                        $depto = $data[$i]
                    @endphp
                    <tr data-id='{{ $depto->departamento_id }}' class="text-center">
                        <td>{{ $depto->numero_departamento }}</td>
                        <td>{{ $depto->nombre." ".$depto->apellidos }}</td>
                        <td>{{ $depto->numero_serie }}</td>
                        <td>{{ $depto->lectura_anterior }}</td>
                        <td>{{ $depto->lectura_actual }}</td>
                        <td>{{ number_format( $depto->consumo, 2 ) }} </td>
                        <td></td>
                        <td>{{ number_format( $depto->saldo , 2) }}</td>
                        <td>{{ number_format( $depto->consumo +  $depto->saldo, 2 )  }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </form>
</div>
