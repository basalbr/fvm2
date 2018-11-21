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
            $('.select-empresa').on('click', function () {
                $('.select-empresa').removeClass('btn-primary').addClass('btn-default');
                $(this).removeClass('btn-default').addClass('btn-primary');
                $('[name="id_empresa"]').val($(this).data('id'));
            })
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
                        <label>Selecione uma empresa *</label>
                        <input type="hidden" name="id_empresa"/>
                        <div class="form-control">
                        @foreach($empresas as $empresa)
                            <div class="btn btn-default select-empresa" data-id="{{$empresa->id}}">
                                <div class="">{{$empresa->razao_social}}</div>
                                @if($empresa->decimosTerceiro()->whereYear('created_at',Carbon\Carbon::now()->year)->count() > 0)
                                    @foreach($empresa->decimosTerceiro()->whereYear('created_at', Carbon\Carbon::now()->year)->get() as $decimoTerceiro)
                                        <div class="label-success label"><i
                                                    class="fa fa-check"></i> {{$decimoTerceiro->descricao}}</div>
                                    @endforeach
                                @else
                                    <div class="label-default label">Nada enviado</div>
                                @endif
                            </div>
                        @endforeach
                        </div>
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