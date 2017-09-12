<div class="modal animated fadeIn" id="modal-agendar-ativacao" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agendar ativação</h3>
            </div>
            <form action="{{route('scheduleEmpresaActivation', $empresa->id)}}" method="POST">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Data de ativação</label>
                            <input class="form-control date-mask" value="{{Carbon\Carbon::today()->format('d/m/Y')}}"
                                   name="ativacao_programada"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-clock-o"></i> Agendar ativação</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
