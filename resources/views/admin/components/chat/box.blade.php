@section('js')
    @parent

    <script type="text/javascript" src="{{url(public_path().'js/admin/modules/messages.js')}}"></script>

@stop
<div class="col-xs-12">
    <div class="messages"
         data-read-messages-url="{{route('readMessagesAjax')}}"
         data-reference="{{$model->getTable()}}"
         data-reference-id="{{$model->id}}"
         data-send-message-url="{{route('sendMessageAjax')}}"
         data-update-messages-url="{{route('updateMessagesAjax')}}"
         data-upload-url="{{route('uploadChatFileAjax')}}">
        @include('admin.components.chat.messages',['messages'=>$model->mensagens])
    </div>
    <form>
        <div class="form-group">
            <textarea class="form-control" id="message"
                      placeholder="Digite sua mensagem..."></textarea>
            <small>Pressione Shift+Enter para criar uma nova linha</small>
        </div>
        <button class="btn-success btn" id="send-message"><i class="fa fa-send"></i> Enviar mensagem</button>
        <button class="btn-primary btn" id="send-file"><i class="fa fa-upload"></i> Enviar arquivo</button>
        <input type="file" id="file" class="hidden"/>
    </form>
</div>