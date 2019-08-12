<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="pendentes">
    <div class="form-group">
        <label>De</label>
        <input style="max-width: 90px" name="de" class="form-control date-mask" value="{{request('de')}}"/>
    </div>
    <div class="form-group">
        <label>Até</label>
        <input style="max-width: 90px" name="ate" class="form-control date-mask" value="{{request('ate')}}"/>
    </div>
    <div class="form-group">
        <label>Usuário</label>
        <input name="usuario" class="form-control" value="{{request('usuario')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="data_asc" {{request('ordenar')=='data_asc'  || !request('ordenar')? 'selected':''}}>Data
                (A-Z)
            </option>
            <option value="data_desc" {{request('ordenar')=='data_desc' ? 'selected':''}}>
                Data (Z-A)
            </option>
            <option value="usuario_asc" {{request('ordenar')=='usuario_asc' ? 'selected':''}}>Usuário (A-Z)</option>
            <option value="usuario_desc" {{request('ordenar')=='usuario_desc' ? 'selected':''}}>Usuário em (Z-A)
            </option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>