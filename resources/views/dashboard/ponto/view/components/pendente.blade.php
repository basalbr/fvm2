@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#dsr').on('change', function () {
               $(this).val() == 'Sim' ? $('#datas_dsr').removeClass('hidden') : $('#datas_dsr').addClass('hidden');
            });
            $('#sendPontos').on('click', function (e) {
                e.preventDefault();
                $('#form-principal').submit();
            });
        });
    </script>
@stop
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#envio" aria-controls="envio" role="tab" data-toggle="tab"><i
                    class="fa fa-upload"></i>
            Envio de Registros</a>
    </li>
    <li role="presentation">
        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-comments"></i>
            Mensagens <span
                    class="badge">{{$ponto->mensagens()->where('lida','=',0)->where('from_admin','=',1)->count()}}</span></a>
    </li>
    @if($ponto->isFinished())
        <li class="animated bounceInDown highlight">
            <a href="{{route('showProcessoFolhaToUser', $ponto->getProcesso()->id)}}"><i
                        class="fa fa-external-link"></i> Ver recibos de pagamento</a>
        </li>
    @endif
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active animated fadeIn" id="envio">
        <div class="col-xs-12">
            @if($ponto->status=='pendente')
                <p class="alert alert-info" style="display: block"><strong>Nesse local você deverá enviar</strong>
                    as ocorrências e anotações dos funcionários durante o período
                    de {{$ponto->periodo->format('m/Y')}} até o primeiro dia útil de {{date('m/Y')}} para que
                    possamos calcular a folha dos seus funcionários e disponibilizá-la junto dos encargos em tempo
                    hábil para cumprimento da legislação.</p>
                <p class="alert alert-info" style="display: block"><strong>As informações devem ser
                        fornecidas</strong> de maneira individualizada por funcionário, para isso basta selecionar o
                    funcionário abaixo e informar as ocorrências caso necessário.</p>
            @else
                <p>{{Auth::user()->nome}}, abaixo estão os registros que você enviou, clique em download para baixar
                    e visualizar.</p>
            @endif
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Empresa</label>
                <div class="form-control">
                    <a href="{{route('showEmpresaToUser', $ponto->empresa->id)}}">{{$ponto->empresa->nome_fantasia}}
                        ({{$ponto->empresa->razao_social}})</a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Status</label>
                <div class="form-control">
                    {{$ponto->getStatus()}}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Período</label>
                <div class="form-control">
                    {{$ponto->periodo->format('m/Y')}}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($ponto->empresa->funcionarios()->where('status', 'ativo')->orderBy('nome_completo')->get() as $k => $funcionario)
                    <li role="presentation" class="{{$k == 0 ? 'active' : ''}}">
                        <a href="#{{$funcionario->id}}" aria-controls="{{$funcionario->id}}" role="tab"
                           data-toggle="tab">{{$funcionario->nome_completo}}</a>
                    </li>
                @endforeach
            </ul>
            <form action="" method="POST" id="form-principal">
                {!! csrf_field() !!}
                <div class="tab-content">
                    @foreach($ponto->empresa->funcionarios()->where('status', 'ativo')->orderBy('nome_completo')->get() as $k => $funcionario)
                        <div role="tabpanel" class="tab-pane {{$k == 0 ? 'active' : ''}} animated fadeIn"
                             id="{{$funcionario->id}}">
                            <div class="col-sm-12">
                                <p class="alert alert-info" style="display: block"><strong>Preencha os campos
                                        abaixo</strong> caso tenha ocorrido incidência durante o período
                                    de {{$ponto->periodo->format('m/Y')}}. Deixe em branco os campos que não tiveram
                                    ocorrência.</p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Horas Extras Diárias</label>
                                    <input type="text" class="form-control number-mask"
                                           name="informacao[{{$funcionario->id}}][Horas Extras Diárias]"
                                           placeholder="Informe as horas extras realizadas de Segunda à Sexta."/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Horas Extras Finais de Semana</label>
                                    <input type="text" class="form-control number-mask"
                                           name="informacao[{{$funcionario->id}}][Horas Extras Finais de Semana]"
                                           placeholder="Informe as horas extras realizadas no Sábado e Domingo."/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Horas de Trabalho Noturno</label>
                                    <input type="text" class="form-control number-mask"
                                           name="informacao[{{$funcionario->id}}][Horas de Trabalho Noturno]"
                                           placeholder="Informe as horas trabalhadas entre 22h e 05h"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Horas Faltas</label>
                                    <input id="horas_faltas" type="text" class="form-control number-mask"
                                           name="informacao[{{$funcionario->id}}][Horas Faltas]"
                                           placeholder="Informe as horas faltas"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Antecipação Salarial (R$)</label>
                                    <input type="text" class="form-control money-mask"
                                           name="informacao[{{$funcionario->id}}][Antecipação Salarial (R$)]"
                                           placeholder="Informe o valor caso tenha havido antecipação salarial"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bonificação (R$)</label>
                                    <input type="text" class="form-control money-mask"
                                           name="informacao[{{$funcionario->id}}][Antecipação Salarial (R$)]"
                                           placeholder="Informe o valor caso tenha havido antecipação salarial"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Descontar D.S.R? <small>Somente se o funcionário faltar pelo menos um dia
                                            inteiro</small></label>
                                    <select id="dsr" name="informacao[{{$funcionario->id}}][Descontar D.S.R?]"
                                            class="form-control">
                                        <option selected="selected" value="Não">Não</option>
                                        <option value="Sim">Sim</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 hidden" id="datas_dsr">
                                <div class="form-group">
                                    <label>Datas de faltas para D.S.R</label>
                                    <input type="text" class="form-control"
                                           name="informacao[{{$funcionario->id}}][Datas de faltas para D.S.R]"
                                           placeholder="Informe as datas de falta para que possamos calcular o D.S.R"/>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Outros</label>
                                    <textarea class="form-control" name="informacao[{{$funcionario->id}}][Outros]"
                                              placeholder="Informe outros detalhes a serem considerados no cálculo desse funcionário"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>