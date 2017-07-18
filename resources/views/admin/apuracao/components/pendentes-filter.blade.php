<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="pendentes">
    <div class="form-group">
        <label>Imposto</label>
        <select name="imposto" class="form-control">
            <option value="">Todos</option>
            @foreach(\App\Models\Imposto::orderBy('nome')->get() as $imposto)
                <option value="{{$imposto->id}}" {{request('imposto') == $imposto->id ? 'selected' : ''}}>{{$imposto->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="">Todos</option>
            <option value="novo" {{request('status') == 'novo' ? 'selected' : ''}}>Novo</option>
            <option value="informacoes_enviadas" {{request('status') == 'informacoes_enviadas' ? 'selected' : ''}}>Informações enviadas</option>
            <option value="atencao" {{request('status') == 'atencao' ? 'selected' : ''}}>Atenção</option>
        </select>
    </div>
    <div class="form-group">
        <label>De</label>
        <input style="max-width: 90px" name="de" class="form-control date-mask" value="{{request('de')}}"/>
    </div>
    <div class="form-group">
        <label>Até</label>
        <input style="max-width: 90px" name="ate" class="form-control date-mask" value="{{request('ate')}}"/>
    </div>
    <div class="form-group">
        <label>Buscar por</label>
        <input name="busca" class="form-control" value="{{request('busca')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="periodo_asc" {{request('ordenar')=='periodo_asc' ? 'selected':''}}>Período (A-Z)</option>
            <option value="periodo_desc" {{request('ordenar')=='periodo_desc' || !request('ordenar') ? 'selected':''}}>
                Período (Z-A)
            </option>
            <option value="empresa_asc" {{request('ordenar')=='empresa_asc' ? 'selected':''}}>Nome Fantasia (A-Z)
            </option>
            <option value="empresa_desc" {{request('ordenar')=='empresa_desc' ? 'selected':''}}>Nome Fantasia (Z-A)
            </option>
            <option value="razao_social_asc" {{request('ordenar')=='razao_social_asc' ? 'selected':''}}>Razão Social (A-Z)</option>
            <option value="razao_social_desc" {{request('ordenar')=='razao_social_desc' ? 'selected':''}}>Razão Social (Z-A)</option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>