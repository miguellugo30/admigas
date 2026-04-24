<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd"></i>
            Conciliación Bancaria
          </h3>
          <div class="card-tools">

        </div>
    </div>
    <div class="card-body table-responsive">
        <h5>Adjunte un Archivo, para realizar la Conciliación</h5>
        <form method="post" enctype="multipart/form-data" id="formConciliacion">
            @csrf
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="archivoConciliar" name="archivoConciliar" lang="es" required>
                <label class="custom-file-label" for="archivoConciliar">Archivo de Conciliación</label>
            </div>
            <div class="col mt-4 text-center">
                <button type="submit" id="conciliar" class="btn btn-primary">Conciliar</button>
            </div>
        </form>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
