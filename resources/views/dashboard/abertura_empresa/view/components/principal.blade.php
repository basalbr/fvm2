@if($aberturaEmpresa->ordemPagamento->isPending())
    <div class="col-xs-12">
        <div class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">
            <p><strong>Atenção!</strong> É necessário efetuar o pagamento do processo para que possamos iniciar o
                processo de abertura de empresa. Caso tenha alguma dúvida com relação ao processo de abertura basta
                clicar na aba de 'Mensagens' para interagir com nossa equipe.</p>
            <br/>
            <div class="text-right">
                <a href="{{$aberturaEmpresa->ordemPagamento->getBotaoPagamento()}}" class="btn btn-warning">
                    Realizar pagamento</a>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
@endif
<div class="col-xs-12 hidden-xs">
    <div class="form-group">
        <label for="">Andamento do Processo</label>
        <div class="form-control">
            @include('dashboard.abertura_empresa.view.components.etapas')
        </div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Status do Processo</label>
        <div class="form-control">{{$aberturaEmpresa->getDescricaoEtapa()}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Razão Social</label>
        <div class="form-control">{{$aberturaEmpresa->nome_empresarial1}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Nome Fantasia</label>
        <div class="form-control">{{$aberturaEmpresa->nome_empresarial2}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Sócio principal</label>
        <div class="form-control">{{$aberturaEmpresa->getSocioPrincipal()->nome}}</div>
    </div>
</div>
