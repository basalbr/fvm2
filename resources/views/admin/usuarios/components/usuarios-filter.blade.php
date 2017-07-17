<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="usuarios">
    <div class="form-group">
        <label>Buscar por</label>
        <input name="busca" class="form-control" value="{{request('busca')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="email_asc" {{request('ordenar')=='email_asc'  ? 'selected':''}}>E-mail (A-Z)
            </option>
            <option value="email_desc" {{request('ordenar')=='email_desc' ? 'selected':''}}>E-mail (Z-A)
            </option>
            <option value="usuario_asc" {{request('ordenar')=='usuario_asc' || !request('ordenar') ? 'selected':''}}>Usuário (A-Z)</option>
            <option value="usuario_desc" {{request('ordenar')=='usuario_desc' ? 'selected':''}}>Usuário (Z-A)</option>
            <option value="criado_asc" {{request('ordenar')=='criado_asc' ? 'selected' : ''}}>Cadastrado em (A-Z)</option>
            <option value="criado_desc" {{request('ordenar')=='criado_desc' ? 'selected' : ''}}>Cadastrado em (Z-A)</option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>