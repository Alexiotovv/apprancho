@extends('bases.base')
@section('css')
    <style>
        #printableArea {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px;
        }
        .cabecera img {
            max-width: 100%;
            height: auto;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
<div class="card">
    <div class="card-body">

        <br>
       
        <div class="row">
            <div class="col-md-4">
                <h5>Impresion de Ticket</h5>
                <a href="{{route('planillas.ticket.index')}}" class="btn btn-light btn-sm"><i class="fas fa-caret-square-left"></i> Regresar</a>
            </div>
            <div class="col-md-4">
                <h5>Cantidad de Tickets</h5>
                <strong>{{$cantidad_tickets}}</strong>
            </div>

            
        </div>
        <div class="button-container">
            <button onclick="printDiv('printableArea')" class="btn btn-dark btn-sm"><i class="fas fa-print"></i> Imprimir Tickets</button>
        </div>
        <br>
        <div id="printableArea">
            <div class="row">
                @foreach ($planilla as $pla)
                    <div class="col-md-3">
                        <svg id="barcode-{{$pla->id}}"></svg> 
                        <p>{{$pla->nombre}} {{$pla->apellido}}</p>
                    </div>                    
                @endforeach
            </div>
        </div>
            

    </div>
</div>


@endsection

@section('js')
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
    $(document).ready(function() {
        // Iterar sobre cada registro en la planilla
        @foreach ($planilla as $pla)
            // Convertir el código a código de barras
            JsBarcode("#barcode-{{$pla->id}}", "{{$pla->codigo}}", {
                format: "CODE128", 
                width: 2, 
                height: 100, 
                displayValue: true
            });
        @endforeach
    });
</script>

<script>
   function printDiv(divId) {
    var divToPrint = $('#' + divId).html();
    var styles = `
        <link rel="stylesheet" href="../../../assets/css/style.css" id="main-style-link" >
        <link rel="stylesheet" href="../../../assets/css/style-preset.css" >
        <style>
            @media print {
                @page { size: A4; margin: 10mm; }
                body { margin: 0; }
                .row {
                    display: flex;
                    flex-wrap: wrap;
                }
                .col-md-3 {
                    flex: 0 0 25%; /* 25% del ancho para 4 columnas por fila */
                    max-width: 25%;
                }
            }
        </style>
    `;
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write(`
        <html>
        <head>
            <title>Print</title>
            ${styles}
        </head>
        <body onload="window.print();">
            ${divToPrint}
        </body>
        </html>
    `);
    newWin.document.close();

    newWin.focus();
    newWin.onafterprint = function() {
        newWin.close();
    };
}

</script>

@endsection