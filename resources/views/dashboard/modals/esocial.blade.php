@if(!isset($_COOKIE['esocial-read']))
    @if(Auth::user()->empresas()->where('status', 'aprovado')->where('certificado_digital', null)->count())
        <script type="text/javascript">
            $(function () {
                $('#modal-esocial').modal('show');
                $('#modal-esocial .btn-default').on('click', function () {
                    if ($(this).parent().find($('[type="checkbox"]')).is(':checked')) {
                        document.cookie = 'esocial-read=true';
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