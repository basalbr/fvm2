<!-- Register Modal -->
<div class="modal animated fadeInUpBig" id="modal-register" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Complete os campos e clique em <strong>cadastrar</strong>.
                </h4>
            </div>
            <form class="form" method="POST" action="{{route('registerUser')}}" id="register-form"
                  data-validation-url="{{route('validateUserRegistration')}}">
                <div class="modal-body">
                    @include('index.components.form-alert')
                    {{ csrf_field() }}
                    <div class='form-group'>
                        <label for="nome">Nome completo *</label>
                        <input type='text' class='form-control' name="nome"/>
                        <div class="clearfix"></div>
                    </div>
                    <div class='form-group'>
                        <label for="email">E-mail *</label>
                        <input type='text' class='form-control' name='email'/>
                    </div>
                    <div class='form-group'>
                        <label for="email">Telefone ou celular *</label>
                        <input type='text' class='form-control phone phone-mask' name='telefone'/>
                    </div>
                    <div class='form-group'>
                        <label for="senha">Senha *</label>
                        <input type='password' class='form-control' name='senha'/>
                    </div>
                    <div class='form-group'>
                        <label for="senha_confirmation">Confirme sua senha *</label>
                        <input type='password' class='form-control' name='senha_confirmation'/>
                    </div>
                    <div class="checkbox check-primary checkbox-circle">
                        <input type="checkbox" value="1" name="contrato" id="contrato_chk" required>
                        <label for="contrato_chk"> Eu aceito os termos do contrato (<span id="contrato">ver contrato</span>)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="goog_report_conversion('{{route('registerUser')}}')" class="btn btn-complete"><span
                                class="fa fa-check-square-o"></span> Cadastrar
                    </button>
                    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>