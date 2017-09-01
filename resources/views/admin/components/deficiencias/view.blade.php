@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/admin/modules/deficiencias.js')}}"></script>
@stop
<div class="col-xs-12">
    <p>Escolha abaixo as deficiências que o funcionário possui.</p>
    <br/>
    <div class="clearfix"></div>
</div>
@foreach($deficiencias as $deficiencia)
    <div class="col-sm-6 col-lg-4">
        <div class="form-group no-border">
            <label class="checkbox checkbox-styled radio-success">
                <input type="checkbox" class="deficiencia-checkbox"
                       data-id="{{$deficiencia->id}}" {{$funcionario->deficiencias->contains($deficiencia->id) ? 'checked="checked"' : ''}}><span></span> {{$deficiencia->descricao}}
            </label>
            <div class="clearfix"></div>
        </div>
    </div>
@endforeach