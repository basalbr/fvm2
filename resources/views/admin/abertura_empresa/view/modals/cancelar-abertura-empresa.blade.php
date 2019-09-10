<div class="modal animated fadeIn" id="modal-cancelar-abertura-empresa" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cancelar abertura de empresa</h3>
            </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja cancelar essa abertura de empresa?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('changeAberturaEmpresaStatus',[$aberturaEmpresa->id,'cancelado'])}}" class="btn btn-danger">Sim, cancelar</a>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                </div>
        </div>
    </div>
</div>
