@if($ponto->isFinished())
    <div class="col-sm-12">
        <div class="alert alert-success" style="display: block">
            <strong>Processo concluído!</strong>
            <a href="{{route('showProcessoFolhaToUser', $ponto->getProcesso()->id)}}"> Clique para ver os recibos <i
                        class="fa fa-external-link"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
@endif
<div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Informações</strong></div>
        <div class="panel-body">
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                @include('dashboard.ponto.view.components.informacoes')
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Mensagens</strong></div>
        <div class="panel-body" id="messages">
            @if(in_array($ponto->status, ['concluido']))
                @include('dashboard.components.chat.box2', ['model'=>$ponto, 'lock_anexo'=>true])
            @else
                @include('dashboard.components.chat.box2', ['model'=>$ponto, 'lock_anexo'=>false])
            @endif
        </div>
    </div>
</div>
<div class="clearfix"></div>