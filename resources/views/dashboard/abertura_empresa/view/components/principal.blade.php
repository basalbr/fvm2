

<div class="col-xs-6">
    <div class="col-xs-12">
        <h3>Mensagens</h3>
    <div class="messages"
         data-reference="{{$aberturaEmpresa->getTable()}}"
         data-reference-id="{{$aberturaEmpresa->id}}"
         data-send-message-url="{{route('sendMessageAjax')}}"
         data-update-messages-url="{{route('updateMessagesAjax')}}">
        @include('dashboard.components.chat.messages',['messages'=>$aberturaEmpresa->messages()])
    </div>

    <form>
        <div class="form-group">
            <label for="mensagem">Mensagem</label>
            <textarea class="form-control" id="message"
                      placeholder="Digite sua mensagem..."></textarea>
        </div>
        <button class="btn-primary btn" id="send-message"><i class="fa fa-send"></i> Enviar mensagem</button>
    </form>
    </div>
</div>
<div class="col-xs-6">
    <div class="col-xs-12">
        <h3>Resumo</h3>
    </div>
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
    @if($aberturaEmpresa->ordemPagamento()->isPending())
        <div class="col-xs-12">
            <p class="alert alert-danger visible-lg visible-sm visible-xs visible-md animated shake">É necessário efetuar o pagamento do processo para que possamos abrir sua empresa.</p>
            <a href="" class="btn btn-success"><i class="fa fa-credit-card"></i>
                Clique para realizar o pagamento</a>
        </div>
    @endif

</div>
