<div class="modal animated fadeIn" id="modal-video-ajuda" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">@yield('modal-video-ajuda-titulo')</h3>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 text-center">
                    @yield('modal-video-ajuda-embed')
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
<script type="text/javascript">
    $(function () {
        $('#btn-ajuda').tooltip('show');
        setTimeout(function () {
            $('#btn-ajuda').tooltip('hide');
        }, 4000);
    })
</script>
