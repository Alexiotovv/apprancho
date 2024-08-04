@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">
        @if(session()->has('error'))
            <div class="col-sm-4">
                <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-danger"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-danger">Mensaje</h6>
                            <div>{{Session::get('error')}}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session()->has('mensaje'))
            <div class="col-sm-4">
                <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-success">Mensaje</h6>
                            <div>{{Session::get('mensaje')}}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif


        {{-- <div class="col-sm-12" style="text-align: -webkit-right">
            
        </div> --}}
        <br>

        <h5>Lista de Usuarios</h5>
        <a class="btn btn-primary btn-sm" id="btnNuevo" href="{{route('usuario.create')}}">Nuevo</a>
        <div class="table-responsive">
            <br>
            <table id="dtUsuarios" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $d)
                        <tr>
                            <td>{{$d->name}}</td>
                            <td>{{$d->email}}</td>
                            <td>
                                {{$d->role}}
                            </td>
                            <td>
                                @if ($d->status==1)
                                    <label for="" style="color: green">Activado</label>
                                @elseif ($d->status==0)
                                <label for="" style="color: rgb(83, 78, 73)28, 49, 0)">Desactivado</label>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{route('usuario.edit',$d->id)}}">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
         $(document).ready(function() {
        $('#dtUsuarios').DataTable();
    });
    </script>
@endsection