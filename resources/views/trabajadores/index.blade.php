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
        
        <h5>Lista de Trabajadores</h5>
        <a class="btn btn-primary btn-sm" onclick="btnNuevoTrabajador()">Nuevo</a>

        @error('documento')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="table-responsive">
            <br>
            <table id="dttrabajadores" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Documento</th>
                        <th>Nombre Completo</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Empresa Actual</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trabajadores as $t)
                        <tr>
                            <td>{{$t->id}}</td>
                            <td>{{$t->documento}}</td>
                            <td>{{$t->apellido}} {{$t->nombre}}</td>
                            <td>{{$t->cargo}}</td>
                            <td>
                                @if ($t->estado==1)
                                    <label for="" style="color: green">Habilitado</label>
                                @elseif ($t->estado==0)
                                    <label for="" style="color: rgb(83, 78, 73)28, 49, 0)">Inhabilitado</label>
                                @endif
                            </td>
                            <td>{{$t->nombre_empresa}}</td>
                            <td>
                                <a onclick="btnEditarTrabajador('{{$t->id}}')" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Editar Trabajador"><i class="fas fa-edit"></i></a>
                                {{-- <a onclick="btnEmpresas('{{$t->id}}')" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Empresas"><i class="fas fa-city"></i></a> --}}
                                <a onclick="btnEliminarTrabajador('{{$t->id}}')" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Eliminar Trabajador"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>



{{-- Modal Nuevo Trabajador --}}
<div class="modal fade" id="modalNuevoTrabajador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Trabajador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('trabajadores.store')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Doc.Identidad</label>
                            <input type="text" class="form-control form-control-sm" id="documento" name="documento" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Apellido</label>
                            <input type="text" class="form-control form-control-sm" id="apellido" name="apellido" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Cargo</label>
                            <input list="lista-cargos" id="cargo" name="cargo" class="form-control form-control-sm">
                            <datalist id="lista-cargos">
                                @foreach ($cargos as $cargo)
                                    <option value="{{$cargo}}">
                                @endforeach
                            </datalist>
                            
                        </div>
                        <div class="col-md-4">
                            <label for="">Estado</label>
                            <select name="estado" id="estado" class="form-select form-select-sm" required>
                                <option value="">---Seleccione---</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Inhabilitado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Empresa</label>
                            <select name="empresa" id="empresa" class="form-select form-select-sm" required>
                                <option value="">---SeleccioneEmpresa---</option>
                                @foreach ($empresas as $emp)
                                    <option value="{{$emp->id}}">{{$emp->nombre}}</option>
                                @endforeach
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


{{-- Modal Editar Trabajador --}}
<div class="modal fade" id="modalEditarTrabajador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Trabajador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('trabajadores.update')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Doc.Identidad</label>
                            <input type="text" class="form-control form-control-sm" id="edit_documento" name="documento" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="id_trabajador" id="id_trabajador" hidden readonly>
                            <label for="">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="edit_nombre" name="nombre" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Apellido</label>
                            <input type="text" class="form-control form-control-sm" id="edit_apellido" name="apellido" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Cargo</label>
                            <input list="lista-cargos" id="edit_cargo" name="cargo" class="form-control form-control-sm">
                            <datalist id="lista-cargos">
                                @foreach ($cargos as $cargo)
                                    <option value="{{$cargo}}">
                                @endforeach
                            </datalist>
                            
                        </div>
                        <div class="col-md-4">
                            <label for="">Estado</label>
                            <select name="estado" id="edit_estado" class="form-select form-select-sm" required>
                                <option value="">---Seleccione---</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Inhabilitado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Empresa</label>
                            <select name="empresa" id="edit_empresa" class="form-select form-select-sm" required>
                                <option value="">---SeleccioneEmpresa---</option>
                                @foreach ($empresas as $emp)
                                    <option value="{{$emp->id}}">{{$emp->nombre}}</option>
                                @endforeach
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

{{-- Modal Empresas --}}
{{-- <div class="modal fade" id="modalEmpresas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Empresas donde Trabajó</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmEmpresaTrabajador" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="id_trabajador_empresa" name="id_trabajador_empresa" hidden>
                            <label for="">Seleccione Empresa</label>
                            <select name="empresa_registrado" id="empresa_registrado" class="form-select form-select-sm" required>
                                <option value="">---Seleccione---</option>
                                @foreach ($empresas as $emp)
                                    <option value="{{$emp->id}}">{{$emp->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row" style="justify-content: center">
                        <button class="btn btn-light btn-sm" style="width: 25%" onclick="btnRegistrarEmpresaTrabajador(event)" ><i class="fas fa-plus"></i> Registrar Empresa</button>
                    </div>
                    
                    <br>
                    <table id="tdEmpresasTrabajador" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>empresa</th>
                                <th>actual_empresa</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div> --}}

@include('messages.confirmacion_eliminar')

@endsection

@section('js')
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
        
        $(document).ready(function() {
            $('#dttrabajadores').DataTable({
                "order": [[ 0, "desc" ]] // Ordena por la primera columna en orden descendente
            });
        });

        // function btnRegistrarEmpresaTrabajador(e) {
        //     e.preventDefault()
        //     ds=$("#frmEmpresaTrabajador").serialize();
        //     $.ajax({
        //         type: "POST",
        //         url: "/trabajadores/empresas/store",
        //         data: ds,
        //         dataType: "json",
        //         success: function (response) {
        //             alert(response.message)
        //             btnEmpresas($("#id_trabajador_empresa").val())
        //         }
        //     });
        // }

        function btnEditarTrabajador(id) {
            $.ajax({
                type: "GET",
                url: "/trabajadores/edit/"+id,
                dataType: "json",
                success: function (response) {

                    $("#id_trabajador").val(id);
                    $("#edit_documento").val(response.trabajador['documento']);
                    $("#edit_nombre").val(response.trabajador['nombre']);
                    $("#edit_apellido").val(response.trabajador['apellido']);
                    $("#edit_cargo").val(response.trabajador['cargo']);
                    $("#edit_estado").val(response.trabajador['estado']).change();
                    $("#edit_empresa").val(response.trabajador['empresa']).change();
                    $("#modalEditarTrabajador").modal("show");
                    
                }
            });
        }

        function btnEliminarTrabajador(id) {
            $("#id_registro_eliminar").val(id);
            ruta="{{route ('trabajadores.destroy')}}"
            $('#formEliminar').attr('action', ruta);
            $("#modalConfirmarEliminar").modal("show");

        }

        function btnNuevoTrabajador() {
            $("#modalNuevoTrabajador").modal("show");
        }

        function btnEmpresas(id_trabajador) {
            $("#id_trabajador_empresa").val(id_trabajador);

            $.ajax({
                type: "GET",
                url: "/trabajadores/empresas/"+id_trabajador,
                dataType: "json",
                success: function (response) {
                    $("#tdEmpresasTrabajador tbody").html("");
                    var estado = ""
                    response.forEach(element => {
                        if (element.estado==true) {
                            estado="<p style='color:green'>Habilitado</p>"
                        }else{
                            estado="<p style='color:red'>Inhabilitado</p>"
                        }
                        $("#tdEmpresasTrabajador").append("<tr>"+
                            "<td>"+ element.id +"</td>"+
                            "<td>"+ element.nombre_empresa +"</td>"+
                            "<td>"+ estado + "</td>"+
                            "</tr>")
                    });
                }
            });
            $("#modalEmpresas").modal("show");
        }

    </script>
@endsection