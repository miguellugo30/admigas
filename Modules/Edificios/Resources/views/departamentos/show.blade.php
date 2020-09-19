<div class="card-header">
    <h3 class="card-title">
        <i class="far fa-building"></i> Depto.: {{ $depto->numero_departamento }}
      </h3>
      <div class="card-tools">
          <button type="button" class="btn btn-info btn-sm returnCondominio" ><i class="fas fa-arrow-left"></i> Regresar</button>
          @can('delete departamentos')
            @endcan
            <button type="button" class="btn btn-danger btn-sm deleteDepartamento" ><i class="fas fa-trash-alt"></i> Elminar</button>
            @can('edit departamentos')
            @endcan
            <button type="button" class="btn btn-warning btn-sm editDepartamento"><i class="fas fa-edit"></i> Editar</button>
            <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="{{$depto->id}}">
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Estado de Cuenta</a>
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Contacto</a>
                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Medidor</a>
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <table class="table table-sm table-bordered table-striped dataTable compact" role="grid">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Cargo</th>
                                <th>Abono</th>
                                <th>Saldo</th>
                                <th>Fecha Limite</th>
                                <th>Fecha Aplicacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recibos as $recibo)
                                <tr>
                                    <td>{{$recibo->clave_recibo}}</td>
                                    <td>{{ date('d-m-Y', strtotime( $recibo->fecha_recibo )) }}</td>
                                    <td>$ {{ number_format( $recibo->importe, 2 )}}</td>
                                    <td></td>
                                    <td>$ {{ number_format( $recibo->importe, 2 )}}</td>
                                    <td>{{ date('d-m-Y', strtotime( $recibo->fecha_limite_pago )) }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="2" >Saldo</th>
                                <th>$ {{ number_format( $saldos->total_recibos, 2) }}</th>
                                <th>$ {{ number_format( $saldos->total_pagos, 2) }}</th>
                                <th>$ {{ number_format( $saldos->saldo, 2) }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
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

                        <dt class="col-sm-4">Referencia de pago:</dt>
                        <dd class="col-sm-8">{{ $depto->numero_referencia }}</dd>
                    </dl>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <dl class="row">
                        <dt class="col-sm-4">Marca:</dt>
                        <dd class="col-sm-8">{{ $depto->Medidores->marca }}</dd>

                        <dt class="col-sm-4">Numero de serie:</dt>
                        <dd class="col-sm-8">{{ $depto->Medidores->numero_serie }}</dd>

                        <dt class="col-sm-4">Lectura Inicial:</dt>
                        <dd class="col-sm-8">{{ $depto->Medidores->lectura }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
