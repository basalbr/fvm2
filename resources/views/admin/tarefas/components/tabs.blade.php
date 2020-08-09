<li role="presentation" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}}">
    <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                class="fa fa-exclamation-circle"></i>
        Tarefas pendentes <span class="badge">{{$qtdPendentes}}</span></a>
</li>
<li role="presentation" class="{{request('tab')=='minhas' ? 'active' : ''}}">
    <a href="#minhas" aria-controls="minhas" role="tab" data-toggle="tab"><i class="fa fa-tasks"></i>
        Tarefas que criei</a>
</li>
<li role="presentation" class="{{request('tab')=='historico' ? 'active' : ''}}">
    <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
        Tarefas concluídas</a>
</li>