<div class="container">
    <div class="col-xs-12">
        <h1 class="hidden-xs">Entre em contato conosco</h1>
        <h1 class="visible-xs">Contato</h1>
        <h3>Envie uma mensagem pelo formulário ou visite a gente nas redes sociais!</h3>
    </div>
    <div class="clearfix"></div>

    <div class="col-sm-6 col-xs-12">
        <form class="form" id="contato-form" data-validation-url="{{route('validateContato')}}"
              data-url="{{route('sendContato')}}">
            {!! csrf_field() !!}
            @include('index.components.form-alert')
            <div class='form-group'>
                <label for="nome">Seu nome *</label>
                <input type='text' class='form-control' name="nome"/>
                <div class="clearfix"></div>
            </div>
            <div class='form-group'>
                <label for="email">Seu e-mail *</label>
                <input type='text' class='form-control' name='email'/>
            </div>
            <div class='form-group'>
                <label for="mensagem">Sua mensagem *</label>
                <textarea class='form-control' name='mensagem'></textarea>
            </div>
            <div class="clearfix"></div>
            <div class="">
                <button class="btn btn-complete" type="button"><span class="fa fa-send"></span> Enviar mensagem
                </button>
            </div>
        </form>
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="col-xs-12">
            <a href="whatsapp://send?phone=+55{{\App\Models\Config::getWhatsApp()}}&abid=+55{{\App\Models\Config::getWhatsApp()}}"
               class="whatsapp">
                <img src="{{asset(public_path('images/whatsapp.png'))}}"/>
                <div>Pelo whatsapp<br/> {{\App\Models\Config::getWhatsApp()}}</div>
            </a>
        </div>
    </div>
    <div class="col-xs-12 text-center bg-primary" style="color: #fff">
        <br />
        <p><strong>WEBContabilidade é um escritório administrativo que fica em Blumenau/SC, mas atende online diversas
                cidades no Brasil inteiro. Conosco você tem disponível sua contabilidade online, gerencia folha de
                pagamentos, impostos e relatórios gerenciais. Conforme determinação legal, as atividades contábeis são
                prestadas unicamente pela empresa I9 Contabilidade e Gestão Empresarial LTDA através de seus colaboradores apaixonados por
                contabilidade. A WEBContabilidade é empresa parceira que viabiliza o software inteligente, realiza
                inovações tecnológicas possibilitando sempre a melhor plataforma contábil online e presta os serviços
                administrativos necessários para facilitar sua contabilidade. A WEBContabilidade e a I9 Contabilidade e Gestão Empresarial LTDA
                atuam em parceria e atendem a todas as exigências legais.</strong></p>
        <p><strong>I9 Contabilidade e Gestão Empresarial LTDA, escritório contábil, Conselho Regional de Contabilidade:
                SC-009123/O</strong></p>
        <p><strong>Silmara Batista Baseggio, contadora responsável, Conselho Regional de Contabilidade:
                SC-032380/O-5</strong></p>
    </div>
</div>
