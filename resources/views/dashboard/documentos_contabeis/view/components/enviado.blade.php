<div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Informações e documentos enviados</strong></div>
        <div class="panel-body">
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">
                @include('dashboard.documentos_contabeis.view.components.informacoes')
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>Mensagens</strong></div>
        <div class="panel-body" id="messages">
            @include('dashboard.components.chat.box2', ['model'=>$processo, 'lock_anexo'=>true])</div>
    </div>
</div>