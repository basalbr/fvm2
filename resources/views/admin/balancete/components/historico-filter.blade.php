<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="historico">
    <div class="form-group">
        <label>Buscar por</label>
        <input name="busca" class="form-control" value="{{request('busca')}}"/>
    </div>
    <div class="form-group">
        <label>Exercício de</label>
        <input style="max-width: 90px" name="exercicio_de" class="form-control month-mask" value="{{request('exercicio_de')}}"/>
    </div>
    <div class="form-group">
        <label>Exercício até</label>
        <input style="max-width: 90px" name="exercicio_ate" class="form-control month-mask" value="{{request('exercicio_ate')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="exercicio_asc" {{request('ordenar')=='periodo_asc' ? 'selected':''}}>Exercício (A-Z)</option>
            <option value="exercicio_desc" {{request('ordenar')=='periodo_desc' || !request('ordenar') ? 'selected':''}}>
                Exercício (Z-A)
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