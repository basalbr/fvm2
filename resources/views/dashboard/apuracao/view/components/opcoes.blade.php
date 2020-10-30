@if($apuracao->anexos()->where('descricao', $descricao)->count() > 0)
    @include('dashboard.apuracao.view.components.visualizar_remover', ['id_referencia'=>$apuracao->id, 'anexo'=>$apuracao->anexos()->where('descricao', $descricao)->first()])
@else
    @include('dashboard.apuracao.view.components.anexar', ['descricao'=>$descricao])
@endif