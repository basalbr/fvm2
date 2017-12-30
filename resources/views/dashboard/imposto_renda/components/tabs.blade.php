<li role="presentation" class="active">
    <a href="#pendentes" aria-controls="pendentes" role="tab" data-toggle="tab"><i
                class="fa fa-exclamation-circle"></i>
        Pendentes <span class="badge">{{$irPendentes->count()}}</span></a>
</li>
<li role="presentation">
    <a href="#concluidas" aria-controls="concluidas" role="tab" data-toggle="tab"><i class="fa fa-check"></i>
        Concluídas <span class="badge">{{$irConcluidos->count()}}</span></a>
</li>