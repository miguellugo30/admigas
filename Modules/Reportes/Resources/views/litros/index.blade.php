<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd"></i>
            Reporte de Litros
        </h3>
        <div class="card-tools">

        </div>
    </div>
    <div class="card-body table-responsive table-striped table-sm container">
        <div class="row justify-content-md-center">
            <form class="form-inline">
                <label for="desde">Desde: </label>
                <input type="date" class="form-control mb-2 mr-sm-2 form-control-sm" id="desde" name="desde" placeholder="Desde">
                <label for="hasta">Hasta: </label>
                <input type="date" class="form-control mb-2 mr-sm-2 form-control-sm" id="hasta" name="hasta" placeholder="Hasta">
                @csrf
                <button type="submit" class="btn btn-primary mb-2 btn-sm generateReportLitros"><i class="fas fa-cogs"></i> Generar</button>
                <button type="submit" class="btn btn-primary mb-2 ml-2 btn-sm exportReportLitros" style="display: none"><i class="fas fa-download"></i> Descargar</button>
            </form>
        </div>
        <div class="col showResult"></div>
    </div>
</div>
