<li role="presentation" class="active">
    <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
        Mensagens <span
                class="badge">{{$chamado->mensagens()->where('lida','=',0)->where('from_admin','=',0)->count()}}</span></a>
</li>
<li role="presentation">
    <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
        Documentos enviados</a>
</li>