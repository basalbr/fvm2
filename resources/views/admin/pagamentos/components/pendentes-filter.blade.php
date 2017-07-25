<form class="form-inline">
    @include('admin.components.disable-auto-complete')
    <input type="hidden" name="tab" value="pendentes">
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
            <option {{request('status')=='Aguardando pagamento' ? 'selected':''}} value="Aguardando pagamento">Aguardando
                pagamento
            </option>
            <option {{request('status')=='Cancelada' ? 'selected':''}} value="Cancelada">Cancelada</option>
            <option {{request('status')=='Em análise' ? 'selected':''}} value="Em análise">Em análise</option>
            <option {{request('status')=='Pendente' ? 'selected':''}} value="Pendente">Pendente</option>
        </select>
    </div>
    <div class="form-group">
        <label>Aberto de</label>
        <input style="max-width: 90px" name="aberto_de" class="form-control date-mask" value="{{request('aberto_de')}}"/>
    </div>
    <div class="form-group">
        <label>Aberto até</label>
        <input style="max-width: 90px" name="aberto_ate" class="form-control date-mask" value="{{request('aberto_ate')}}"/>
    </div>
    <div class="form-group">
        <label>Venc. de</label>
        <input style="max-width: 90px" name="vencimento_de" class="form-control date-mask" value="{{request('vencimento_de')}}"/>
    </div>
    <div class="form-group">
        <label>Venc. até</label>
        <input style="max-width: 90px" name="vencimento_ate" class="form-control date-mask" value="{{request('vencimento_ate')}}"/>
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
            <option value="vencimento_asc" {{request('ordenar')=='vencimento_asc' ? 'selected':''}}>Vencimento em (A-Z)
            </option>
            <option value="vencimento_desc" {{request('ordenar')=='vencimento_desc' ? 'selected':''}}>Vencimento em
                (Z-A)
            </option>
            <option value="usuario_asc" {{request('ordenar')=='usuario_asc' ? 'selected':''}}>Usuário (A-Z)</option>
            <option value="usuario_desc" {{request('ordenar')=='usuario_desc' ? 'selected':''}}>Usuário (Z-A)</option>
        </select>
    </div>
    <div class="clearfix"></div>
    <button class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
    <hr>
</form>