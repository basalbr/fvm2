<div class="modal animated fadeIn" id="modal-concluir-abertura-empresa" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Concluir abertura de empresa</h3>
            </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja concluir essa abertura de empresa?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('changeAberturaEmpresaStatus',[$aberturaEmpresa->id,'concluido'])}}" class="btn btn-success">Sim, concluir</a>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                </div>
        </div>
    </div>
</div>
