@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">

        <br>
        <button class="btn btn-primary btn-sm" onclick="modalGenerarPlanilla()"><i class="fas fa-user-cog"></i> Registrar Planilla</button>
        @error('documento')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <br>
        <hr>
        <h5>Buscar Planillas</h5>
        {{-- <form action="" id="formBuscarPlanilla">@csrf --}}

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
                    <button type="submit" class="btn btn-primary btn-sm" onclick="btnBuscarPlanilla()"><i class="fas fa-search"></i> Buscar Planilla</button>
                </div>
                <div class="col-md-3">
                    <div id="check-found" hidden>
                        <button class="btn btn-success"><i class="fas fa-check"></i></button>
                    </div>
                    <div id="check-notfound" hidden>
                        <button class="btn btn-danger"><i class="fas fa-times"></i></button>    
                    </div>

                    <h5 id="mensaje"></h5>

                </div>
                

            </div>
        {{-- </form> --}}
        <br>
            <h5>Detalles Ticket</h5>
            <div class="row">
                <div class="col-md-2">
                    <div class="input-group">
                        <strong>Total</strong>
                        <p id="total"> </p>
                    </div>

                </div>
                <div class="col-md-2">
                    <h5>Desayuno</h5>
                    <div class="input-group">
                        <img src="../../../assets/images/comprobado.png" width="20px">
                        <strong style="padding-left: 5px"> Recogidos</strong>
                        <p id="desayunoRecogidos"></p>
                    </div>
                    <div class="input-group">
                        <img src="../../../assets/images/food-empty.png" width="20px">
                        <strong style="padding-left: 5px"> Pendientes</strong>
                        <p id="desayunoPendientes"></p>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Almuerzo</h5>
                    <div class="input-group">
                        <img src="../../../assets/images/comprobado.png" width="20px">
                        <strong style="padding-left: 5px"> Recogidos</strong>
                        <p id="almuerzoRecogidos"></p>
                    </div>
                    <div class="input-group">
                        <img src="../../../assets/images/food-empty.png" width="20px">
                        <strong style="padding-left: 5px"> Pendientes</strong>
                        <p id="almuerzoPendientes"></p>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <h5>Cena</h5>
                    <div class="input-group">
                        <img src="../../../assets/images/comprobado.png" width="20px">
                        <strong style="padding-left: 5px"> Recogidos</strong>
                        <p id="cenaRecogidos"></p>
                    </div>
                    <div class="input-group">
                        <img src="../../../assets/images/food-empty.png" width="20px">
                        <strong style="padding-left: 5px"> Pendientes</strong>
                        <p id="cenaPendientes"></p>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Area</h5>
                    <strong id="area"></strong>
                    <h5>Proveedor</h5>
                    <strong id="proveedor"></strong>
                </div>
            </div>
            <div class="table-responsive">
                <br>
                <table id="dtplanillas" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>N°</th>
                            <th>Doc.Identidad</th>
                            <th>Nombre Completo</th>
                            <th>Cargo</th>
                            <th>Desayuno
                                <i class="fas fa-barcode"></i>
                                <input type="text" class="form-control form-control-sm" id="txtdesayuno" onkeypress="buscarCodigo(event,'desayuno',this)">
                            </th>
                            <th>Almuerzo
                                <i class="fas fa-barcode"></i>
                                <input type="text" class="form-control form-control-sm" id="txtalmuerzo" onkeypress="buscarCodigo(event,'almuerzo',this)">
                            </th>
                            <th>Cena
                                <i class="fas fa-barcode" style="width: 50px"></i>
                                <input type="text" class="form-control form-control-sm" id="txtcena" onkeypress="buscarCodigo(event,'cena',this)">
                            </th>
                            {{-- <th>Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>

<img src="" alt="">
    </div>
</div>

{{-- Generar PLanitllas --}}
<div class="modal fade" id="modalGenerarPlanilla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Planilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Generar Planillas</h5>
                <form id="frmGenerarPlanilla" action="" method="POST">@csrf
                    <div class="row">
                        <div class="col-md-3">
                            Seleccione una Fecha
                            <input type="date" name="fecha_planilla" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3">
                            Seleccione una Empresa
                            <select name="empresa_id" id="empresa_id" class="form-control form-control-sm" required>
                                <option value="">---Seleccione---</option>
                                @foreach ($empresas as $emp)
                                    <option value="{{$emp->id}}">{{$emp->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            Seleccione un Proveedor
                            <select name="proveedor" id="proveedor" class="form-control form-control-sm" required>
                                <option value="">---Seleccione---</option>
                                @foreach ($proveedores as $pro)
                                    <option value="{{$pro->id}}">{{$pro->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            Ingrese un Área
                            <input type="text" name="area" class="form-control form-control-sm" maxlength="250" required>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <button type="submit" class="btn btn-primary btn-sm" onclick="btnGenerarPlanilla(event)"><i class="fab fa-whmcs"></i> Generar Planilla</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- Agregar Trabajador a Planilla --}}
{{-- <div class="modal fade" id="modalAgregarTrabajadorPlanilla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Trabajador Planilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Seleccione un Trabajador</h5>
                <div class="row">
                    <div class="col-md-12">
                        Trabajadores
                        <table id="dtTrabajadores" class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Agregar</th>
                                    <th>Nombre Completo</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <br>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


@include('messages.confirmacion_eliminar')

@endsection

@section('js')
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
        

        function buscarCodigo(e,comida,element) {
            

            if (e.key==="Enter"||e.KeyCode===13) {
                e.preventDefault();
                let codigo = $(element).val() 
                let fecha=$("#buscar_fecha_planilla").val()
                $.ajax({
                    type: "GET",
                    url: "/planillas/checkcomida/"+ codigo +"/"+ comida+"/"+fecha,
                    dataType: "json",
                    success: function (response) {
                        btnBuscarPlanilla()
                        $(element).val("");
                        setTimeout(function() {
                            $(element).focus(); // Coloca el cursor en el campo de entrada
                        }, 1300); // Retraso de 0 milisegundos
                        
                        $("#check-notfound").attr("hidden", true);
                        $("#check-found").attr("hidden",false)
                        $("#mensaje").text(response.message)
                    },
                    error: function(xhr, status, error) {
                        // Maneja los errores en general
                        if (xhr.status === 409) {
                            let mensajeError = xhr.responseJSON.message;
                            $("#check-notfound").attr("hidden", false);
                            $("#check-found").attr("hidden",true)
                            $("#mensaje").text(mensajeError);
                            $(element).val("");
                            setTimeout(function() {
                                $(element).focus(); // Coloca el cursor en el campo de entrada
                            }, 1300);
                        } else if(xhr.status === 404) {
                            let mensajeError = xhr.responseJSON.message;
                            $("#check-notfound").attr("hidden", false);
                            $("#check-found").attr("hidden",true)
                            $("#mensaje").text(mensajeError);
                            $(element).val("");
                            setTimeout(function() {
                                $(element).focus(); // Coloca el cursor en el campo de entrada
                            }, 1300);
                        }else{
                            console.log('Otro error:', xhr.status, error);
                        }
                    }
                });
                
            }

        }

        function modalGenerarPlanilla() {
            $("#modalGenerarPlanilla").modal("show");    
        }

        function btnGenerarPlanilla(e) {
            e.preventDefault();
            const form = $('#frmGenerarPlanilla')[0];
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            ds = $("#frmGenerarPlanilla").serialize();
            $.ajax({
                type: "POST",
                url: "/planillas/store",
                data: ds,
                dataType: "json",
                success: function (response) {
                    alert(response.message);
                }
            });
            $("#modalGenerarPlanilla").modal("hide");
        }


        var isInitialized = false;

        function btnBuscarPlanilla() {
            var scrollPosition = $(window).scrollTop(); // Guarda la posición actual del scroll

            if (isInitialized) {
                $('#dtplanillas').DataTable().clear().destroy();  // Solo destruye la instancia existente
            }

            fecha = $("#buscar_fecha_planilla").val();
            empresa = $("#buscar_empresa").val();
            $.ajax({
                type: "GET",
                url: "/planillas/show/" + fecha + "/" + empresa,
                dataType: "json",
                success: function (response) {
                    $("#dtplanillas tbody").html(""); // Limpia los datos existentes en la tabla manualmente

                    let numero = 0;
                    if (response.data.length > 0) {
                        response.data.forEach(element => {
                            numero += 1;
                            let desayuno = element.desayuno ? "checked" : "";
                            let almuerzo = element.almuerzo ? "checked" : "";
                            let cena = element.cena ? "checked" : "";

                            let icon_desayuno="<img src='../../../assets/images/food-empty.png' width='25px'>";
                            let icon_almuerzo="<img src='../../../assets/images/food-empty.png' width='25px'>";
                            let icon_cena="<img src='../../../assets/images/food-empty.png' width='25px'>";

                            if (element.desayuno) {
                                icon_desayuno="<img src='../../../assets/images/comprobado.png' width='25px'>";
                            }
                            if(element.almuerzo){
                                icon_almuerzo="<img src='../../../assets/images/comprobado.png' width='25px'>";
                            }
                            if(element.cena){
                                icon_cena="<img src='../../../assets/images/comprobado.png' width='25px'>";
                            }


                            $("#dtplanillas tbody").append(
                                "<tr>" +
                                "<td>" + element.id + "</td>" +
                                "<td>" + numero + "</td>" +
                                "<td>" + element.documento + "</td>" +
                                "<td>" + element.apellido + " " + element.nombre + "</td>" +
                                "<td>" + element.cargo + "</td>" +
                                "<td>" +
                                    "<div class='form-check form-switch'>" +
                                        "<input class='form-check-input chkdesayuno' type='checkbox' onclick='cambia_estado(this, \"desayuno\")' id='desayuno' " + desayuno + ">" +
                                        icon_desayuno+
                                    "</div>" +
                                "</td>" +
                                "<td>" + 
                                    "<div class='form-check form-switch'>" +
                                        "<input class='form-check-input chkalmuerzo' type='checkbox' onclick='cambia_estado(this, \"almuerzo\")' id='almuerzo' " + almuerzo + ">" +
                                        icon_almuerzo+
                                    "</div>" +
                                "</td>" +
                                "<td>" + 
                                    "<div class='form-check form-switch'>" +
                                        "<input class='form-check-input chkcena' type='checkbox' onclick='cambia_estado(this, \"cena\")' id='cena' " + cena + ">" +
                                        icon_cena+
                                    "</div>" +
                                "</td>" +
                                "</tr>"
                            );
                        });

                        // Inicializa el DataTable
                        $('#dtplanillas').DataTable({
                            "language": {
                            "search": "Buscar:", // Cambia "Search" por "Buscar" o la palabra que desees
                            // Puedes cambiar otras cadenas de texto también, como las de paginación
                            },
                            "order": [[0, "asc"]], // Ordena por la primera columna en orden ascendente
                            "pageLength": 200,
                            "columnDefs": [
                                {
                                    "targets": 0, // Índice de la columna que quieres ocultar (0 es la primera columna)
                                    "visible": false // Oculta la columna
                                }
                            ]
                        });

                        isInitialized = true; // Marca como inicializada

                        $("#total").text(": "+numero);
                        
                        $("#desayunoRecogidos").text(": "+response.desayuno_recogido);
                        $("#desayunoPendientes").text(": " + (numero-(response.desayuno_recogido)));
                        
                        $("#almuerzoRecogidos").text(": "+response.almuerzo_recogido);
                        $("#almuerzoPendientes").text(": " + (numero-(response.almuerzo_recogido)));
                        
                        $("#cenaRecogidos").text(": "+response.cena_recogido);
                        $("#cenaPendientes").text(": " + (numero-(response.cena_recogido)));
                        

                        $(window).scrollTop(scrollPosition); // Restaura la posición del scroll
                        $("#area").text(response.area);
                        $("#proveedor").text(response.proveedor);

                    } else {
                        alert(response.message);
                    }
                }
            });
        }


        function cambia_estado(elemento,comida) {
            // fila = $(elemento).closest("tr");
            // id = (fila).find('td:eq(0)').text();
            fila = $(elemento).closest("tr");
            var table = $('#dtplanillas').DataTable();
            var datosFila = table.row(fila).data();
            id = datosFila[0];

            if ($(elemento).prop('checked')){ 
                estado=1; 
            } else { 
                estado=0; 
            }
            console.log(id)
            $.ajax({
                type: "GET",
                url: "/planillas/checkestado/"+id+"/"+comida+"/"+estado,
                dataType: "json",
                success: function (response) {
                    btnBuscarPlanilla();
                }
            });
        }

    </script>
@endsection