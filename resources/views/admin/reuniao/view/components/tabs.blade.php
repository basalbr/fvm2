<li role="presentation" class="active">
    <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                class="fa fa-info-circle"></i>
        Informações/Status</a>
</li>
<li role="presentation">
    <a href="#messages" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
        Mensagens <span
                class="badge">{{$reuniao->getQtdeMensagensNaoLidasAdmin()}}</span></a>
</li>
<li role="presentation">
    <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
        Documentos enviados</a>
</li>
