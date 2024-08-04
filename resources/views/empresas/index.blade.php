@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">
        @if(session()->has('mensaje'))
            <div class="col-sm-4">
                <div class="alert border-0 border-start border-5 border-{{Session::get('color')}} alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-{{Session::get('color')}}"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-{{Session::get('color')}}">Mensaje</h6>
                            <div>{{Session::get('mensaje')}}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <br>

        <h5>Lista de Empresas</h5>
        <a class="btn btn-primary btn-sm" onclick="btnNuevaEmpresa()">Nuevo</a>
        <div class="table-responsive">
            <br>
            <table id="dtempresas" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Empresa</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $e)
                        <tr>
                            <td>{{$e->id}}</td>
                            <td>{{$e->nombre}}</td>
                            <td>
                                @if ($e->estado==1)
                                    <label for="" style="color: green">Activado</label>
                                @elseif ($e->status==0)
                                    <label for="" style="color: rgb(83, 78, 73)28, 49, 0)">Desactivado</label>
                                @endif
                            </td>
                            <td>
                                <a onclick="btnEditarEmpresa('{{$e->id}}')" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Editar Empresa"><i class="fas fa-edit"></i></a>
                                <a onclick="btnEliminarEmpresa('{{$e->id}}')" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Eliminar Empresa"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>



{{-- Modal Nueva Empresa --}}
<div class="modal fade" id="modalNuevaEmpresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('empresas.store')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Nombre Empresa</label>
                            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-12">
                            <label for="">Estado Empresa</label>
                            <select name="estado" id="estado" class="form-select form-select-sm" required>
                                <option value="">Seleccione</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Inhabilitado</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- Modal Editar Empresa --}}
<div class="modal fade" id="modalEditarEmpresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('empresas.update')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="id_empresa" id="id_empresa" hidden readonly>
                            <label for="">Nombre Empresa</label>
                            <input type="text" class="form-control form-control-sm" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-12">
                            <label for="">Estado Empresa</label>
                            <select name="estado" id="edit_estado" class="form-select form-select-sm" required>
                                <option value="">---Seleccione---</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Inhabilitado</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>

@include('messages.confirmacion_eliminar')

@endsection

@section('js')
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
         $(document).ready(function() {
            $('#dtempresas').DataTable({
                "order": [[ 0, "desc" ]] // Ordena por la primera columna en orden descendente
            });
        });

        function btnEditarEmpresa(id) {
            $.ajax({
                type: "GET",
                url: "/empresas/edit/"+id,
                dataType: "json",
                success: function (response) {
                    $("#id_empresa").val(id);
                    $("#edit_nombre").val(response['nombre']);
                    $("#edit_estado").val(response['estado']).change();
                    $("#modalEditarEmpresa").modal("show");
                    
                }
            });
        }

        function btnEliminarEmpresa(id) {
            $("#id_registro_eliminar").val(id);
            ruta="{{route('empresas.destroy')}}"
            $('#formEliminar').attr('action', ruta);
            $("#modalConfirmarEliminar").modal("show");

        }

        function btnNuevaEmpresa() {
            $("#modalNuevaEmpresa").modal("show");
        }

    </script>
@endsection