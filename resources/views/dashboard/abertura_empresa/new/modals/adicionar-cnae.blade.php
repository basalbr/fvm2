<!-- Adicionar Sócio Modal -->
<div class="modal animated fadeInUpBig" id="modal-socio" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Adicionar Sócio.</h3>
            </div>

            <div class="modal-body">
                <form class="form" data-validation-url="{{route('loginUser')}}" action="">
                    @include('dashboard.components.form-alert')
                    {{csrf_field()}}
                    <div class="col-xs-12">
                        <h4>Informações</h4>
                        <hr>
                    </div>
                    <div class="col-xs-12">
                        <div class='form-group'>
                            <label for="">É o sócio principal? *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Nome completo *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Nome da mãe *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Nome do pai *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="">Data de Nascimento *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Estado civil *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class='form-group'>
                            <label for="">Regime de casamento *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="">Nacionalidade *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class='form-group'>
                            <label for="">E-mail *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Telefone *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="">CPF *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="">RG *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class='form-group'>
                            <label for="">Órgão Expedidor do RG (Ex: SSP/SC) *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <h4>Endereço</h4>
                        <hr>
                    </div>
                    <div class="col-xs-2">
                        <div class='form-group'>
                            <label for="">CEP *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="">Estado *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Cidade *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class='form-group'>
                            <label for="">Bairro *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class='form-group'>
                            <label for="">Endereço *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class='form-group'>
                            <label for="">Número *</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class='form-group'>
                            <label for="">Complemento</label>
                            <input type='text' class='form-control' name=''/>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success"><i class="fa fa-plus"></i> Adicionar Sócio</button>
                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>