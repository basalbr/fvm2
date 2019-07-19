@extends('dashboard.layouts.master')

@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()

            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
        });

        function validateFormPrincipal() {
            $('.nav-tabs a[href="#informacoes"]').tab('show');
            $('.modal, html, body, #content').animate({
                scrollTop: $('#file-upload-form').offset().top - 50
            }, 500);
            $('#form-principal').find('.btn-success[type="submit"]').addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass"></i> Validando dados, aguarde...');
            if($('#list-files tr').length < 2){
                $('#form-principal').find('.btn-success[type="submit"]').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-check"></i> Finalizar');
                showModalAlert('Precisamos que você nos envie suas notas fiscais.<br />Caso não tenha havido movimentação nesse período, clique em "Sem movimento".<br />Se tiver dúvidas de como proceder, entre em contato conosco.');
                return false;
            }
            var formData = $('#form-principal').serializeArray();
            $.post($('#form-principal').data('validation-url'), formData)
                .done(function () {
                    $('#form-principal').find('.btn-success[type="submit"]').addClass('disabled').prop('disabled', true).html('<i class="fa fa-hourglass"></i> Salvando informações, aguarde...');
                    $('#form-principal').submit();
                })
                .fail(function (jqXHR) {
                    if (jqXHR.status === 422) {
                        //noinspection JSUnresolvedVariable
                        showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                    } else {
                        showFormValidationError($('#form-principal'));
                    }
                    $('#form-principal').find('.btn-success[type="submit"]').removeClass('disabled').prop('disabled', false).html('<i class="fa fa-check"></i> Finalizar');
                });
        }
    </script>
@stop
@section('top-title')
    <a href="{{route('listApuracoesToUser')}}">Apurações</a> <i
            class="fa fa-angle-right"></i> {{$apuracao->imposto->nome}} - {{$apuracao->competencia->format('m/Y')}}
@stop
@section('content')

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab"><i
                        class="fa fa-info-circle"></i>
                Informações/Enviar documentos</a>
        </li>
        <li role="presentation">
            <a href="#mensagens" aria-controls="mensagens" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
                Mensagens <span
                        class="badge">{{$apuracao->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
        </li>
        <li role="presentation">
            <a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i>
                Documentos enviados</a>
        </li>
        @if($apuracao->guia)
            <li class="animated bounceInDown highlight">
                <a href="{{asset(public_path().'storage/anexos/'. $apuracao->getTable() . '/'.$apuracao->id . '/' . $apuracao->guia)}}"
                   download><i class="fa fa-download"></i> Guia</a>
            </li>
        @endif
    </ul>
    <!-- Tab panes -->
    <form method="POST" action="" id="form-principal" enctype="multipart/form-data">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active animated fadeIn" id="informacoes">

                <div class="list">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Empresa</label>
                            <div class="form-control">{{$apuracao->empresa->nome_fantasia}}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Imposto</label>
                            <div class="form-control">{{$apuracao->imposto->nome}}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Status da apuração</label>
                            <div class="form-control">{{$apuracao->status}}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Competência</label>
                            <div class="form-control">{{$apuracao->competencia->format('m/Y')}}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Vencimento</label>
                            <div class="form-control">{{$apuracao->vencimento->format('d/m/Y')}}</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @if($apuracao->isPendingInfo())
                    <div class="col-sm-12">

                        {{ csrf_field() }}

                        <h3>Envio de documentos</h3>
                        <div class="col-xs-12">
                            <p>É necessário enviar algumas informações adicionais para que possamos dar
                                continuidade no processo de apuração.<br/>
                                Clique em <strong>finalizar</strong> após enviar todos os arquivos. Após finalizar o
                                envio, não será possível enviar novos documentos.<br/>
                                Se não houve movimentação, clique no botão <strong>sem movimento</strong>.
                            </p>
                        </div>
                        <div class="col-xs-12">
                            <p>Por favor nos envie os seguintes documentos:</p>

                            <ul>
                                @foreach($apuracao->imposto->informacoesExtras as $informacoesExtra)
                                    <li>{{$informacoesExtra->nome}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @include('dashboard.components.uploader.default', ['idReferencia'=>$apuracao->id, 'referencia'=>'apuracao', 'anexos'=>$apuracao->anexos])
                        <div class="clearfix"></div>
                    </div>
                @endif
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="mensagens">
                <div class="col-sm-12">
                    @if($apuracao->status == 'Concluído')
                        @include('dashboard.components.chat.box', ['model'=>$apuracao])
                    @else
                        @include('dashboard.components.chat.box', ['model'=>$apuracao, 'lockUpload'=>true])
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane animated fadeIn" id="anexos">

                <div id="anexos">
                    <br/>
                    <div class="col-sm-12">
                        <p>Aqui estão os arquivos relacionados à esse processo.</p>
                    </div>
                    <div class="list">
                        @foreach($apuracao->informacoes as $informacao)
                            @if($informacao->tipo->tipo == 'anexo')
                                <div class="col-sm-4">
                                    @include('dashboard.components.anexo.withDownload', ['anexo'=>$informacao->toAnexo()])
                                </div>
                            @endif
                        @endforeach
                        @foreach($apuracao->anexos as $anexo)
                            <div class="col-sm-4">
                                @include('dashboard.components.anexo.withDownload', ['anexo'=>$anexo])
                            </div>
                        @endforeach
                        @foreach($apuracao->mensagens as $message)
                            @if($message->anexo)
                                <div class="col-sm-4">
                                    @include('dashboard.components.anexo.withDownload', ['anexo'=>$message->anexo])
                                </div>
                            @endif
                        @endforeach

                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <div class="col-sm-12">
                    <a class="btn btn-default" href="{{URL::previous()}}"><i
                                class="fa fa-angle-left"></i>
                        Voltar</a>
                    @if($apuracao->isPendingInfo())
                        <a href="{{route('apuracaoSemMovimentacaoUser', [$apuracao->id])}}"
                           class="btn btn-danger"><i class="fa fa-remove"></i> Sem movimento
                        </a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Finalizar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
@stop
