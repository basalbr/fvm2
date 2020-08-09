<table class="table table-striped table-hover">
    <tbody>
    @foreach($tarefa->registros()->orderBy('created_at', 'desc')->get() as $registro)
        <tr>
            <th scope="row">{{$registro->created_at->format('d/m/Y H:i')}}</th>
            <td><a href="">{{$registro->mensagem}}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="clearfix"></div>