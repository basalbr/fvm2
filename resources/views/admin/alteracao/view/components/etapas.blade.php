<ul class="list-group">
    <li class="list-group-item list-group-item-info"><strong>Pedido inicial</strong></li>
    <li class="list-group-item {{$alteracao->status == 'pedido_inicial_em_analise' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'pedido_inicial_em_analise'])}}">Em análise</a></li>
    <li class="list-group-item {{$alteracao->status == 'pedido_inicial_aguardando_usuario' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'pedido_inicial_aguardando_usuario'])}}">Aguardando informações do usuário</a></li>
    <li class="list-group-item list-group-item-info"><strong>Viabilidade</strong></li>
    <li class="list-group-item {{$alteracao->status == 'viabilidade_em_analise' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'viabilidade_em_analise'])}}">Em análise pela JUCESC</a></li>
    <li class="list-group-item {{$alteracao->status == 'viabilidade_aguardando_usuario' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'viabilidade_aguardando_usuario'])}}">Aguardando informações do usuário</a></li>
    <li class="list-group-item list-group-item-info"><strong>DBE</strong></li>
    <li class="list-group-item {{$alteracao->status == 'dbe_em_analise' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'dbe_em_analise'])}}">Em análise pela Receita Federal</a></li>
    <li class="list-group-item {{$alteracao->status == 'dbe_aguardando_usuario' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'dbe_aguardando_usuario'])}}">Aguardando informações do usuário</a></li>
    <li class="list-group-item list-group-item-info"><strong>Requerimento</strong></li>
    <li class="list-group-item {{$alteracao->status == 'requerimento_aguardando_protocolo' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'requerimento_aguardando_protocolo'])}}">Aguardando protocolo</a></li>
    <li class="list-group-item {{$alteracao->status == 'requerimento_em_analise' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'requerimento_em_analise'])}}">Em análise pela JUCESC</a></li>
    <li class="list-group-item {{$alteracao->status == 'requerimento_aguardando_usuario' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'requerimento_aguardando_usuario'])}}">Aguardando informações do usuário</a></li>
    <li class="list-group-item list-group-item-info"><strong>Alvará</strong></li>
    <li class="list-group-item {{$alteracao->status == 'alvara_aguardando_protocolo' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'alvara_aguardando_protocolo'])}}">Aguardando protocolo</a></li>
    <li class="list-group-item {{$alteracao->status == 'alvara_em_analise' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'alvara_em_analise'])}}">Em análise pela prefeitura</a></li>
    <li class="list-group-item {{$alteracao->status == 'alvara_aguardando_pagamento' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'alvara_aguardando_pagamento'])}}">Aguardando o pagamento das taxas</a></li>
    <li class="list-group-item {{$alteracao->status == 'alvara_aguardando_usuario' ? 'list-group-item-success' : ''}}"><a href="{{route('changeAlteracaoStatus',[$alteracao->id,'alvara_aguardando_usuario'])}}">Aguardando informações do usuário</a></li>
</ul>