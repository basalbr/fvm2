<div class="modal animated fadeIn" id="modal-realizar-acao" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Status e envio de guia</h3>
            </div>

            <form id="form-principal" method="POST" action="" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Status da apuração</label>
                        <select name="status" class="form-control">
                            <option {{$apuracao->status == 'Atenção' ? 'selected' : ''}} value="atencao">Atenção
                            </option>
                            <option {{$apuracao->status == 'Cancelado' ? 'selected' : ''}} value="cancelado">Cancelado
                            </option>
                            <option {{$apuracao->status == 'Concluído' ? 'selected' : ''}} value="concluido">Concluído
                            </option>
                            <option {{$apuracao->status == 'Novo' ? 'selected' : ''}} value="novo">Novo</option>
                            <option {{$apuracao->status == 'Sem Movimento' ? 'selected' : ''}} value="sem_movimento">Sem
                                Movimento
                            </option>
                        </select>
                    </div>
                    </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="form-control">
                            <button class="btn btn-primary upload-file"><i class="fa fa-upload"></i>
                                Anexar guia
                            </button>
                        </div>
                        <input data-validation-url="{{route('validateGuia')}}"
                               data-upload-url="{{route('sendAnexoToTemp')}}" class="hidden upload-informacao-extra"
                               type='file' value=""/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Notas de Serviço</label>
                        <input type="text" name="qtde_notas_servico" class="form-control number-mask" placeholder="0" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Notas de Entrada</label>
                        <input type="text" name="qtde_notas_entrada"  class="form-control number-mask" placeholder="0" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Notas de Saída</label>
                        <input type="text" name="qtde_notas_saida" class="form-control number-mask" placeholder="0" />
                    </div>
                </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success"><i class="fa fa-check"></i> Concluir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
