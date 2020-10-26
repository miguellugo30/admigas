<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i>
        <b>{{ $condominio->first()->nombre }}</b>
      </h3>
      <div class="card-tools">
          <button type="button" class="btn btn-info btn-sm returnCondominio" ><i class="fas fa-arrow-left"></i> Regresar</button>
          <button type="button" class="btn btn-info btn-sm sincronizarLecturas" ><i class="fas fa-sync-alt"></i> Sincronizar Lecturas</button>
          <button type="button" class="btn btn-info btn-sm saveLecturas" ><i class="fas fa-list-ol"></i> Guardar Lecturas</button>
          <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
          <input type="hidden" name="admigas_condominios_id" id="admigas_condominios_id" value="{{ $condominio->first()->id }}">
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nombre">Lecturista *:</label>
                <select name="lecturista" id="lecturista" class="form-control form-control-sm">
                    <option value="">Selecciona un lecturista</option>
                    @foreach ($lecturistas as $lecturista)
                        <option value="{{ $lecturista->id }}">{{ $lecturista->nombre." ".$lecturista->apellidos }}</option>
                    @endforeach
                </select>
                @csrf
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="nombre">Fecha de Lectura *:</label>
                <input type="date" class="form-control form-control-sm" id="fecha_lectura" placeholder="Fecha de Lectura">

            </div>
        </div>
    </div>
    <form id="formLecturasCapture" enctype="multipart/form-data" method="post">
        <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
            <ul></ul>
        </div>
        <table id="table-departamentos" class="table table-sm table-bordered table-striped">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>Depto</th>
                    <th>Nombre</th>
                    <th>Medidor</th>
                    <th>Lectura Anterior</th>
                    <th>Lectura Actual</th>
                    <th>Diferencia</th>
                    <th>Testigo Fotografico</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count( $deptos ); $i++)
                    @php
                        $depto = $deptos[$i]
                    @endphp
                    <tr data-id='{{ $depto->departamento_id }}' class="text-center">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $depto->numero_departamento }}</td>
                        <td>{{ $depto->nombre." ".$depto->apellido_paterno." ".$depto->apellido_materno  }}</td>
                        <td>{{ $depto->numero_serie }}</td>
                        <td>{{ $depto->lectura_anterior }}</td>
                        <td>
                            <input type="text" name="lectura" id="lectura_{{ $i }}" class="nueva_lectura form-control form-control-sm" data-posicion="{{ $i }}" data-lectura_anterior="{{ $depto->lectura_anterior }}" size="10">
                            <input type="hidden" name="departamento_id" id="departamento_id_{{ $i }}" value="{{ $depto->departamento_id }}">
                            <input type="hidden" name="medidor_id" id="medidor_id_{{ $i }}" value="{{ $depto->medidor_id }}">
                        </td>
                        <td class="diferencia_{{ $i }}"></td>
                        <td>
                            <!--button data-id-depto="{{-- $depto->departamento_id --}}" class="btn btn-info btn-sm adjuntarFoto" >Adjuntar imagen</button-->
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

    </form>
</div>
