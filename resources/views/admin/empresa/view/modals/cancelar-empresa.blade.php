<div class="modal animated fadeIn" id="modal-cancelar-empresa" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cancelar empresa</h3>
            </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja desativar essa empresa?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('deactivateEmpresa', $empresa->id)}}" class="btn btn-danger">Sim, desative</a>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                </div>
        </div>
    </div>
</div>
