@if(!isset($_COOKIE['esocial-read']))
    @if(Auth::user()->empresas()->where('status', 'aprovado')->where('certificado_digital', null)->count())
        <script type="text/javascript">
            $(function () {
                $('#modal-esocial').modal('show');
                $('#modal-esocial [type="checkbox"]').on('change', function(){
                    if($(this).is(':checked')){
                        document.cookie = 'esocial-read=true';
                    }else{
                        document.cookie = 'esocial-read=false=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                    }
                });
            });
        </script>
        <div class="modal animated fadeIn" id="modal-esocial" tabindex="-1" role="dialog">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Informação importante e-Social</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12">

                            <br/>
                            <p class="message">Olá {{Auth::user()->nome}}, tudo bem?</p>
                            <p class="message">Existe um sistema do governo chamado de <a
                                        href="http://portal.esocial.gov.br/institucional/conheca-o"
                                        target="_blank"><strong>e-Social</strong></a>,
                                onde precisamos obrigatoriamente enviar informações da
                                sua
                                empresa e das pessoas que compõem ela sob pena de multa caso não seja feito o envio
                                dessas
                                informações.</p>
                            <p class="message">Infelizmente o governo nos obriga a possuírmos procuração ou o
                                certificado
                                digital da sua empresa para que possamos enviar essas informações.</p>
                            <p class="message">Sendo assim precisamos que nos envie seu <strong>certificado digital do
                                    tipo
                                    A1</strong> para que possamos manter a sua
                                empresa
                                em dia junto ao governo.</p>
                            <p class="message">Caso não possua um certificado digital do tipo A1, será necessário
                                comprar um
                                junto à uma certificadora, nesse caso basta acessar <a target="_blank"
                                                                                       href="https://www.google.com.br/search?q=certificadora&oq=certificadora">esse
                                    link</a> para encontrar a certificadora mais próxima de você e também para saber
                                mais
                                sobre do que se trata o certificado digital.</p>
                            <p class="message">Lembre-se {{Auth::user()->nome}}, o não envio dessas informações
                                implicará em
                                multas para sua empresa. Caso tenha alguma dúvida basta <a
                                        href="{{route('newChamado')}}">abrir
                                    um chamado</a>.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <label class="checkbox checkbox-styled radio-success pull-left" style="padding-top: 8px">
                            <input type="checkbox"><span></span>Não mostrar essa mensagem novamente
                        </label>
                        <a href="{{route('listCertificadosToUser')}}" class="btn btn-primary"><i
                                    class="fa fa-upload"></i>
                            Enviar
                            certificado digital A1
                        </a>
                        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
@if(!isset($_COOKIE['corona-read']))
    @if(Auth::user()->empresas()->where('status', 'aprovado')->count() > 0)
        <script type="text/javascript">
            $(function () {
                $('#modal-corona').modal('show');
                $('#modal-corona [type="checkbox"]').on('change', function(){
                    if($(this).is(':checked')){
                        document.cookie = 'corona-read=true';
                    }else{
                        document.cookie = 'corona-read=false=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                    }
                });
            });
        </script>
        <div class="modal animated fadeIn" id="modal-corona" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Comunicado importante COVID-19</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12">

                            <br/>
                            <p class="message">Olá {{Auth::user()->nome}}, tudo bem? Temos alguns comunicados importantes sobre medidas do governo por conta do COVID-19!</p>
                            <p class="message"><strong>RESOLUÇÃO Nº 152, DE 18 DE MARÇO DE 2020 D.O.U em 18/03/2020 edição extra.</strong><br />
                                I - o Período de Apuração Março de 2020, com vencimento original em 20 de abril de 2020, fica com vencimento para 20 de outubro de 2020;<br />
                                II - o Período de Apuração Abril de 2020, com vencimento original em 20 de maio de 2020, fica com vencimento para 20 de novembro de 2020;<br />
                                III- o Período de Apuração Maio de 2020, com vencimento original em 22 de junho de 2020, fica com vencimento para 21 de dezembro de 2020.<br />
                                <br />
                                É importante considerar no fluxo de caixa de suas empresas que nos meses de outubro, novembro e dezembro teremos duas guias do tributo a recolher.</p>
                            <p class="message"><strong>MEDIDA PROVISÓRIA Nº 927, DE 22 DE MARÇO DE 2020</strong><br />
                                Art. 3º Para enfrentamento dos efeitos econômicos decorrentes do estado de calamidade pública e para preservação do emprego e da renda, poderão ser adotadas pelos empregadores, dentre outras, as seguintes medidas:<br />
                                VIII - o diferimento do recolhimento do Fundo de Garantia do Tempo de Serviço - FGTS.<br />
                                Art. 19. Fica suspensa a exigibilidade do recolhimento do FGTS pelos empregadores, referente às competências de março, abril e maio de 2020, com vencimento em abril, maio e junho de 2020, respectivamente.<br />
                                Art. 20. O recolhimento das competências de março, abril e maio de 2020 poderá ser realizado de forma parcelada, sem a incidência da atualização, da multa e dos encargos previstos no art. 22 da Lei nº 8.036, de 11 de maio de 1990.<br />
                                <br />
                                Ou seja, não precisará recolher no prazo os valores que vencem em abril, maio e junho; posteriormente deverá recolher o mensal e o valor destes meses poderá ser parcelado para recolhimento.</p>
                        </div>
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
    @endif
@endif


