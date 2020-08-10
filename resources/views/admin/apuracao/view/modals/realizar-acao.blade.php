@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('.receita-interno').on('change', function () {
                var receita_interno;
                $('.receita-interno, #receita_total_interno, #devolucao-interno').each(function () {
                    valor_formatado = parseFloat($(this).val().replace(".", "").replace(",", "."));
                    isNaN(valor_formatado) ? receita_interno = receita_interno + 0 : receita_interno = receita_interno + valor_formatado;
                }, receita_interno = 0)
                // receita_interno -= $('#devolucao-interno').val() ? parseFloat($('#devolucao-interno').val().replace(".", "").replace(",", ".")) : 0;
                $('#receita_total_interno').val(receita_interno.toFixed(2).replace(".", ","))
                validaApuracao()
            });
            $('.receita-externo, #receita_total_externo, #devolucao-externo').on('change', function () {
                var receita_externo;
                $('.receita-externo').each(function () {
                    valor_formatado = parseFloat($(this).val().replace(".", "").replace(",", "."));
                    isNaN(valor_formatado) ? receita_externo = receita_externo + 0 : receita_externo = receita_externo + valor_formatado;
                }, receita_externo = 0)
                // receita_externo -= $('#devolucao-externo').val() ? parseFloat($('#devolucao-externo').val().replace(".", "").replace(",", ".")) : 0;
                $('#receita_total_externo').val(receita_externo.toFixed(2).replace(".", ","))
                validaApuracao();
            });

            $('#resultado-apuracao-sistema').on('change', function () {
                validaApuracao();
            })
        });

        function validaApuracao() {
            var tributos = [];
            $('.receita-interno, .receita-externo').each(function () {
                tributos.push({
                    'valor': $(this).val().replace(".", "").replace(",", "."),
                    'id_tributacao': $(this).data('id-tributacao')
                })
            }, tributos);
            var toPost = {
                'competencia': $('#form-principal').data('competencia'),
                'tributacoes': tributos,
                // 'devolucao_interno': $('#devolucao-interno').val().replace(".", "").replace(",", "."),
                // 'devolucao_externo': $('#devolucao-externo').val().replace(".", "").replace(",", ".")
            }
            $.post($('#form-principal').data('url-validacao'), toPost)
                .done(function (jqXHR) {
                    $('#valor-validacao').val(jqXHR);
                    valor_validacao = parseFloat($('#valor-validacao').val().replace(".", "").replace(",", "."));
                    resultado_apuracao = parseFloat($('#resultado-apuracao-sistema').val().replace(".", "").replace(",", "."));
                    if ((valor_validacao - resultado_apuracao) <= 0.05 && (valor_validacao - resultado_apuracao) >= -0.05) {
                        $('#valor-validacao').parent().addClass('list-group-item-success').removeClass('list-group-item-danger');
                        $('#form-principal .btn-success').prop('disabled', false);
                    } else {
                        $('#valor-validacao').parent().removeClass('list-group-item-success').addClass('list-group-item-danger');
                        $('#form-principal .btn-success').prop('disabled', true);
                    }
                }).fail(function (jqXHR) {
                console.log(jqXHR);
            });
        }
    </script>
@stop

<div class="modal animated fadeIn" id="modal-realizar-acao" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Status e envio de guia</h3>
            </div>

            <form id="form-principal" method="POST" action="" enctype="multipart/form-data"
                  data-url-validacao="{{route('calculateApuracaoSimplesNacional')}}"
                  data-competencia="{{$apuracao->competencia}}">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="alert alert-info" style="display: block"><strong>Validação</strong></div>
                    @foreach($apuracao->empresa->tributacoes()->orderBy('mercado', 'desc')->get() as $tributacao)
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{$tributacao->descricao}} {!! $tributacao->getMercadoLabel() !!}</label>
                                <input class="form-control money-mask {{'receita-'.$tributacao->mercado}}"
                                       placeholder="0,00" type="text"
                                       data-id-tributacao="{{$tributacao->id}}"
                                       name="tributo_{{$tributacao->mercado}}['{{$tributacao->descricao}}']"/>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Resultado da apuração no sistema</label>
                            <input class="form-control money-mask" id="resultado-apuracao-sistema"
                                   placeholder="0,00" type="text"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Resultado da validação</label>
                            <input id="valor-validacao" class="form-control" disabled="disabled" type="text"
                                   placeholder="0,00"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <a role="button" data-toggle="collapse"
                       href="#collapseOne" class="alert alert-info" style="display: block"><strong>Ver detalhes do
                            cálculo <span class="pull-right fa fa-plus"></span></strong></a>

                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Receita total do mês <span
                                                class="label label-info">Mercado Interno</span></label>
                                    <input class="form-control money-mask"
                                           id="receita_total_interno"
                                           placeholder="0,00" type="text" name="faturamento_interno"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Receita bruta dos últimos 12 meses <span
                                                class="label label-info">Mercado Interno</span></label>
                                    <input class="form-control money-mask" disabled="disabled" type="text"
                                           value="{{$apuracao->empresa->getReceitaBrutaUltimosDozeMesesSN($apuracao->competencia, 'interno')}}"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Receita total do mês <span
                                                class="label label-warning">Mercado Externo</span></label>
                                    <input class="form-control money-mask"
                                           id="receita_total_externo"
                                           placeholder="0,00" type="text" name="faturamento_externo"/>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Receita bruta dos últimos 12 meses <span
                                                class="label label-warning">Mercado Externo</span></label>
                                    <input class="form-control money-mask" disabled="disabled" type="text"
                                           value="{{$apuracao->empresa->getReceitaBrutaUltimosDozeMesesSN($apuracao->competencia, 'externo')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="alert alert-info" style="display: block"><strong>Status e Guia</strong></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Status da apuração</label>
                            <select name="status" class="form-control">
                                <option {{$apuracao->status == 'Atenção' ? 'selected' : ''}} value="atencao">Atenção
                                </option>
                                <option {{$apuracao->status == 'Cancelado' ? 'selected' : ''}} value="cancelado">
                                    Cancelado
                                </option>
                                <option {{$apuracao->status == 'Concluído' ? 'selected' : ''}} value="concluido">
                                    Concluído
                                </option>
                                <option {{$apuracao->status == 'Novo' ? 'selected' : ''}} value="novo">Novo</option>
                                <option {{$apuracao->status == 'Sem Movimento' ? 'selected' : ''}} value="sem_movimento">
                                    Sem
                                    Movimento
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-control">
                                <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                    Anexar guia
                                </button>
                            </div>
                            <input data-validation-url="{{route('validateGuia')}}"
                                   data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                                   type='file' value=""/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Notas de Serviço</label>
                            <input type="text" name="qtde_notas_servico" class="form-control number-mask"
                                   placeholder="0"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Notas de Entrada</label>
                            <input type="text" name="qtde_notas_entrada" class="form-control number-mask"
                                   placeholder="0"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Notas de Saída</label>
                            <input type="text" name="qtde_notas_saida" class="form-control number-mask"
                                   placeholder="0"/>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" disabled="disabled"><i class="fa fa-check"></i> Concluir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
