<!-- Recuperar senha Modal -->
<div class="modal animated fadeInUpBig" id="modal-forgot" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Complete os campos e clique em <strong>recuperar senha</strong>.
                </h4>
            </div>
            <form class="form" id="forgot-form" data-validation-url="{{route('forgotPasswordUser')}}" method="POST"
                  action="">

                {{csrf_field()}}
                <div class="modal-body">
                    @include('index.components.form-alert')
                    <div class='form-group'>
                        <label for="email">E-mail *</label>
                        <input type='text' class='form-control' name='email'/>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button class="btn btn-complete"><span class="fa fa-sign-in"></span> Recuperar senha</button>
                        <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Cancelar
                        </button>
                    </div>

                </div>
            </form>
            <div class="success">
                <div class="modal-body">

                    <div class="alert alert-success">
                        <p>Enviamos um e-mail para que você possa alterar sua senha.</p>
                        <p> Não esqueça de olhar sua caixa
                            de
                            SPAM!</p>
                        <p>Caso não tenha recebido o e-mail, entre em contato conosco.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>