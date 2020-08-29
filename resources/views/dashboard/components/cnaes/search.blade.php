@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/dashboard/modules/cnaes.js')}}"></script>
@stop
@section('modals')
    @parent
    <!-- Adicionar Sócio Modal -->
    <div class="modal animated fadeInUpBig" id="modal-cnae" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Pesquisar CNAEs</h3>
                </div>

                <div class="modal-body">
                    <form class="form" data-validation-url="{{route('searchCnaeByDescription')}}" action="">
                        {{csrf_field()}}
                        <div class="alert alert-info" style="display:block">
                            <p>Digite a descrição ou parte dela para pesquisar um CNAE. <strong>Após isso clique em
                                adicionar.</strong></p>
                        </div>
                        <div class="clearfix"></div>
                        @include('dashboard.components.form-alert')

                        <div class="col-xs-12">
                            <div class='form-group'>
                                <label for="">Descrição do CNAE *</label>
                                <input data-search-description-url="{{route('searchCnaeByDescription')}}" type='text'
                                       class='form-control' name='' id="cnae-description"/>
                            </div>
                            <button type='button' class='btn btn-primary' id="cnae-search"><i class="fa fa-search"></i>
                                Pesquisar
                            </button>
                            <hr>
                        </div>

                        <div class="col-xs-12">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Código / Descrição</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <tr class="none">
                                    <td colspan="2">Nenhum CNAE encontrado</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop