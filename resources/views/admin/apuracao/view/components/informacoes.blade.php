<div class="list">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Empresa</label>
            <div class="form-control"><a href="{{route('showEmpresaToAdmin', $apuracao->empresa->id)}}">{{$apuracao->empresa->nome_fantasia}}</a></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Usuário</label>
            <div class="form-control"><a href="{{route('showUsuarioToAdmin', $apuracao->empresa->usuario->id)}}">{{$apuracao->empresa->usuario->nome}}</a></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Imposto</label>
            <div class="form-control">{{$apuracao->imposto->nome}}</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Status da apuração</label>
            <div class="form-control">{{$apuracao->status}}</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Competência</label>
            <div class="form-control">{{$apuracao->competencia->format('m/Y')}}</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Vencimento</label>
            <div class="form-control">{{$apuracao->vencimento->format('d/m/Y')}}</div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<hr>
<div class="col-sm-12">
    <h3>Status e envio de guia</h3>
</div>
<form id="form-principal" method="POST" action="" enctype="multipart/form-data">
    {!! csrf_field() !!}
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
    <div class="col-sm-12">
        <button class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
    </div>
</form>