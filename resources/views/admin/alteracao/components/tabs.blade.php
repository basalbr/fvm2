<li role="presentation" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}}">
    <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                class="fa fa-exclamation-circle"></i>
        Solicitações pendentes <span class="badge">{{$alteracoesPendentes->count()}}</span></a>
</li>
<li role="presentation" class="{{request('tab')=='historico' ? 'active' : ''}}">
    <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
        Solicitações concluídas</a>
</li>