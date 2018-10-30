@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            if ($('#form-principal').data('id') !== null || $('#form-principal').data('id') !== '') {
                getHistoryData($('#form-principal').data('id'))
            }
            $('.btn-success').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
            $('[name="id_empresa"]').on('change', function () {
                getHistoryData($(this).val())
            });
        });

        function getHistoryData(id) {
            if (id !== null || id !== '') {
                $('table tbody').html('<tr><td colspan="4" class="text-center">Carregando informações do servidor...</td></tr>');
                $.get($('#form-principal').data('history-url') + '/' + id)
                    .done(function (data) {
                        $('table tbody').html(data);
                    }).fail(function (jqXHR) {
                    $('table tbody').html('<tr><td colspan="4" class="text-center">Não foi possível carregar informações do servidor, avise o Junior</td></tr>');
                });
            }
        }

        function validateFormPrincipal() {
            var formData = new FormData();
            formData.append('anexo', $('#form-principal [name="anexo"]')[0].files[0])
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
            })
                .fail(function (jqXHR) {
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
    <a href="{{route('listBalancetesToAdmin')}}">Balancetes</a> <i class="fa fa-angle-right"></i> Enviar balancete
@stop
@section('content')
    <div class="panel">
        <form data-history-url="{{route('getBalanceteHistory')}}" data-id="{{$id}}" class="form" method="POST" action=""
              id="form-principal"
              data-validation-url="{{route('validateBalancete')}}" enctype="multipart/form-data">
            @include('admin.components.form-alert')
            @include('admin.components.disable-auto-complete')
            {{csrf_field()}}

            <div class="col-sm-12">
                <div class="form-group">
                    <label>Empresa *</label>
                    <select class="form-control" name="id_empresa">
                        <option value="">Escolha uma opção</option>
                        @foreach($empresas as $empresa)
                            <option {{$empresa->id == $id ? 'selected':''}} value="{{$empresa->id}}">{{$empresa->razao_social}}
                                ({{$empresa->nome_fantasia}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Exercício *</label>
                    <input class="form-control date-mask" name="exercicio" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Receitas *</label>
                    <input class="form-control money-mask" name="receitas" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Despesas *</label>
                    <input class="form-control money-mask" name="despesas" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Balancete *</label>
                    <input class="form-control" name="anexo" type="file" value=""/>
                </div>
            </div>
        </form>
        <div class="col-xs-12">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Exercício</th>
                    <th>Receitas</th>
                    <th>Despesas</th>
                    <th>Balancete</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="4" class="text-center">Nenhuma informação disponível</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>

        <button class="btn btn-success"><i class="fa fa-send"></i> Enviar Balancete</button>
    </div>
@stop