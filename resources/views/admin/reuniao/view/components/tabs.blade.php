<li role="presentation" class="active">
    <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                class="fa fa-info-circle"></i>
        Informações/Status</a>
</li>
<li role="presentation">
    <a href="#messages" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
        Mensagens <span
                class="badge">{{$recalculo->qtdeMensagensNaoLidas(true)}}</span></a>
</li>
<li role="presentation">
    <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
        Documentos enviados</a>
</li>
@if($recalculo->guia)
    <li class="animated bounceInDown highlight">
        <a href="{{asset(public_path().'storage/'. $recalculo->getTable() . '/'.$recalculo->id . '/' . $recalculo->guia)}}"
           download><i class="fa fa-download"></i> Guia</a>
    </li>
@endif