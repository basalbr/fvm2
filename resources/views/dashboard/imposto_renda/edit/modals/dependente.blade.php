<div class="modal animated fadeIn" id="modal-dependente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Dependente</h3>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                @include('dashboard.imposto_renda.edit.modals.components.tabs')

                <form class="form" method="POST" action="" data-id="" id="form-dependente"
                      data-validation-url="{{route('validateIrDependente')}}">
                {{csrf_field()}}

                <!-- Tab panes -->
                    <div class="tab-content">
                        @include('dashboard.components.form-alert')
                        @include('dashboard.components.disable-auto-complete')
                        <div class="clearfix"></div>
                        @include('dashboard.imposto_renda.edit.modals.components.tab-geral')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-rendimentos')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-recibos')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-doacoes')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-bens')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-dividas')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-outros')
                        @include('dashboard.imposto_renda.edit.modals.components.tab-documentos-enviados')
                        <div class="clearfix"></div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success"><i class="fa fa-check"></i> Adicionar dependente e documentos</button>
                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>
