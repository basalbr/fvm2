<li role="presentation" class="{{!request('tab') || request('tab')=='ativos' ? 'active' : ''}}">
    <a href="#ativos" aria-controls="ativos" role="tab" data-toggle="tab"><i
                class="fa fa-users"></i>
        Funcionários</a>
</li>
<li role="presentation" class="{{request('tab')=='pendentes' ? 'active' : ''}}">
    <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i class="fa fa-exclamation-circle"></i>
        Funcionários Pendentes  <span class="badge">{{$funcionariosPendentes->count()}}</span></a>
</li>