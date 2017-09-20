@section('annotations')
    <li>
        <a class="btn btn-primary animated flipInY open-modal" data-modal="#modal-annotation" href="">
            <span class="fa fa-pencil"></span> {{$model->anotacoes->count()}}
        </a>
    </li>
@show
@section('modals')
@parent
@include('admin.modals.annotations', $model)
@stop