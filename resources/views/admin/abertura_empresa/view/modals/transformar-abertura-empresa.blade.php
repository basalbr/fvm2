<div class="modal animated fadeIn" id="modal-transformar-abertura-empresa" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Transformar em empresa</h3>
            </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja transformar esse processo em uma empresa?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('createEmpresaFromAberturaEmpresa', $aberturaEmpresa->id)}}" class="btn btn-success">Sim, transformar</a>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                </div>
        </div>
    </div>
</div>
