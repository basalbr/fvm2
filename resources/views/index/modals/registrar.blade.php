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
                        <label for="contrato_chk"> Eu aceito os termos do contrato</label>

                    </div>

                </div>
                <div class="modal-footer">
                    <div class="hidden-xs">
                        <a href="#" data-toggle="modal" data-target="#modal-contrato" class="btn btn-info"><strong><i class="fa fa-file-o"></i> Ler contrato</strong></a>
                        <button type="button" onclick="goog_report_conversion('{{route('registerUser')}}')"
                                class="btn btn-complete"><span
                                    class="fa fa-check-square-o"></span> Cadastrar
                        </button>
                        <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Fechar
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-sm-12 visible-xs text-center btn-block">
                        <a href="#" data-toggle="modal" data-target="#modal-contrato" class="btn btn-info"><strong><i class="fa fa-file-o"></i> Ler contrato</strong></a>
                        <div class="clearfix"></div>
                        <br />
                        <button type="button" onclick="goog_report_conversion('{{route('registerUser')}}')"
                                class="btn btn-complete"><span
                                    class="fa fa-check-square-o"></span> Cadastrar
                        </button>
                        <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Fechar
                        </button>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>