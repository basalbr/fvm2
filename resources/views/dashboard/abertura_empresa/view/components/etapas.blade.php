<div class="steps clearfix">
    <ul role="tablist">
        <li role="tab" class="first {{$aberturaEmpresa->getEtapa()=='pendente' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Pedido Enviado</a>
        </li>
        <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='pedido_inicial' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Em Análise</a></li>

        <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='viabilidade' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Viabilidade</a></li>

        <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='dbe' ? 'current':''}}"><a href="#"><span
                        class="number">{{$step++}}</span>DBE</a></li>

        <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='requerimento' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Requerimento</a></li>

        <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='alvara' ? 'current':''}}"><a href="#"><span
                        class="number">{{$step++}}</span>Alvará</a></li>
        @if($aberturaEmpresa->is_comercio || $aberturaEmpresa->is_industria)
            <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='inscricao_estadual' ? 'current':''}}"><a
                        href="#"><span
                            class="number">{{$step++}}</span>Inscrição Estadual</a></li>
        @endif
        <li role="tab" class="{{$aberturaEmpresa->getEtapa()=='simples_nacional' ? 'current':''}}"><a
                    href="#"><span class="number">{{$step++}}</span>Simples Nacional</a></li>

        @if($aberturaEmpresa->getEtapa()=='cancelado')
            <li role="tab" class="last {{$aberturaEmpresa->getEtapa()=='cancelado' ? 'current':''}}"><a
                        href="#"><span class="number">{{$step++}}</span>Cancelado</a></li>
        @else
            <li role="tab" class="last {{$aberturaEmpresa->getEtapa()=='concluido' ? 'current':''}}"><a
                        href="#"><span class="number">{{$step++}}</span>Concluído</a></li>
        @endif
    </ul>
</div>