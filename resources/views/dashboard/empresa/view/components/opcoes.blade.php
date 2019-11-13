@if($empresa->anexos()->where('descricao', $descricao)->count() > 0)
    @include('dashboard.empresa.view.components.visualizar_remover', ['id_referencia'=>$empresa->id, 'anexo'=>$empresa->anexos()->where('descricao', $descricao)->first()])
@else
    @include('dashboard.empresa.view.components.anexar', ['descricao'=>$descricao])
@endif