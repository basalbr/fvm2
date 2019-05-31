<li role="presentation" class="{{!request('tab') || request('tab')=='pendentes' ? 'active' : ''}}">
    <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                class="fa fa-exclamation-circle"></i>
        Apurações pendentes <span class="badge">{{$qtdApuracoes}}</span></a>
</li>
<li role="presentation" class="{{request('tab')=='historico' ? 'active' : ''}}">
    <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab"><i class="fa fa-history"></i>
        Apurações concluídas</a>
</li>