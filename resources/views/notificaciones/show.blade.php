<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-bell"></i>
            Notificaciones
          </h3>
          <div class="card-tools">
                @csrf
        </div>
    </div>
    <div class="card-body">
        <table id="table-notificaciones" class="table table-sm">
            <thead class="thead-light">
                <th>Asunto</th>
                <th>Unidad</th>
                <th>Edificio</th>
                <th>Departamento</th>
                <th>Accion</th>
            </thead>
            <tbody>
                @foreach ($notificaciones as $notificacion)
                    <tr>
                        <td>{{$notificacion->data['asunto']}}</td>
                        <td>{{$notificacion->data['unidad']}}</td>
                        <td>{{$notificacion->data['edificio']}}</td>
                        <td>{{$notificacion->data['depto']}}</td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm readNotification"
                                    data-notification_id="{{$notificacion->id}}"
                                    data-depto_id="{{$notificacion->data['depto_id']}}"
                                    data-type="{{$notificacion->type}}"
                                >
                                <i class="fas fa-eye" ></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
