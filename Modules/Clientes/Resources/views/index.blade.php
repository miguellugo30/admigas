@extends('adminlte::page')

@section('title', 'Admigas')


@section('content')
<!-- Main content -->
<div class="content">
    {{ csrf_field() }}
    <input type="hidden" name="id" id="id" value="{{ \Auth::user()->Departamentos->first()->id }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b> Su saldo al día es: </b></h3>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="col">
                            @if ( count( $recibos ) > 0 )
                                <h1>$ {{ number_format( round( (float)$saldo[0]->total_recibos - (float)$saldo[0]->total_pagos ), 2) }}</h1>
                            @else
                                <h1>$ 0.00</h1>
                            @endif
                        </div>
                        <div class="col">
                            <div class="row">
                                @if ( count( $recibos ) > 0 )
                                    <div class="col text-left">
                                        <button type="button" class="btn btn-info viewDetail">Ver detalle</button>
                                    </div>
                                    <div class="col text-right">

                                        <form action="https://www.adquiramexico.com.mx:443/mExpress/pago/avanzado" method="post" target="_blank"/>
                                            <input type="hidden" name="importe" value="{{  number_format( 1, 2) }}"/>
                                            <input type="hidden" name="referencia" value="{{ $recibos->first()->referencia."_".$recibos->first()->clave_recibo }}"/>
                                            <input type="hidden" name="urlretorno" value="https://administradora.2gadmin.com.mx/clientes/registro-pago/"/>
                                            <input type="hidden" name="idexpress" value="1842"/>
                                            <input type="hidden" name="financiamiento" value="0"/>
                                            <input type="hidden" name="plazos" value=""/>
                                            <input type="hidden" name="mediospago" value="111000"/>
                                            <input type="hidden" name="signature" value="{{ $signature }}"/>
                                            <button type="submit" class="btn btn-primary ">Pagar ahora</button>
                                        </form>
				                </div>
                                @else
                                    <div class="col text-left">
                                        <button type="button" class="btn btn-info viewDetail" disabled>Ver detalle</button>
                                    </div>
                                    <div class="col text-right">
                                        <button type="button" class="btn btn-primary" disabled>Pagar ahora</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"><b>Grafica de consumos</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="col canvas">
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>Su fecha limite de pago es:</b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ( count( $recibos ) > 0 )
                            <div class="col text-center">
                                @if ( date('Y-m-d') > $recibos->first()->fecha_limite_pago )
                                    <h2 class="text-danger">{{ date('d-m-Y', strtotime( $recibos->first()->fecha_limite_pago)) }}</h2>
                                @else
                                    <h2>{{ date('d-m-Y', strtotime( $recibos->first()->fecha_limite_pago)) }}</h2>
                                @endif
                            </div>
                            <div class="col text-left" >
                                @if ( date('Y-m-d') > $recibos->first()->fecha_limite_pago )
                                    <p class="text-danger">Su fecha de pago ha vencido, pague de manera inmediato y evite cortes en su suministro de gas</p>
                                @else
                                    <p>Le pedimos pagar a tiempo, para no generar cargos adicionales</p>
                                @endif
                            </div>
                        @else
                            <div class="col text-left" >
                                <h2>No se tiene fecha de límite de pago</h2>
                                <p>En esta sección se mostrara su fecha limite</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"><b>Consulte y descargue sus recibos</b></h3>
                    </div>
                    <div class="card-body text-center">
                        <p>Puedes visualizar y descargar tus últimos 6 recibos</p>
                        @php
                            \Carbon\Carbon::setlocale(config('app.locale'));
                        @endphp
                        <div class="form-group">
                            <select class="form-control" id="recibos">
                                <option value="">Selecciona una opcion</option>
                                @for ($i = 0; $i < count( $ultimosRecibos ); $i++)
                                    <option value="{{ $ultimosRecibos[$i]->id }}">
                                        {{
                                            \Str::ucfirst( \Carbon\Carbon::parse($ultimosRecibos[$i]->fecha_recibo)->translatedFormat('F') )
                                        }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <button type="button" id="viewRecibo" class="btn btn-primary viewRecibo">
                                <i class="fas fa-binoculars"></i>
                                Visualizar
                            </button>
                            <button type="button" id="downloadRecibo" class="btn btn-primary downloadRecibo">
                                <i class="fas fa-download"></i>
                                Descargar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <!-- MODAL -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Detalle de Consumo del mes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <dl class="row">
                        @if ( count( $recibos ) > 0 )
                            <dt class="col-sm-6">Lectura Inicial:</dt>
                            <dd class="col-sm-6">{{ number_format( $recibos->first()->lectura_anterior,3 ) }}</dd>
                            <dt class="col-sm-6">Lectura Final:</dt>
                            <dd class="col-sm-6">{{ number_format( $recibos->first()->lectura_actual,3 ) }}</dd>
                            <dt class="col-sm-6">Consumo en M3:</dt>
                            <dd class="col-sm-6">{{ number_format( ( $recibos->first()->lectura_actual - $recibos->first()->lectura_anterior ),2 ) }}</dd>
                            <dt class="col-sm-6">Consumo en litros:</dt>
                            <dd class="col-sm-6">{{ number_format( ( $recibos->first()->lectura_actual - $recibos->first()->lectura_anterior ) * $depto->Condominios->factor,2 ) }}</dd>
                            <dt class="col-sm-6">Consumo del mes:</dt>
                            <dd class="col-sm-6">$ {{ number_format( $recibos->first()->importe,2 ) }}</dd>
                            <dt class="col-sm-6">Saldo a favor:</dt>
                            <dd class="col-sm-6">$ {{ number_format( 0,2 ) }}</dd>
                            <dt class="col-sm-6">Adeudo pendiente:</dt>
                            <dd class="col-sm-6">$ {{ number_format( $recibos->first()->adeudo_anterior,2 ) }}</dd>
                            <dt class="col-sm-6">Cargos del periodo:</dt>
                            <dd class="col-sm-6">$ {{ number_format( $recibos->first()->cargos_adicionales,2 ) }}</dd>
                            <dt class="col-sm-6">Cuota de Administración:</dt>
                            <dd class="col-sm-6">$ {{ number_format( $recibos->first()->gasto_admin,2 ) }}</dd>
                            <dt class="col-sm-6">Total a pagar:</dt>
                            <dd class="col-sm-6">$ {{ number_format( $recibos->first()->total_pagar,2 ) }}</dd>
                        @endif
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
@endsection
