<!-- Login Modal -->
<div class="modal animated fadeInUpBig" id="modal-access" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Complete os campos e clique em <strong>acessar</strong>.
                </h4>
            </div>
            <form class="form" method="POST" id="login-form" data-validation-url="{{route('loginUser')}}"
                  action="{{route('loginUser')}}">
                <div class="modal-body">
                    @include('index.components.form-alert')
                    {!! csrf_field() !!}
                    <div class='form-group'>
                        <label for="email">E-mail *</label>
                        <input type='text' class='form-control' name='email'/>
                    </div>
                    <div class='form-group'>
                        <label for="senha">Senha *</label>
                        <input type='password' class='form-control' name='senha'/>
                    </div>
                    <div class="checkbox check-primary checkbox-circle">
                        <input type="checkbox" checked="checked" value="1" name="remember" id="remember">
                        <label for="remember"> Lembrar de mim</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" data-dismiss="modal" data-toggle="modal" data-target="#modal-forgot" class="btn btn-link"
                       id="forgotPasswordLink">Esqueci minha senha</a>
                    <button class="btn btn-complete"><span class="fa fa-sign-in"></span> Acessar</button>
                    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>