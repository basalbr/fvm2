@extends('admin.layouts.master')

@section('top-title')
    <a href="{{route('listDecimoTerceiroToAdmin')}}">Décimo Terceiro</a> <i
            class="fa fa-angle-right"></i> Enviar documentos
@stop
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {

            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
        });

        function validateFormPrincipal() {
            var formData = new FormData();
            if ($('[name="capa"]').val() !== '' && $('[name="capa"]').val() !== null && $('[name="capa"]').val() !== undefined) {
                formData.append('capa', $('[name="capa"]')[0].files[0])
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
            }).done(function (data, textStatus, jqXHR) {
                $('#form-principal').submit();
            }).fail(function (jqXHR, textStatus, errorThrown) {
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
@section('content')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#principal" aria-controls="principal" role="tab" data-toggle="tab"><i class="fa fa-home"></i>
                Principal</a>
        </li>

    </ul>
    <div class="tab-content">
        <form class="form" method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateDecimoTerceiro')}}" enctype="multipart/form-data">
            <div role="tabpanel" class="active tab-pane animated fadeIn" id="principal">
                @include('dashboard.components.form-alert')
                @include('dashboard.components.disable-auto-complete')
                {{csrf_field()}}
                <div class="col-xs-12">
                    <p>Após carregar os documentos necessários, clique no botão <strong>concluir</strong> para enviá-los
                        para o usuário.</p>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Empresa *</label>
                        <select class="form-control" name="id_empresa">
                            <option value="">Selecione uma empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{$empresa->id}}">{{$empresa->razao_social}} ({{$empresa->nome_fantasia}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Descrição dos documentos *</label>
                        <input class="form-control" name="descricao"/>
                    </div>
                </div>
                @include('admin.components.uploader.referenceless')
            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Concluir</button>
            </div>
        </form>
    </div>
@stop