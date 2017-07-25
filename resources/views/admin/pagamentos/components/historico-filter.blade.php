<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="historico">
    <div class="form-group">
        <label>Tipo</label>
        <select name="tipo" class="form-control">
            <option value="">Todos</option>
            <option {{request('tipo')=='abertura_empresa' ? 'selected':''}} value="abertura_empresa">Abertura de
                Empresa
            </option>
            <option {{request('tipo')=='alteracao' ? 'selected':''}} value="alteracao">Alteração</option>
            <option {{request('tipo')=='mensalidade' ? 'selected':''}} value="mensalidade">Mensalidade</option>
        </select>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="">Todos</option>
            <option {{request('status')=='Disponível' ? 'selected':''}} value="Disponível">Disponível</option>
            <option {{request('status')=='Paga' ? 'selected':''}} value="Paga">Paga</option>
        </select>
    </div>
    <div class="form-group">
        <label>Aberto de</label>
        <input style="max-width: 90px" name="aberto_de" class="form-control date-mask"
               value="{{request('aberto_de')}}"/>
    </div>
    <div class="form-group">
        <label>Aberto até</label>
        <input style="max-width: 90px" name="aberto_ate" class="form-control date-mask"
               value="{{request('aberto_ate')}}"/>
    </div>
    <div class="form-group">
        <label>Pago de</label>
        <input style="max-width: 90px" name="pago_de" class="form-control date-mask"
               value="{{request('pago_de')}}"/>
    </div>
    <div class="form-group">
        <label>Pago até</label>
        <input style="max-width: 90px" name="pago_ate" class="form-control date-mask"
               value="{{request('pago_ate')}}"/>
    </div>
    <div class="form-group">
        <label>Buscar por</label>
        <input name="busca" class="form-control" value="{{request('busca')}}"/>
    </div>
    <div class="form-group">
        <label>Ordenar por</label>
        <select name="ordenar" class="form-control">
            <option value="aberto_asc" {{request('ordenar')=='aberto_asc' ? 'selected':''}}>Aberto em (A-Z)</option>
            <option value="aberto_desc" {{request('ordenar')=='aberto_desc' || !request('ordenar') ? 'selected':''}}>
                Aberto em (Z-A)
            </option>
            <option value="pago_asc" {{request('ordenar')=='pago_asc' ? 'selected':''}}>Pago em (A-Z)
            </option>
            <option value="pago_desc" {{request('ordenar')=='pago_desc' ? 'selected':''}}>Pago em Z-A)
            </option>
            <option value="usuario_asc" {{request('ordenar')=='usuario_asc' ? 'selected':''}}>Usuário (A-Z)</option>
            <option value="usuario_desc" {{request('ordenar')=='usuario_desc' ? 'selected':''}}>Usuário (Z-A)</option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>