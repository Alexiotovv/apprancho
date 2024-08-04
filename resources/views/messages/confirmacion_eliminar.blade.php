<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación para Eliminar </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminar" action="" method="POST">@csrf
                <div class="modal-body">
                    <input type="text" id="id_registro_eliminar" name="id_registro_eliminar" hidden>
                    <p>Confirme por favor para poder eliminar</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-danger btn-sm" id="btnSiEliminar">Sí Eliminar</a>
                </div>

            </form>
        </div>
    </div>
</div>