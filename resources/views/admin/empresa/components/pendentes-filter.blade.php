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
            <option value="empresa_asc" {{request('ordenar')=='empresa_asc' || !request('ordenar') ? 'selected':''}}>Nome Fantasia (A-Z)
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