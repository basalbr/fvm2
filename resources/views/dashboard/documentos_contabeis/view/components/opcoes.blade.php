@if($processo->anexos()->where('descricao', $descricao)->count() > 0)
    @include('dashboard.documentos_contabeis.view.components.visualizar_remover', ['id_referencia'=>$processo->id, 'anexo'=>$processo->anexos()->where('descricao', $descricao)->first()])
@else
    @include('dashboard.documentos_contabeis.view.components.anexar', ['descricao'=>$descricao])
@endif