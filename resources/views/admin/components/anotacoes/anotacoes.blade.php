@if(count($anotacoes))
    @foreach($anotacoes as $anotacao)
        <div class="anotacao animated fadeIn">
            <div class="mensagem">{{$anotacao->mensagem}}</div>
            <div class="quem">{{$anotacao->usuario->nome}} - {{$anotacao->created_at->format('d.m.Y H:i')}}</div>
        </div>
    @endforeach
@else
    <div class="no-messages">Nenhuma anotação encontrada</div>
@endif