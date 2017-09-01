<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="pendentes">
    <div class="form-group">
        <label>Buscar por</label>
        <input name="busca" class="form-control" value="{{request('busca')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="nome_asc" {{request('ordenar')=='nome_asc' ? 'selected':''}}>Nome (A-Z)</option>
            <option value="nome_desc" {{request('ordenar')=='nome_desc' || !request('ordenar') ? 'selected':''}}>
                Nome (Z-A)
            </option>
            <option value="empresa_asc" {{request('ordenar')=='empresa_asc' ? 'selected':''}}>Empresa (A-Z)
            </option>
            <option value="empresa_desc" {{request('ordenar')=='empresa_desc' ? 'selected':''}}>Empresa (Z-A)
            </option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>