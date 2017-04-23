<div class="col-xs-12">
    <h3>CNAEs</h3>
    <hr>
</div>
<div class="col-xs-12">
    <p>Digite o código do CNAE que deseja adicionar no campo abaixo e clique em <strong>Adicionar CNAE</strong>.<br/>É possível procurar por um CNAE utilizando o botão <strong>Pesquisar CNAE</strong>.</p>
</div>
<div class="col-xs-12">
    <div class="form-group input-group">
        <label>Código</label>
        <input class="form-control" id="cnae_codigo"/>
        <span class="input-group-btn">
          <button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar CNAE
        </button>
      </span>
    </div>
</div>
<div class="col-xs-12">
    <div class="btn-group">
        <button type="button" class="btn btn-primary open-modal" data-modal="#modal-cnae"><i class="fa fa-search"></i>
            Pesquisar CNAE
        </button>
    </div>
</div>
<div class="clearfix"></div>
<br />
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Descrição</th>
            <th>Código</th>
            <th>Opções</th>
        </tr>

        </thead>
        <tbody>
        <tr id="list-cnaes">
            <td colspan="3" class="none">Nenhum CNAE adicionado</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - Sócios</button>
    <button class="btn btn-primary next">Avançar - Detalhes <span class="fa fa-angle-right"></span>
    </button>
</div>