<div role="tabpanel" class="tab-pane active" id="tab-modal-geral">
    <p class="alert-info alert" style="display: block">Complete os dados com as informações solicitadas.<br/><strong>Campos
            com * são
            obrigatórios.</strong></p>


    <div class="col-xs-12">
        <div class="form-group">
            <label>Tipo de Dependente *</label>
            <select name="id_ir_tipo_dependente" class="form-control">
                <option value="">Selecione uma opção</option>
                @foreach($tiposDependente as $tipo)
                    <option title="{{ $tipo->descricao }}" value="{{$tipo->id}}">{{ $tipo->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Nome Completo *</label>
            <input name="nome" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Data de Nascimento *</label>
            <input name="data_nascimento" class="date-mask form-control">
        </div>
    </div>
    @include('dashboard.imposto_renda.new.components.upload', ['descricao'=>'CPF', 'referencia'=>'cpf'])
    @include('dashboard.imposto_renda.new.components.upload', ['descricao'=>'Título de Eleitor', 'referencia'=>'rg'])
    <div class="clearfix"></div>
</div>