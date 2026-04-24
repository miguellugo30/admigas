<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><i class="fas fa-home returnZona"  style="cursor: pointer"></i></li>
        <li class="breadcrumb-item"><i class="fas fa-map-marker"></i> <a class="returnUnidad" style="cursor: pointer" data-zona-id="{{ $unidad->first()->Zonas()->first()->id }}">{{ $unidad->first()->Zonas()->first()->nombre }}</a></li>
        <li class="breadcrumb-item active"><i class="fas fa-city"></i> <a class="unidad" data-unidad-id="{{ $unidad->first()->id }}">{{ $unidad->first()->nombre }}</a></li>
    </ol>
</div><!-- /.col -->
<div class="col-sm-6">
    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-warning editUnidad">
            <i class="fas fa-pencil-alt"></i>
                Editar Unidad
        </button>
        <button type="button" class="btn btn-danger deleteUnidad">
            <i class="fas fa-trash-alt"></i>
                Eliminar Unidad
        </button>
    </div>
</div><!-- /.col -->
