<!-- Register Modal -->
<div class="modal fade" id="modal-register" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Complete os campos e clique em <strong>cadastrar</strong>.
                </h4>
            </div>
            <div class="modal-body">
                <form class="form">
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
                        <input type='text' class='form-control' name='telefone'/>
                    </div>
                    <div class='form-group'>
                        <label for="senha">Senha *</label>
                        <input type='password' class='form-control' name='senha'/>
                    </div>
                    <div class='form-group'>
                        <label for="senha_confirmation">Confirme sua senha *</label>
                        <input type='password' class='form-control' name='senha_confirmation'/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-complete"><span class="fa fa-check-square-o"></span> Cadastrar</button>
                <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-remove"></span> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>