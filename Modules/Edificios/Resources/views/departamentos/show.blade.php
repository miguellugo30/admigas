<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i> Depto.: {{ $depto->numero_departamento }}
      </h3>
      <div class="card-tools">
          <button type="button" class="btn btn-info btn-sm returnCondominio" ><i class="fas fa-arrow-left"></i> Regresar</button>
          @can('delete departamentos')
            @endcan
            <button type="button" class="btn btn-warning btn-sm editDepartamento"><i class="fas fa-edit"></i> Editar Depto.</button>
            <button type="button" class="btn btn-danger btn-sm deleteDepartamento" ><i class="fas fa-trash-alt"></i> Elminar Depto.</button>
            @can('edit departamentos')
            @endcan
            <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="{{$depto->id}}">
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Estado de Cuenta</a>
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Contacto</a>
                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Medidor</a>
            </div>
        </div>
        <div class="col-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                   <table class="table text-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Folio</th>
                                <th>Cargo</th>
                                <th>Abono</th>
                                <th>Saldo</th>
                                <th>Fecha Limite</th>
                                <th>Fecha Aplicación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $saldo = 0;
                                $pagos = 0;
                                $recibos = 0;
                            @endphp
                            @foreach ($estado_cuenta as $ec)
                                @if ( $ec->concepto == 'Recibo' )
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha )) }}</td>
                                        <td>{{ $ec->concepto }}</td>
                                        <td class="viewRecibo" data-id_recibo="{{ $ec->referencia_completa }}">{{ $ec->referencia_completa }}</td>
                                        <td>$ {{ number_format( round($ec->importe), 2) }}</td>
                                        <td></td>
                                        <td>
                                            @php
                                                $saldo = $saldo + round( $ec->importe );
                                                $recibos = $recibos + round( $ec->importe );
                                            @endphp
                                            $ {{ number_format( $saldo, 2 ) }}
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha_aplicacion )) }}</td>
                                        <td></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha )) }}</td>
                                        <td>{{ $ec->concepto }}</td>
                                        <td>{{ $ec->referencia_completa }}</td>
                                        <td></td>
                                        <td>$ {{ number_format( round( $ec->importe) , 2) }}</td>
                                        <td>
                                            @php
                                                $saldo = $saldo -  round( $ec->importe) ;
                                                $pagos = $pagos +  round( $ec->importe) ;
                                            @endphp
                                            $ {{ number_format( $saldo, 2 ) }}
                                        </td>
                                        <td></td>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha_aplicacion )) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Saldo</th>
                                <th>$ {{ number_format( $recibos, 2 ) }}</th>
                                <th>$ {{ number_format( $pagos, 2 ) }}</th>
                                <th>$ {{ number_format( $saldo, 2 ) }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <dl class="row">
                        <dt class="col-sm-4">Numero de departamento:</dt>
                        <dd class="col-sm-8">{{ $depto->numero_departamento }}</dd>

                        <dt class="col-sm-4">Nombre completo:</dt>
                        <dd class="col-sm-8">{{ $depto->Contacto_Depto->nombre.' '.$depto->Contacto_Depto->apellido_paterno.' '.$depto->Contacto_Depto->apellido_materno }}</dd>

                        <dt class="col-sm-4">Telefono fijo:</dt>
                        <dd class="col-sm-8">{{ $depto->Contacto_Depto->telefono }}</dd>

                        <dt class="col-sm-4 ">Telefono movil:</dt>
                        <dd class="col-sm-8">{{ $depto->Contacto_Depto->celular }}</dd>

                        <dt class="col-sm-4">Correo Electronico</dt>
                        <dd class="col-sm-8">{{ $depto->Contacto_Depto->correo_electronico }}</dd>

                        <dt class="col-sm-4">Código Confirmación</dt>
                        <dd class="col-sm-8">{{ $depto->Contacto_Depto->codigo_verificacion }}</dd>

                        <dt class="col-sm-4">Referencia de pago:</dt>
                        <dd class="col-sm-8">{{ $depto->numero_referencia }}</dd>

                        <dt class="col-sm-4">Clasificación:</dt>
                        <dd class="col-sm-8">{{ Str::ucfirst( $depto->Contacto_Depto->clasficacion ) }}</dd>

                        <dt class="col-sm-4">Medio Recepción Recibo:</dt>
                        <dd class="col-sm-8">{{ Str::ucfirst( $depto->Contacto_Depto->medio ) }}</dd>
                    </dl>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <dl class="row">
                        <dt class="col-sm-4">Marca:</dt>
                        <dd class="col-sm-8">{{ $depto->Medidores->marca }}</dd>

                        <dt class="col-sm-4">Numero de serie:</dt>
                        <dd class="col-sm-8">{{ $depto->Medidores->numero_serie }}</dd>

                        <dt class="col-sm-4">Lectura Inicial:</dt>
                        <dd class="col-sm-8">
				{{ $depto->Medidores->lectura }}<br>
                            <button id="updateLecturaInicial" class="btn btn-primary btn-sm">Editar Lectura Inicial</button>
			</dd>
                    </dl>
                </div>
            </div>
        </div>
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

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-sm btn-primary" id="updateDepartamento"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->


<!-- MODAL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal-lectura-inicial" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Lectura Inicial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <form id="lecturaInicialForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="lecturaInicial" class="form-label">Lectura Inicial</label>
                        <input type="email" class="form-control" id="lecturaInicial" placeholder="00000.000">
                    </div>
                    <div class="mb-3">
                        <label for="fechaLectura" class="form-label">Fecha Lectura</label>
                        <input type="date" class="form-control" id="fechaLectura">
                    </div>
                    <div class="mb-3">
                        <label for="testigoFotografico" class="form-label">Testigo Fotografico</label>
                        <input type="file" class="form-control" id="testigoFotografico" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-sm btn-primary" id="saveLecturaInicial"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->
