<div role="tabpanel" class="tab-pane animated fadeIn" id="tab-documentos-enviados">
    <div class="col-xs-12">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Documentos enviados</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="lista_documentos_enviados">
            <tr class="none">
                <td colspan="2">Nenhum documento enviado</td>
            </tr>
            @foreach($ir->anexos as $anexo)
                <tr data-anexo="{{$anexo->id}}">
                    <td>{{$anexo->descricao}}</td>
                    <td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td>
                </tr>
            @endforeach
            @if($ir->recibo_anterior)
                <tr data-link="recibo_anterior">
                    <td>Cópia do recibo da declaração de 2017</td>
                    <td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td>
                </tr>
                <input type="hidden" name="recibo_anterior" value="{{$ir->recibo_anterior}}"/>
            @endif
            @if($ir->declaracao_anterior)
                <tr data-link="declaracao_anterior">
                    <td>Cópia da declaração de 2017</td>
                    <td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td>
                </tr>
                <input type="hidden" name="declaracao_anterior" value="{{$ir->declaracao_anterior}}"/>
            @endif
            @if($ir->declarante->comprovante_residencia)
                <tr data-link="comprovante_residencia">
                    <td>Comprovante de Residência</td>
                    <td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td>
                </tr>
                <input type="hidden" name="comprovante_residencia" value="{{$ir->declarante->comprovante_residencia}}"/>
            @endif
            @if($ir->declarante->cpf)
                <tr data-link="cpf">
                    <td>CPF</td>
                    <td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td>
                </tr>
                <input type="hidden" name="cpf" value="{{$ir->declarante->cpf}}"/>
            @endif
            @if($ir->declarante->titulo_eleitor)
                <tr data-link="titulo_eleitor">
                    <td>Título Eleitor</td>
                    <td><a class="btn-danger btn"><i class="fa fa-remove"></i> Excluir</a></td>
                </tr>
                <input type="hidden" name="titulo_eleitor" value="{{$ir->declarante->titulo_eleitor}}"/>
            @endif
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
</div>