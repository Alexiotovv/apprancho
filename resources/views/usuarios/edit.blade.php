@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">
        <h5>Editar Usuario</h5>
            <form action="{{route('usuario.update')}}" method="POST">@csrf
                <input type="text" name="id" value="{{$usuario->id}}" hidden>
                <label for="">Nombre</label>
                <input type="text" value="{{$usuario->name}}" class="form-control" name="name">
                <label for="">Correo</label>
                <input type="email" class="form-control" name="email" value="{{$usuario->email}}" autocomplete="new-password">
                <label for="">Rol</label>
                <select name="role" id="" class="form-select">
                    @if ($usuario->role=="admin")
                        <option value="admin" selected>admin</option>
                        <option value="asistente">asistente</option>
                        <option value="visor">visor</option>
                    @elseif ($usuario->role=="asistente")
                        <option value="asistente" selected>asistente</option>
                        <option value="visor">visor</option>
                        <option value="admin">admin</option>
                    @elseif ($usuario->role=="visor")
                        <option value="visor" selected>visor</option>
                        <option value="asistente">asistente</option>
                        <option value="admin">admin</option>
                    @endif


                </select>

                <label for="">Estado</label>
                <select name="status" id="" class="form-select">
                    @if ($usuario->status==1)
                        <option value="1" selected>Habilitado</option>
                        <option value="0">Inhabilitado</option>
                    @elseif ($usuario->status==0)
                        <option value="1">Habilitado</option>
                        <option value="0" selected>Inhabilitado</option>
                    @endif
                </select>
                <br>
                <a id="btnCambiarPassword" class="btn btn-warning btn-sm">Cambiar Contraseña</a>
                <br>
                <br>
                <button class="btn btn-primary bt-sm">Guardar</button>
            </form>

        </form>
      
    </div>
</div>


<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('change.password')}}" method="POST">@csrf
                <div class="modal-body">
                    <input type="text" name="idusuario" value="{{$usuario->id}}" hidden>
                    <label for="">Nueva Contraseña</label>
                    <input type="password" autocomplete="new-password" class="form-control" name="contra" placeholder="*****">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $("#btnCambiarPassword").on("click",function (e) { 
            e.preventDefault();
            $("#modalCambiarPassword").modal('show');
        })
    </script>
@endsection