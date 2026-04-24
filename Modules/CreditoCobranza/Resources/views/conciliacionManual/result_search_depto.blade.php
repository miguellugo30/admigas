<div class="form-group">
    <label for="exampleFormControlSelect1">Departamento</label>
    <select class="form-control form-control-sm" id="depto_no_conciliado">
        <option value="">Selecciona una opcion</option>
        @foreach ($departamentos as $departamento)
            <option value="{{ $departamento->id }}">{{ $departamento->numero_departamento }}</option>
        @endforeach

    </select>
</div>
