@extends('layouts.master')

@if(isset($login))
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#modal-access').modal('show');
        })
    </script>
@stop
@endif

@section('js')
    @parent
    @if($atendimento)
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
            (function () {
                var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/59b975184854b82732fefd9f/default';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    @endif
    <script type="text/javascript" src="{{url(public_path().'js/modules/simulate.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            if(getCookie('politica')!='true'){
                $('#div-politica').show();
            }
            $('#contrato').on('click', function () {
                $('#modal-contrato').modal('show');
            })

            $('#aceito-politica').on('click', function(e){
                e.preventDefault();
                setCookie('politica', 'true', 360)
                $('#div-politica').hide();
            });

        })
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
@stop


@section('content')

    <section id="main-banner" class="section">
        <input type="hidden" value="{{route('getMonthlyPaymentParams')}}" id="payment-parameters">

        @include('index.components.banner-principal')
    </section>
    <section id="como-funciona" class="section">
        @include('index.components.como-funciona')
    </section>
    <section id="imposto-renda" class="section">
        @include('index.components.imposto-renda')
    </section>
    <section id="abertura-alteracao" class="section">
        @include('index.components.abertura-empresa')
    </section>

    <section id="mensalidade" class="section">
        @include('index.components.mensalidade')
    </section>
    <section id="noticias" class="section">
        @include('index.components.noticias')
    </section>
    <section id="duvidas" class="section">
        @include('index.components.duvidas')
    </section>
    <div id="div-politica" style="display:none; padding: 5px; position: fixed; bottom: 0; left: 0; right: 0; height: auto; background-color: #01579B; border: 1px solid #01579B; z-index: 10">
        <p style="color: #fff">Para utilizar esse site é necessário que esteja de acordo com nossa <a href=""
                                                                                                      data-toggle="modal"
                                                                                                      data-target="#privacidadeModal">política
                de privacidade</a>, esta é uma
            exigência da nova Lei Geral de Proteção de Dados Pessoais (Lei nº 13.709/2018)</p>
        <a class="btn btn-success btn-sm" id="aceito-politica" href="">Aceito</a>
        <a class="btn btn-danger btn-sm" href="https://www.google.com">Não aceito</a>
    </div>
    <div class="clearfix"></div>
    <div class="modal fade" id="privacidadeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <h3>Política de privacidade da WEBContabilidade</h3>
                    <h4>Que tipo de dados coletamos?</h4>
                    <p><strong>Dados de cadastro:</strong> quando você se cadastra em nosso site nós coletamos seus
                        dados como nome, telefone e e-mail para que você possa acessar os serviços na área de cliente.
                        Coletamos também todos os dados que você informa em nosso sistema para que possamos realizar os
                        serviços contábeis contratados.</p>
                    <p><strong>Dados de navegação:</strong> utilizamos o AdSense do Google para coletar dados anônimos
                        que são utilizados puramente para métricas, como por exemplo, quantidade de acessos, horário em
                        que ocorreram os acessos, dados demográficos, etc.</p>
                    <h4>Como são utilizados seus dados?</h4>
                    <p>Utilizamos seus dados para realizarmos os serviços contábeis que são contratados, como abertura
                        de empresa, apuração de impostos, apuração de folha de pagamento, lançamento de documentos
                        contábeis, entre outros similares.</p>
                    <h4>Com quem compartilhamos seus dados?</h4>
                    <p><strong>Processamento e meios de pagamentos:</strong> Para que possamos oferecer nossos produtos,
                        serviços de assinatura e a venda de ingressos, compartilhamos seus dados com as administradoras
                        de cartão de crédito e sites de venda para operacionalizar e gerir os pagamentos.</p>
                    <p><strong>Analytics:</strong> Além dos dados agregados que recebemos de nossos parceiros, como
                        Google, os dados armazenados por nós podem vir a ser utilizados para fins de estatísticas
                        (analytics), para que possamos compreender quem são as pessoas que visitam os nossos produtos e
                        quem são usuários dos nossos serviços.</p>
                    <h4>Transferência internacional de dados</h4>
                    <p>Nós coletamos e transferimos dados pessoais coletados no Brasil para os servidores da
                        DigitalOcean, localizado na Holanda. Essa transferência ocorre para armazenamento de dados
                        pessoais.</p>
                    <p>Ao acessar ou usar nossos produtos ou nos fornecer seus dados pessoais, você concorda com o
                        processamento e a transferência de tais dados para para os servidores indicados no parágrafo
                        anterior. Estes Dados poderão estar sujeitos à legislação local e às regras pertinentes.</p>
                    <h4>Por quanto tempo seus dados pessoais são armazenados?</h4>
                    <p>Nós manteremos seus dados Pessoais pelo tempo que for necessário para cumprir com as finalidades para as quais os coletamos, inclusive para fins de cumprimento de quaisquer obrigações legais (como do Marco Civil da Internet de armazenar registros de acesso por 6 meses), contratuais, de prestação de contas ou requisição de autoridades competentes.</p>
                    <h4>Como protegemos seus dados?</h4>
                    <p>Nós estamos sempre tomando providências técnicas, administrativas e organizacionais para proteger seus dados pessoais contra perda, uso não autorizado ou outros abusos. Os dados são armazenados em um ambiente operacional seguro que não é acessível ao público.</p>
                    <p>Nós nos esforçamos para proteger a privacidade dos dados pessoais que mantemos em nossos registros, mas infelizmente não podemos garantir total segurança. A entrada ou uso não autorizado de conta, falha de hardware ou software e outros fatores podem comprometer a segurança dos seus dados pessoais a qualquer momento.</p>
                    <h4>Cookies</h4>
                    <p>Utilizamos cookies em várias páginas de nosso site para que o mesmo funcione corretamente e você tenha uma ótima experiência, <strong>nosso site não funciona adequadamente sem o uso de cookies.</strong></p>
                    <h4>Considerações finais</h4>
                    <p>Ao utilizar nosso sistema significa que você entende e aceita nossa política de privacidade, descrita acima, e está de total acordo com a nossa utilização de seus dados pessoais.</p>
                    <p>Se não concorda com nossa política então <strong>pare imediatamente de utilizar nosso site</strong>.</p>
                    <p>Caso tenha dúvidas a respeito de nossa política de privacidade, sinta-se à vontade para nos enviar um e-mail (contato@webcontabilidade.com) que ficaremos felizes em esclarecer suas dúvidas.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop
