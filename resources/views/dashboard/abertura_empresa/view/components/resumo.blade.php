<div class="col-xs-12">
    <h3>Processo de abertura de empresa para {{$aberturaEmpresa->nome_empresarial1}}</h3>
    <hr>
</div>

<div class="col-xs-6">
    <p>Caso tenha dúvidas, entre em contato conosco pelo chat abaixo.</p>
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
                      placeholder="Digite sua mensagem e clique em enviar que responderemos o mais breve possível"></textarea>
        </div>
        <button class="btn-primary btn" id="send-message"><i class="fa fa-send"></i> Enviar mensagem</button>
    </form>
</div>
<div class="col-xs-6 summary">

    <div class="description">Taxa de abertura de empresa: <span
                class="price">{{$aberturaEmpresa->ordemPagamento()->formattedValue()}}</span></div>
    <div class="description">Taxa de abertura de empresa: <span
                class="price">{{$aberturaEmpresa->ordemPagamento()->formattedValue()}}</span></div>
    <div class="description">Mensalidade após conclusão do processo: <span class="price"
                                                                           id="mensalidade">{{$aberturaEmpresa->getMonthlyPayment()}}</span>
    </div>
    <ul class="items">
        <li>Quantidade de funcionários: <span id="qtde-funcionarios">{{$aberturaEmpresa->qtde_funcionario}}</span></li>
        <li>Quantidade de sócios que retiram pró-labore: <span
                    id="qtde-pro-labores">{{$aberturaEmpresa->qtde_pro_labore}}</span></li>
        <li>Quantidade de documentos contábeis emitidos mensalmente: <span
                    id="qtde-documentos-contabeis">{{$aberturaEmpresa->qtde_documento_contabil}}</span></li>
        <li>Quantidade de documentos fiscais recebidos e emitidos mensalmente: <span
                    id="qtde-documentos-fiscais">{{$aberturaEmpresa->qtde_documento_fiscal}}</span></li>
    </ul>

</div>
