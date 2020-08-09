@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                $(this).addClass('disabled').prop('disabled', true);
                validateFormPrincipal();
            });
        });
        function validateFormPrincipal() {
            var formData = new FormData();
            var shouldStop = false;
            $('[type="file"]').each(function () {
                if($(this)[0].files[0].size > 1024000){
                    showModalAlert('O tamanho do arquivo não pode ser maior que 10MB');
                    shouldStop = true;
                }
                formData.append($(this).attr('name'), $(this)[0].files[0]);
            });
            if(shouldStop){
                return false;
            }
            var params = $('#form-principal').serializeArray();
            $(params).each(function (index, element) {
                formData.append(element.name, element.value);
            });
            $.post({
                url: $('#form-principal').data('validation-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function () {
                $('#form-principal').submit();
            }).fail(function (jqXHR) {
                $('.btn-success[type="submit"]').removeClass('disabled').prop('disabled', false);
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#form-principal'));
                }
            });
        }
    </script>
@stop
@section('top-title')
    <a href="{{route('listRecalculosToUser')}}">Recálculos</a> <i class="fa fa-angle-right"></i> Novo Recálculo
@stop
@section('content')
    <form class="form" method="POST" action="" id="form-principal"
          data-validation-url="{{route('validateRecalculo')}}" enctype="multipart/form-data">
    <div class="panel">
        <p class="alert-info alert" style="display: block"><strong>Preencha os campos</strong> abaixo e clique no botão concluir para solicitar um recálculo.</p>
        <p class="alert-info alert" style="display: block">Nós disponibilizaremos a guia até <strong>24 horas úteis após a confirmação do pagamento.</strong></p>
        <p class="alert-info alert" style="display: block"><strong>Caso perca o prazo</strong> da guia do recálculo será necessário solicitar um novo recálculo.</p>
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="id_tipo_recalculo" class="form-control">
                        @foreach($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->descricao}} - R$ {{$tipo->getValor()}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" placeholder="Por favor informe a competência do tributo (Ex: Janeiro/2019) e qual a data que pretende efetuar o pagamento, lembrando que faremos o recálculo em até 24 horas úteis após confirmação do pagamento."></textarea>
                </div>
            </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Concluir</button>
    </div>
    </form>

@stop