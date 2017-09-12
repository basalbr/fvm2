<div class="modal animated fadeIn" id="modal-cancelar-ativacao" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cancelar ativação</h3>
            </div>
                <div class="modal-body">
                    <p>A ativação dessa empresa está programada para <strong>{{$empresa->ativacao_programada->format('d/m/Y') }}</strong>.</p>
                    <p>Tem certeza que deseja cancelar esse agendamento?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('unscheduleEmpresaActivation', $empresa->id)}}" class="btn btn-danger">Sim, cancele</a>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                </div>
        </div>
    </div>
</div>
