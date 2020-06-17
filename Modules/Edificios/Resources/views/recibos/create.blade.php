<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i>
        <b>{{ $condominio->first()->nombre }}</b>
      </h3>
      <div class="card-tools">
        <button type="button" class="btn btn-info btn-sm returnCondominio" ><i class="fas fa-arrow-left"></i> Regresar</button>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-info btn-sm generateRecibos" ><i class="fas fa-list-ol"></i> Generar Recibos</button>
            <button type="button" class="btn btn-info btn-sm printRecibos" ><i class="fas fa-print"></i> Imprimir Recibos</button>
            <button type="button" class="btn btn-info btn-sm sendRecibos" ><i class="fas fa-mail-bulk"></i> Enviar Recibos</button>
            <div class="dropdown dropleft">
                <button class="btn btn-sm btn-danger dropdown-toggle cancelRecibos" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item cancelAllRecibos" href="#">Cancelar todos los recibos</a>
                  <a class="dropdown-item cancelOneRecibo" href="#">Cancelar y generar un solo recibo</a>
                </div>
              </div>
        </div>
          <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
          <input type="hidden" name="admigas_condominios_id" id="admigas_condominios_id" value="{{ $condominio->first()->id }}">
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-10">
            <div class="form-group row">
                <label for="nombre" class="col-sm-3 col-form-label text-right">Fecha de Recibos*:</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control form-control-sm" id="fecha_recibo" name="fecha_recibo" placeholder="Fecha de Lectura">
                    @csrf
                </div>
            </div>
        </div>
        <div class="col-2">
                <button type="button" class="btn btn-primary btn-sm cargosAdicionales" ><i class="fas fa-file-invoice-dollar"></i> Cargos Adicionales</button>
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
                        <td>{{ "$ ".number_format( $depto->consumo, 2 ) }} </td>
                        <td><a class="viewCargo" data-id_depto="{{ $depto->departamento_id }}" style="cursor: pointer">{{ "$ ".number_format( $depto->cargos , 2 ) }}</a></td>
                        <td>{{ "$ ".number_format( $depto->saldo , 2) }}</td>
                        <td>{{ "$ ".number_format( $depto->consumo + $depto->saldo + $depto->cargos + $depto->gasto_admin , 2 )  }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </form>
</div>
