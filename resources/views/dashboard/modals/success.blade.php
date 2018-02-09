@if(Session::get('successAlert'))
    <script type="text/javascript">
        $(function () {
            $('#modal-success').modal('show');
        });
    </script>
    <div class="modal animated fadeIn" id="modal-success" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Sucesso</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <br/>
                        <p class="message">{!! session('successAlert') !!}</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
