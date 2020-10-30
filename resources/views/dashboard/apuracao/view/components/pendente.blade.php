
<!-- Tab panes -->
<div class="col-sm-7">
    <ul class="nav nav-tabs nav-tabs-mini" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações / Enviar documentos</a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
            <div class="col-sm-12">
                <p class="alert alert-info animated bounceIn" style="display: block"><strong>ATENÇÃO</strong><br/>
                    Nesse local é onde você vai enviar os documentos fiscais
                    de <strong>{{$apuracao->competencia->format('m/Y')}}</strong> como: <strong>notas fiscais emitidas e de aquisição de
                        mercadorias e de serviços</strong> relacionadas à empresa {{$apuracao->empresa->razao_social}}.
                    <br/>Após enviar todos os
                    documentos, clique no botão <strong>CONCLUIR</strong> que está na parte inferior da tela.<br/>
                    Se não tiver nenhum documento para enviar, clique no botão <strong>SEM MOVIMENTO NESSE
                        PERÍODO</strong> que está
                    na parte inferior da tela</p>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Empresa</label>
                    <div class="form-control">{{$apuracao->empresa->nome_fantasia}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control">{!! $apuracao->getLabelStatus()!!}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Competência</label>
                    <div class="form-control">{{$apuracao->competencia->format('m/Y')}}</div>
                </div>
            </div>
            <div class="clearfix"></div>

            @if($apuracao->isPendingInfo())
                <div class="col-sm-12">
                    @include('dashboard.apuracao.view.components.enviar_arquivos')
                </div>
                <div class="clearfix"></div>
            @endif

        </div>
    </div>
</div>
<div class="col-sm-5">
    <div class="panel panel-primary">
        <div class="panel-heading">Mensagens <span
                    class="badge">{{$apuracao->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></div>
        <div class="panel-body" id="messages">
            @include('dashboard.components.chat.box2', ['model'=>$apuracao, 'lock_anexo'=>false])</div>
    </div>
</div>