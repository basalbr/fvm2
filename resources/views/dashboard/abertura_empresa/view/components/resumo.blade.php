<div class="col-xs-12">
    <h3>Processo de abertura de empresa para {{$aberturaEmpresa->nome_empresarial1}}</h3>
    <hr>
</div>

<div class="col-xs-6">
<p>Caso tenha dúvidas, entre em contato conosco pelo chat abaixo.</p>
    <div class="messages">
@if(2==1)
        <div class="message">
            <div class="thumb">
                <img src="{{url(public_path().'/images/thumb.jpg')}}"/>
            </div>
            <div class="text">
                <p><strong>Cliente - 13/05/17 22:11</strong></p>
                <p>Então, eu gostaria de comprar um abacaxi</p>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="message from-admin">
            <div class="thumb">
                <img src="{{url(public_path().'/images/thumb.jpg')}}"/>
            </div>
            <div class="text">
                <p><strong>Admin - 13/05/17 22:15</strong></p>
                <p>Legal, podemos vender um pra voce!</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="message">
            <div class="thumb">
                <img src="{{url(public_path().'/images/thumb.jpg')}}"/>
            </div>
            <div class="text">
                <p><strong>Cliente - 13/05/17 22:11</strong></p>
                <p>Então, eu gostaria de comprar um abacaxi</p>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="message from-admin">
            <div class="thumb">
                <img src="{{url(public_path().'/images/thumb.jpg')}}"/>
            </div>
            <div class="text">
                <p><strong>Admin - 13/05/17 22:15</strong></p>
                <p>Legal, podemos vender um pra voce!</p>
            </div>
        </div>
    @else
        <div class="no-messages">Nenhuma mensagem enviada ou recebida</div>
        @endif
    </div>

    <form>
        <div class="form-group">
            <label for="mensagem">Mensagem</label>
            <textarea class="form-control" name="mensagem"
                      placeholder="Digite sua mensagem e clique em enviar que responderemos o mais breve possível"></textarea>
        </div>
        <button class="btn-primary btn"><i class="fa fa-send"></i> Enviar mensagem</button>
    </form>
</div>
<div class="col-xs-6 summary">

    <div class="description">Taxa de abertura de empresa: <span class="price">{{$aberturaEmpresa->ordemPagamento()->formattedValue()}}</span></div>
    <div class="description">Taxa de abertura de empresa: <span class="price">{{$aberturaEmpresa->ordemPagamento()->formattedValue()}}</span></div>
    <div class="description">Mensalidade após conclusão do processo: <span class="price" id="mensalidade">{{$aberturaEmpresa->getMonthlyPayment()}}</span>
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
