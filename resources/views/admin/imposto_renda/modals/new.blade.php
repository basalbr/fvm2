<div class="modal animated fadeIn" id="modal-imposto-renda" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nova declaração de IR</h3>
            </div>
            <div class="modal-body">
                <div class="col-xs-12">
                    <div class="alert alert-info" style="display: block"><strong>Encontramos algumas pessoas vinculadas
                            à sua conta!</strong> clique em uma delas para iniciar a declaração.
                    </div>
                    @foreach($pessoas as $pessoa)
                        <a class="btn btn-primary">Utilizar os dados de <strong>{{$pessoa->nome}}</strong></a>
                        <div class="clearfix"></div>
                        <br />
                    @endforeach
                    <a class="btn btn-default"><strong>Não é nenhuma dessas?</strong> Clique aqui para continuar</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>
