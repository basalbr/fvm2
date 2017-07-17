<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="pendentes">
    <div class="form-group">
        <label>Tipo de alteração</label>
        <select name="tipo" class="form-control">
            <option value="">Todos</option>
            @foreach(\App\Models\TipoAlteracao::orderBy('descricao')->get() as $tipo)
                <option value="{{$tipo->id}}" {{request('tipo') == $tipo->id ? 'selected' : ''}}>{{$tipo->descricao}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Usuário</label>
        <input name="usuario" class="form-control" value="{{request('usuario')}}"/>
    </div>
    <div class="form-group">
        <label>Empresa</label>
        <input name="empresa" class="form-control" value="{{request('empresa')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="criado_asc" {{request('ordenar')=='criado_asc' ? 'selected':''}}>Criado em (A-Z)</option>
            <option value="criado_desc" {{request('ordenar')=='criado_desc' || !request('ordenar') ? 'selected':''}}>
                Criado em (Z-A)
            </option>
            <option value="empresa_asc" {{request('ordenar')=='empresa_asc' ? 'selected':''}}>Nome Fantasia (A-Z)
            </option>
            <option value="empresa_desc" {{request('ordenar')=='empresa_desc' ? 'selected':''}}>Nome Fantasia (Z-A)
            </option>
            <option value="usuario_asc" {{request('ordenar')=='usuario_asc' ? 'selected':''}}>Usuário (A-Z)</option>
            <option value="usuario_desc" {{request('ordenar')=='usuario_desc' ? 'selected':''}}>Criado em (Z-A)</option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>