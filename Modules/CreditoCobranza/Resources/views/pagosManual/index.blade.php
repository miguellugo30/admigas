<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-city"></i>
            Aplicacion a Departamento
        </h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Unidad</label>
                        <select class="form-control form-control-sm" id="unidad_no_conciliado">
                            <option value="">Selecciona una opcion</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
              <div class="col-sm result-search-edificio">

              </div>
              <div class="col-sm result-search-depto">

              </div>
            </div>

          </div>
    </div>
    <div class="card-body table-responsive">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="importe">Importe</label>
                        <input type="number" class="form-control form-control-sm" name="importe" id="importe" >
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="fecha">Fecha de pago</label>
                        <input type="date" class="form-control form-control-sm" name="fecha" id="fecha" >
                    </div>
                </div>
                <div class="col-sm">
                    <label for="importe">Adjunte un comprobante de pago</label>

                    <form method="post" enctype="multipart/form-data" id="formConciliacion">
                        @csrf
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control form-control-sm" id="archivoConciliar" name="archivoConciliar" lang="es" required>
                            <label class="custom-file-label" for="archivoConciliar">Archivo de Conciliación</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col text-center">
                <button type="button" class="btn btn-primary btn-sm aplicar-pago-button">Aplicar Pago</button>
            </div>
        </div>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
