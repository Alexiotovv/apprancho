@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">

        <br>
       
        <h5>Buscar Planillas</h5>
        <form action="{{route('planillas.ticket')}}" method="POST">@csrf

            <div class="row">
                <div class="col-md-3">
                    Seleccione una Fecha
                    <input type="date" name="buscar_fecha_planilla" id="buscar_fecha_planilla" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    Seleccione una Empresa
                    <select name="buscar_empresa" id="buscar_empresa" class="form-control form-control-sm" required>
                        <option value="">---Seleccione---</option>
                        @foreach ($empresas as $emp)
                        <option value="{{$emp->id}}">{{$emp->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">Buscar</label>
                    <br>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Visualizar Tickets</button>
                </div>
                <div class="col-md-3">
                    <p>En construcción.......</p>
                    <label for="">Enviar al whatsapp</label>
                    <br>
                    <button type="button" class="btn btn-light btn-sm"><i class="fab fa-whatsapp"></i> Enviar al Whatsapp</button>
                    <br>
                    <br>
                    <label for="">Enviar al correo</label>
                    <br>
                    <button type="button" class="btn btn-light btn-sm"><i class="fas fa-mail-bulk"></i> Enviar al Correo</button>
                </div>
                

            </div>
        </form>


    </div>
</div>


@endsection

@section('js')
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>


@endsection