<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><i class="fas fa-home returnZona" style="cursor: pointer"></i></li>
        <li class="breadcrumb-item active"><i class="fas fa-map-marker "></i> <a class="returnUnidad" data-zona-id="{{ $zona->first()->id }}">{{ $zona->first()->nombre }}</a></li>
    </ol>
</div><!-- /.col -->
<div class="col-sm-6">
    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-warning editZona">
            <i class="fas fa-pencil-alt"></i>
            Editar Zona
        </button>
        <button type="button" class="btn btn-danger deleteZona">
            <i class="fas fa-trash-alt"></i>
                Eliminar Zona
        </button>
    </div>
</div><!-- /.col -->
