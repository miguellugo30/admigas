    <input type="hidden" name="id" id="id" value="{{ \Auth::user()->Departamentos->first()->id }}">
    {{ csrf_field() }}
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b><i class="fas fa-address-card"></i> Datos Personales </b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Nombre:</dt>
                            <dd class="col-sm-6">{{ $depto->contacto_depto->nombre }}</dd>

                            <dt class="col-sm-6">Apellido Paterno:</dt>
                            <dd class="col-sm-6">{{ $depto->contacto_depto->apellido_paterno }}</dd>

                            <dt class="col-sm-6">Apellido Materno:</dt>
                            <dd class="col-sm-6">{{ $depto->contacto_depto->apellido_materno }}</dd>

                            <dt class="col-sm-6">Teléfono fijo:</dt>
                            <dd class="col-sm-6">{{ $depto->contacto_depto->telefono }}</dd>

                            <dt class="col-sm-6">Teléfono celular:</dt>
                            <dd class="col-sm-6">{{ $depto->contacto_depto->celular }}</dd>

                            <dt class="col-sm-6">Correo Electrónico:</dt>
                            <dd class="col-sm-6">{{ $depto->contacto_depto->correo_electronico }}</dd>
                        </dl>
                        <div class="col text-right">
                            <button type="button" class="btn btn-primary btn-sm editClient">
                                <i class="fas fa-user-edit"></i>
                                Editar
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <!--div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"><b><i class="fas fa-tachometer-alt"></i> Datos de medidor</b></h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Marca:</dt>
                            <dd class="col-sm-6"></dd>

                            <dt class="col-sm-6">Número de Serie:</dt>
                            <dd class="col-sm-6"></dd>

                            <dt class="col-sm-6">Lectura Inicial:</dt>
                            <dd class="col-sm-6"></dd>

                        </dl>
                    </div>
                </div-->
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b><i class="fas fa-building"></i> Datos de Departamento</b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Edificio   :</dt>
                            <dd class="col-sm-6">{{ $depto->Condominios->nombre }}</dd>

                            <dt class="col-sm-6">Número de Departamento:</dt>
                            <dd class="col-sm-6">{{ $depto->numero_departamento }}</dd>

                            <dt class="col-sm-6">Referencia de pago:</dt>
                            <dd class="col-sm-6">{{ $depto->numero_referencia }}</dd>

                        </dl>
                    </div>
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"><b><i class="fas fa-tachometer-alt"></i> Datos de medidor</b></h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Marca:</dt>
                            <dd class="col-sm-6">{{ $depto->Medidores->marca }}</dd>

                            <dt class="col-sm-6">Número de Serie:</dt>
                            <dd class="col-sm-6">{{ $depto->Medidores->numero_serie }}</dd>

                            <dt class="col-sm-6">Lectura Inicial:</dt>
                            <dd class="col-sm-6">{{ $depto->Medidores->lectura }}</dd>

                        </dl>
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
                    <h5 class="modal-title" id="tituloModal">Editar Datos Personales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-4 col-form-label">Nombre:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $depto->contacto_depto->nombre }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apellido_paterno" class="col-sm-4 col-form-label">Apellido Paterno:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="apellido_paterno" placeholder="Apellido Paterno" value="{{ $depto->contacto_depto->apellido_paterno }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apellido_materno" class="col-sm-4 col-form-label">Apellido Materno:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="apellido_materno" placeholder="Apellido Materno" value="{{ $depto->contacto_depto->apellido_materno }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefono" class="col-sm-4 col-form-label">Telefono Fijo:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="telefono" placeholder="Telefono Fijo" value="{{ $depto->contacto_depto->telefono }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="celular" class="col-sm-4 col-form-label">Telefono Celular:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="celular" placeholder="Telefono Celular" value="{{ $depto->contacto_depto->celular }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="correo_electronico" class="col-sm-4 col-form-label">Correo Electronico:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="correo_electronico" placeholder="Correo Electronico" value="{{ $depto->contacto_depto->correo_electronico }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="actionSave"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>