@if(count($messages))
    @foreach($messages as $message)
        <div class="message {{$message->from_admin ? 'from-admin' : ''}} animated bounceIn" data-id="{{$message->id}}">
            <div class="thumb">
                <img src="{{url(public_path().'/images/thumb.jpg')}}"/>
            </div>
            <div class="text">
                <p><strong>{{$message->usuario->nome}} - {{$message->created_at->format('d/m/y H:i')}}</strong>
                </p>
                <p>{{$message->mensagem}}</p>
            </div>
        </div>
        <div class="clearfix"></div>
    @endforeach
@else
    <div class="no-messages">Nenhuma mensagem enviada ou recebida</div>
@endif