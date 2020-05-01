<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i>
        <b>{{ $condominio->first()->nombre }}</b>
      </h3>
      <div class="card-tools">
          <button type="button" class="btn btn-info btn-sm saveLecturas" ><i class="fas fa-list-ol"></i>Guardar Lecturas</button>
          <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
          <input type="hidden" name="admigas_condominios_id" id="admigas_condominios_id" value="{{ $condominio->first()->id }}">
    </div>
</div>
<div class="card-body">
    <div class="col">
        <div class="form-group">
            <label for="nombre">Fecha de Lectura *:</label>
            <input type="date" class="form-control form-control-sm" id="fecha_lectura" placeholder="Fecha de Lectura">
            @csrf
        </div>
    </div>
    <form id="formLecturasCapture">
        <table id="table-departamentos" class="table table-sm  table-bordered table-striped">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>Depto</th>
                    <th>Nombre</th>
                    <th>Medidor</th>
                    <th>Lectura Anterior</th>
                    <th>Lectura Actual</th>
                    <th>Diferencia</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count( $deptos ); $i++)
                    @php
                        $depto = $deptos[$i]
                    @endphp
                    <tr data-id='{{ $depto->departamento_id }}' class="text-center">
                        <th>{{ $i + 1 }}</th>
                        <th>{{ $depto->numero_departamento }}</th>
                        <th>{{ $depto->nombre." ".$depto->apellidos }}</th>
                        <th>{{ $depto->numero_serie }}</th>
                        <th>{{ $depto->lectura_anterior }}</th>
                        <th>
                            <input type="text" name="lectura" id="lectura" class="nueva_lectura" data-posicion="{{ $i }}" data-lectura_anterior="{{ $depto->lectura_anterior }}">
                            <input type="hidden" name="departamento_id" id="departamento_id" value="{{ $depto->departamento_id }}">
                            <input type="hidden" name="medidor_id" id="medidor_id" value="{{ $depto->medidor_id }}">
                        </th>
                        <th class="diferencia_{{ $i }}"></th>
                    </tr>
                @endfor
            </tbody>
        </table>
    </form>
</div>
