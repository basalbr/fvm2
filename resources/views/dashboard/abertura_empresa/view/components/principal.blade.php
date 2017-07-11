@if($aberturaEmpresa->ordemPagamento->isPending())
    <div class="col-xs-12">
        <p class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">É necessário efetuar o
            pagamento do processo para que possamos abrir sua empresa.</p>
    </div>
@endif
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Nome preferencial</label>
        <div class="form-control">{{$aberturaEmpresa->nome_empresarial1}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Sócio principal</label>
        <div class="form-control">{{$aberturaEmpresa->getSocioPrincipal()->nome}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Status do processo</label>
        <div class="form-control">{{$aberturaEmpresa->status}}</div>
    </div>
</div>
<div class="col-xs-12">
    <div class="form-group">
        <label for="">Status do pagamento</label>
        <div class="form-control">Pagamento {{$aberturaEmpresa->getPaymentStatus()}}</div>
    </div>
</div>
@if($aberturaEmpresa->ordemPagamento->isPending())
    <div class="col-xs-12">
        <a href="{{$aberturaEmpresa->ordemPagamento->getBotaoPagamento()}}" class="btn btn-success"><i class="fa fa-credit-card"></i>
            Clique para realizar o pagamento</a>
    </div>
@endif

