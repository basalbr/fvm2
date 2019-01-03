@extends('dashboard.layouts.master')

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
    <a href="{{route('listSolicitacoesAlteracaoToUser')}}">Alterações</a> <i class="fa fa-angle-right"></i> {{$tipoAlteracao->descricao}} - {{$tipoAlteracao->getValorFormatado()}}
@stop
@section('content')

    <div class="panel">

        <form class="form" method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateAlteracao')}}" enctype="multipart/form-data">
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Empresa para alteração</label>
                    <select name="id_empresa" class="form-control">
                        @foreach($empresas as $empresa)
                            <option value="{{$empresa->id}}">{{$empresa->razao_social}} ({{$empresa->nome_fantasia}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="hidden" name="id_tipo_alteracao" value="{{$tipoAlteracao->id}}">
            @foreach($tipoAlteracao->campos as $campo)
                @if($campo->tipo == 'string')
                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label>{{$campo->nome}}</label>
                            <input type='text' class='form-control' name='campos[{{$campo->id}}]'
                                   placeholder="{{$campo->descricao}}"/>
                        </div>
                    </div>
                @elseif($campo->tipo == 'textarea')
                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label>{{$campo->nome}}</label>
                            <textarea name='campos[{{$campo->id}}]' class='form-control'
                                      placeholder="{{$campo->descricao}}"></textarea>
                        </div>
                    </div>
                @elseif($campo->tipo == 'file')
                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label>{{$campo->nome}}</label>
                            <input type='file' class='form-control' value="" name='anexos[{{$campo->id}}]'/>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="col-sm-12">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Enviar solicitação</button>
            </div>
        </form>
        <div class="clearfix"></div>
        <br/>
    </div>
@stop