@if(!isset($_COOKIE['ferias-read']))
    @if(Auth::user()->funcionarios->count() > 0)
        <script type="text/javascript">
            $(function () {
                $('#modal-ferias').modal('show');
                $('#modal-ferias .btn-default').on('click', function () {
                    if ($(this).parent().find($('[type="checkbox"]')).is(':checked')) {
                        document.cookie = 'ferias-read=true';
                    }
                });
            });
        </script>
        <div class="modal animated fadeIn" id="modal-ferias" tabindex="-1" role="dialog">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Informação importante Férias e Décimo Terceiro</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12">
                            <p class="message">Olá {{Auth::user()->nome}}, tudo bem? Temos um comunicado importante a
                                respeito de férias e décimo terceiro!</p>

                            <p><strong>13º Salário</strong></p>
                            <ul>
                                <li>Primeira parcela pagamento até dia 30/11, o cálculo será enviado assim que concluída
                                    a folha de outubro/2019 (07/11/2019), esta primeira parcela contempla 50% do valor
                                    devido a título de 13º salário, as empresas que já tenham pago junto com as férias
                                    ou em outro período do ano não terão esta obrigação em 30/11/2019.
                                </li>
                                <li>Segunda parcela, deverá ser paga até 20/12/2019, o cálculo será liberado após o
                                    cálculo da folha de novembro/2019 (09/12/2019)
                                </li>
                                <li>Em virtude de horas extras, comissões e demais proventos da folha de dezembro/2019
                                    que interfiram nas médias, na folha de pagamento de janeiro aparecerá valores de 13º
                                    complementar.
                                </li>
                            </ul>
                            <p><strong>Férias</strong></p>
                            <p class="message"> Só podem ser concedidas após completado o primeiro período aquisitivo,
                                não
                                podendo as
                                mesmas serem antecipadas</p>
                            <p class="message">Férias coletivas, em caso de férias coletivas (as férias serão
                                “antecipadas”,
                                pois será
                                encerrado o período aquisitivo e iniciado novo) existindo assim as situações abaixo para
                                quem não tenha o período aquisitivo completo:</p>

                            <ul>
                                <li>Dias de direito* = dias de férias coletivas: paga-se normalmente, inicia e termina
                                    junto
                                    com os demais colaboradores;
                                </li>
                                <li>Dias de direito* > dias de férias coletivas: paga-se todos os dias (caso a sobra
                                    seja
                                    menor que 5 dias), inicia ou termina antes ou após os demais colaboradores;
                                </li>
                                <li>Dias de direito* < dias de férias coletivas: paga-se os dias de direito, inicia e
                                    termina
                                    junto com os demais, sendo que a diferença de dias será paga como licença
                                    remunerada;
                                </li>
                                <li>As férias devem ser solicitadas com 45 dias de antecedência ao escritório, para que
                                    o
                                    aviso de férias seja assinado com no mínimo 30 dias de antecedência;
                                </li>
                                <li>O valor de férias deverá ser pago 2 dias úteis anterior ao início;</li>
                                <li>As férias devem iniciar 2 dias antes do DSR (normalmente domingo) e de feriados;
                                </li>
                                <li>A compra dos 10 dias de férias deve ser feita na primeira retirada de férias no
                                    período
                                    aquisitivo, não podendo ser menos dias, ou comprada em segundo período;
                                </li>
                                <li>Para gozo das férias é permitido dividir em 3 vezes, sendo que um dos períodos não
                                    pode
                                    ser menor que 14 dias e os outros 2 não podem ser inferiores há 5 dias.
                                </li>
                            </ul>
                            <p class="message">*Dias de direito = são os dias que o colaborador já terá direito as
                                férias.
                                Ex. Contratação
                                em 01/06/2019, os dias de direito serão calculados até o início das férias, no exemplo
                                utilizaremos dia 16/12/2019, desta forma o funcionário ainda não terá os 30 dias por não
                                ser
                                período aquisitivo completo, mas terá o saldo de 17dias, esses são os dias de
                                direito.</p>
                            <p class="message">Lembre-se {{Auth::user()->nome}}, o não envio dessas informações de
                                maneira
                                correta
                                implicará em
                                multas para sua empresa. Caso tenha alguma dúvida basta <a
                                        href="{{route('newChamado')}}">abrir
                                    um chamado</a>.</p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-footer">
                            <label class="checkbox checkbox-styled radio-success pull-left" style="padding-top: 8px">
                                <input type="checkbox"><span></span>Não mostrar essa mensagem novamente
                            </label>
                            <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif