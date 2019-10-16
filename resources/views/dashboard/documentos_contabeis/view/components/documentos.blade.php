@foreach($processo->anexos as $anexo)
    <tr>
        <th>{{$anexo->descricao}}</th>
        <td>
            {!! $anexo->getLink() !!}
        </td>
    </tr>
@endforeach
@foreach($processo->mensagens as $message)
    @if($message->anexo)
        <tr>
            <th>{{$message->anexo->descricao}}</th>
            <td>
                {!! $message->anexo->getLink() !!}
            </td>
        </tr>
    @endif
@endforeach
