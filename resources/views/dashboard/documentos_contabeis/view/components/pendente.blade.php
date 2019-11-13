<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                    class="fa fa-info-circle"></i>
            Informações / Enviar documentos</a>
    </li>
    <li role="presentation">
        <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
            Mensagens <span
                    class="badge">{{$processo->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">

    <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
        <div class="col-sm-12">
            <p class="alert alert-info animated bounceIn" style="display: block"><strong>Tudo
                    bem {{Auth::user()->nome}}?</strong><br/>
                Nesse local é onde você vai enviar documentos como: <strong>extratos bancários, recibos e todas
                    as despesas relacionadas à empresa {{$processo->empresa->razao_social}}</strong>, bem como
                demais comprovantes de
                pagamento do mês {{$processo->periodo->format('m/Y')}}.<br/>Após enviar todos os
                documentos, clique no botão <strong>CONCLUIR</strong> que está na parte inferior da tela.<br/>
                Se não tiver nenhum documento para enviar, clique no botão <strong>SEM MOVIMENTO</strong> que está
                na parte inferior da tela</p>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Empresa</label>
                <div class="form-control">{{$processo->empresa->nome_fantasia}}</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Status</label>
                <div class="form-control">{{$processo->getStatus()}}</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Competência</label>
                <div class="form-control">{{$processo->periodo->format('m/Y')}}</div>
            </div>
        </div>
        <div class="clearfix"></div>

        @if($processo->isPending())
            <div class="col-sm-12">
                @include('dashboard.documentos_contabeis.view.components.enviar_arquivos')
            </div>
            <div class="clearfix"></div>
        @endif

    </div>
    <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
        @include('dashboard.components.chat.box', ['model'=>$processo])
        <div class="clearfix"></div>
    </div>
</div>