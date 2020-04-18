<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label for="name">Nombre *:</label>
            <input type="text" class="form-control form-control-sm" id="name" placeholder="Nombre usuario" value="{{$user->name}}">
            <input type="hidden" class="form-control form-control-sm" id="id_user"  value="{{$user->id}}">
            @csrf
        </div>
        <div class="form-group">
            <label for="email">Email *:</label>
            <input type="text" class="form-control form-control-sm" id="email" placeholder="Email" value="{{$user->email}}">
        </div>
        <div class="form-group">
            <label for="pass_1">Contraseña *:</label>
            <input type="password" class="form-control form-control-sm" id="password" placeholder="Contraseña">
        </div>
        <div class="form-group">
            <label for="pass_2">Confirmar contraseña *:</label>
            <input type="password" class="form-control form-control-sm" id="password_confirmation" placeholder="Contraseña">
        </div>
        <div class="form-group">
            <label for="rol">Empresa *:</label>
            <select name="empresa" id="empresa" class="form-control form-control-sm">
                <option value="">Selecciona una empresa</option>
                @foreach( $empresas as $empresa )
                    <option value="{{ $empresa->id }}" {{ $user->admigas_empresas_id == $empresa->id ? 'selected="selected"' : '' }}>{{ $empresa->razon_social }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="rol">Roles *:</label>
            <select name="rol" id="rol" class="form-control form-control-sm">
                <option value="">Selecciona un rol</option>
                @foreach( $roles as $rol )
                    <option value="{{ $rol->name }}" {{ $user->getRoleNames()->first() == $rol->name ? 'selected="selected"' : '' }} >{{ $rol->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
        </div>
        <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
            <ul></ul>
        </div>
    </div>
    <div class="col modulosEmpresa">

        <h5><b>Modulos</b></h5>
        <div class="col">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach( $modulos as $modulo )
                        @if ($loop->first)
                            <li class="nav-item active"><a href="#tab_{{ Str::snake( $modulo->nombre ) }}" class="nav-link" data-toggle="tab">{{ $modulo->nombre }}</a></li>
                        @else
                            <li class="nav-item"><a href="#tab_{{ Str::snake( $modulo->nombre ) }}" class="nav-link" data-toggle="tab">{{ $modulo->nombre }}</a></li>
                        @endif
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach( $modulos as $modulo )
                        @if ($loop->first)
                            <div class="tab-pane active" id="tab_{{ Str::snake( $modulo->nombre ) }}">
                        @else
                            <div class="tab-pane" id="tab_{{ Str::snake( $modulo->nombre ) }}">
                        @endif
                                <h3>{{ $modulo->nombre }}</h3>
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Ver</th>
                                            <th>Categoria</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modulo->Menus as $menu)
                                            <tr>
                                                <td><input type="checkbox" class="modulo" name="permisos[]" id="permisos[]" data-value="{{ $menu->id }}" value="{{ $menu->permiso }}" {{ $user->hasPermissionTo( $menu->permiso ) ? 'checked' : '' }}></td>
                                                <td>
                                                    <b>{{ $menu->nombre }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" id="sub_cat_{{ $menu->id }}" {{ $user->hasPermissionTo( $menu->permiso ) ? 'style=display:table-cell' : 'style=display:none' }} >
                                                    <div class="col" >
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Crear</th>
                                                                    <th>Editar</th>
                                                                    <th>Eliminar</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="checkbox" name="permisos[]" id="permisos[]" {{ $user->hasPermissionTo( str_replace( 'view', 'create', $menu->permiso) ) ? 'checked' : '' }} value="{{ str_replace( 'view', 'create',$menu->permiso) }}" class="mark"></td>
                                                                    <td><input type="checkbox" name="permisos[]" id="permisos[]" {{ $user->hasPermissionTo( str_replace( 'view', 'edit', $menu->permiso) ) ? 'checked' : '' }} value="{{ str_replace( 'view', 'edit',$menu->permiso) }}" class="mark"></td>
                                                                    <td><input type="checkbox" name="permisos[]" id="permisos[]" {{ $user->hasPermissionTo( str_replace( 'view', 'delete', $menu->permiso) ) ? 'checked' : '' }} value="{{ str_replace( 'view', 'delete',$menu->permiso) }}" class="mark"></td>
                                                                    <td><span class="button-checkbox"><button type="button" class="btn btn-sm" data-color="primary"></button><input type="checkbox" class="marcarDesmarcar mark" data-value="{{ $menu->id }}"> Marcar/Desmarcar Todos</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                        </div><!-- /.tab-pane -->
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
    </div>
</div>
