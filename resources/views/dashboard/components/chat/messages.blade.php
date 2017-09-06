@if(count($messages))
    @foreach($messages as $message)
        @if($message->id_usuario)
        <div class="message {{$message->from_admin ? 'from-admin' : ''}} animated fadeIn" data-id="{{$message->id}}">
            <div class="thumb">
                <img src="{{$message->usuario->foto ? asset(public_path().'storage/usuarios/'.$message->usuario->id.'/'.$message->usuario->foto) : asset(public_path().'images/thumb.jpg')}}"/>
            </div>
            <div class="text">
                <p><strong>{{Auth::user()->id == $message->id_usuario ? 'Eu':$message->usuario->nome}}
                        - {{$message->created_at->format('d/m/y H:i')}}</strong>
                </p>
                <p>{!!nl2br($message->mensagem)!!}
                    @if($message->anexo)
                        <a download
                           href="{{asset(public_path().'storage/anexos/'. $message->anexo->referencia . '/'.$message->anexo->id_referencia . '/' . $message->anexo->arquivo)}}">
                            {{$message->anexo->descricao}}
                        </a>
                    @endif
                </p>
            </div>
        </div>
        @else
            <div class="message {{$message->from_admin ? 'from-admin' : ''}} animated fadeIn"
                 data-id="{{$message->id}}">
                <div class="thumb">
                    <img src="{{asset(public_path().'images/thumb.jpg')}}"/>
                </div>
                <div class="text">
                    <p><strong>{{$message->parent->nome}}
                            - {{$message->created_at->format('d/m/y H:i')}}</strong>
                    </p>
                    <p>{!! nl2br($message->mensagem) !!}
                        @if($message->anexo)
                            <a download
                               href="{{asset(public_path().'storage/anexos/'. $message->anexo->referencia . '/'.$message->anexo->id_referencia . '/' . $message->anexo->arquivo)}}">
                                {{$message->anexo->descricao}}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        @endif
        <div class="clearfix"></div>
    @endforeach
@else
    <div class="no-messages">Nenhuma mensagem enviada ou recebida</div>
@endif