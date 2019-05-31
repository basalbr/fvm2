<div class="steps clearfix">
    <ul role="tablist">
        <li role="tab" class="first {{$alteracao->getEtapa()=='pendente' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Pedido Enviado</a>
        </li>
        <li role="tab" class="{{$alteracao->getEtapa()=='pedido_inicial' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Em Análise</a></li>

        <li role="tab" class="{{$alteracao->getEtapa()=='viabilidade' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Viabilidade</a></li>

        <li role="tab" class="{{$alteracao->getEtapa()=='dbe' ? 'current':''}}"><a href="#"><span
                        class="number">{{$step++}}</span>DBE</a></li>

        <li role="tab" class="{{$alteracao->getEtapa()=='requerimento' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Requerimento</a></li>

        <li role="tab" class="{{$alteracao->getEtapa()=='alvara' ? 'current':''}}"><a href="#"><span
                        class="number">{{$step++}}</span>Prefeitura</a></li>

        @if($alteracao->getEtapa()=='cancelado')
            <li role="tab" class="last {{$alteracao->getEtapa()=='cancelado' ? 'current':''}}"><a
                        href="#"><span class="number">{{$step++}}</span>Cancelado</a></li>
        @else
            <li role="tab" class="last {{$alteracao->getEtapa()=='concluido' ? 'current':''}}"><a
                        href="#"><span class="number">{{$step++}}</span>Concluído</a></li>
        @endif
    </ul>
</div>