<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#tab-geral" aria-controls="tab-geral" role="tab" data-toggle="tab"><i class="fa fa-info"></i>
            Geral</a>
    </li>
    <li role="presentation">
        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
            Mensagens <span
                    class="badge">{{$ir->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
    </li>
    @if($ir->recibo)
        <li class="animated bounceInDown highlight">
            <a href="{{asset(public_path().'storage/anexos/imposto_renda/'.$ir->id.'/'. $ir->recibo)}}"
               download><i class="fa fa-download"></i> Recibo</a>
        </li>
    @endif
    @if($ir->declaracao)
        <li class="animated bounceInDown highlight">
            <a href="{{asset(public_path().'storage/anexos/imposto_renda/'.$ir->id.'/'. $ir->declaracao)}}"
               download><i class="fa fa-download"></i> Declaração</a>
        </li>
    @endif
</ul>