@foreach($mensagens as $mensagem)
    @if($mensagem->from_admin)
        <div class="message from-admin animated fadeInRight">
            <div class="nome">{{$mensagem->usuario->nome}} - {{$mensagem->created_at->format('H:i')}}</div>
            {{$mensagem->mensagem}}
        </div>
    @else
        <div class="message animated fadeInLeft">
            <div class="nome">{{$mensagem->parent->nome}} - {{$mensagem->created_at->format('H:i')}}</div>
            {{$mensagem->mensagem}}
        </div>
    @endif
@endforeach