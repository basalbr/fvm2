<div class="col-xs-12">
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Publicação</th>
        <th>Título</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($noticias->count())
        @foreach($noticias as $noticia)
            <tr>
                <td>{{$noticia->data_publicacao->format('d/m/Y')}}</td>
                <td>{{$noticia->titulo}}</td>
                <td><a class="btn btn-primary" href="{{route('showNoticiaToAdmin', $noticia->id)}}"><i class="fa fa-search"></i></a></td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="3">Nenhuma notícia cadastrada</td>
        </tr>
    @endif
    </tbody>
</table>
</div>
<div class="clearfix"></div>