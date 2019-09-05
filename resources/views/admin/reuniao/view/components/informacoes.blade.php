<div class="col-sm-6">
    <div class="form-group">
        <label>Usuário</label>
        <div class="form-control"><a
                    href="{{route('showUsuarioToAdmin', $reuniao->usuario->id)}}">{{$reuniao->usuario->nome}}</a>
        </div>
    </div>
</div>
<p class="alert-info alert" style="display: block">Abaixo estão todas as informações dessa solicitação.</p>
<div class="col-sm-6">
    <div class="form-group">
        <label>Data</label>
        <div class="form-control">{{$reuniao->data->format('d/m/Y')}} (<strong>{{$reuniao->quantoFalta()}}</strong>)</div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Horário</label>
        <div class="form-control">{{$reuniao->horario->hora_inicial}}
            - {{$reuniao->horario->hora_final}}</div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label>Status</label>
        <div class="form-control">{!! $reuniao->getLabelStatus() !!} {!! $reuniao->pagamento->isPending() ? '<span class="label label-warning">Pagamento pendente</span>' : ''!!}</div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label>Assunto</label>
        <div class="form-control">{{$reuniao->assunto}}</div>
    </div>
</div>

<div class="clearfix"></div>
<hr>
<div class="col-sm-12">
    <h3>Status</h3>
</div>
<form id="form-principal" method="POST" action="" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="col-sm-12">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option {{$reuniao->status == 'em_analise' ? 'selected' : ''}} value="em_analise">Em análise
                </option>
                <option {{$reuniao->status == 'data_invalida' ? 'selected' : ''}} value="data_invalida">Data inválida
                </option>
                <option {{$reuniao->status == 'cancelado' ? 'selected' : ''}} value="cancelado">Cancelado
                </option>
                <option {{$reuniao->status == 'aprovado' ? 'selected' : ''}} value="aprovado">Aprovado
                </option>
                <option {{$reuniao->status == 'aguardando_usuario' ? 'selected' : ''}} value="aguardando_usuario">Aguardando resposta
                </option>
                <option {{$reuniao->status == 'concluido' ? 'selected' : ''}} value="concluido">Concluído
                </option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <button class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
    </div>
</form>
<div class="clearfix"></div>