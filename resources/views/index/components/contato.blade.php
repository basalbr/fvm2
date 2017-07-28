
<img class="background-img" src="{{asset(public_path('images/contato.jpg'))}}"/>
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
                <a href="whatsapp://send?phone=+55{{\App\Models\Config::getWhatsApp()}}&abid=+55{{\App\Models\Config::getWhatsApp()}}" class="whatsapp">
                    <img src="{{asset(public_path('images/whatsapp.png'))}}"/>
                    <div>Pelo whatsapp<br/> {{\App\Models\Config::getWhatsApp()}}</div>
                </a>
            </div>
            <div class="col-xs-12 hidden-xs">
                <div class="clearfix"></div>
                <div id="fb-root"></div>

                <div class="fb-page" style="height: 260px; width: 340px"
                     data-href="https://www.facebook.com/WEBContabilidade-1762521307351768/"
                     data-tabs="messages" data-height="260" data-small-header="true"
                     data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                </div>
            </div>

    </div>
</div>