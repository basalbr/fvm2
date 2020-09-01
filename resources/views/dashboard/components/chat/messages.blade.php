@if(count($messages))
    @foreach($messages as $message)
        @if($message->id_usuario)
        <div class="message{{$message->from_admin ? ' from-admin' : ''}} animated fadeIn" data-id="{{$message->id}}">
            <div class="thumb">
                <img src="{{$message->usuario->foto ? asset(public_path().'storage/usuarios/'.$message->usuario->id.'/'.$message->usuario->foto) : asset(public_path().'images/thumb.jpg')}}"/>
            </div>
            <div class="name"><span class="hidden-xs">{{$message->usuario->nome}}</span><span class="visible-xs">{{Auth::user()->id == $message->id_usuario ? 'Eu' : $message->usuario->nome}}</span><span class="time hidden-xs"> - Enviado em {{$message->created_at->format('d/m/y à\s H:i')}}</span><span class="time visible-xs"> - {{$message->created_at->format('d/m/y à\s H:i')}}</span>
            </div>
            <div class="clearfix"></div>
            <div class="text">
                @if($message->anexo)
                    <p>
                        <a download
                           href="{{asset(public_path().'storage/anexos/'. $message->anexo->referencia . '/'.$message->anexo->id_referencia . '/' . $message->anexo->arquivo)}}">
                            <span class="hidden-xs"><i class="fa fa-download"></i> {{$message->anexo->descricao}}</span><span class="visible-xs"><i class="fa fa-download"></i> {{str_limit($message->anexo->descricao, 18, '...')}}</span>
                        </a>
                </p>
                @else
                    <p>{!!nl2br($message->mensagem)!!}</p>
                @endif
            </div>
        </div>
        @else
            <div class="message{{$message->from_admin ? ' from-admin' : ''}} animated fadeIn"
                 data-id="{{$message->id}}">
                <div class="thumb">
                    <img src="{{asset(public_path().'images/thumb.jpg')}}"/>
                </div>
                <div class="text">
                    <p><strong>{{$message->parent->nome}}
                            - {{$message->created_at->format('d/m/y à\s H:i')}}</strong>
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