<li role="presentation" class="{{!request('tab') || request('tab')=='ativas' ? 'active' : ''}}">
    <a href="#ativas" aria-controls="ativas" role="tab" data-toggle="tab"><i class="fa fa-check"></i>Empresas ativas</a>
</li>
<li role="presentation" class="{{request('tab')=='pendentes' ? 'active' : ''}}">
    <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i class="fa fa-hourglass-1"></i>Empresas em análise</a>
</li>