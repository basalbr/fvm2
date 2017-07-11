<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Assunto</th>
        <th>Status</th>
        <th>Aberto em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($chats->count())
        @foreach($chats as $chat)
            <tr>
                <td>{{$chat->nome}}</td>
                <td>{{$chat->assunto}}</td>
                <td>{{$chat->getStatus()}}</td>
                <td>{{$chat->created_at->format('d/m/Y H:i')}}</td>
                <td><a class="btn btn-primary" href="{{route('showChatToAdmin', [$chat->id])}}"
                       title="Visualizar"><i class="fa fa-search"></i></a></td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="7">Nenhum chat encontrado</td>
        </tr>
    @endif
    </tbody>
</table>