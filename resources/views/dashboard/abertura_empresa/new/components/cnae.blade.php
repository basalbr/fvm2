<div class="col-xs-12">
    <h3>CNAEs</h3>
    <hr>
</div>
<div class="col-xs-12">
    <p>Digite o código do CNAE que deseja adicionar no campo abaixo e clique em <strong>Adicionar CNAE</strong>.<br/>É possível procurar por um CNAE utilizando o botão <strong>Pesquisar CNAE</strong>.</p>
</div>
<div class="col-lg-7 col-xs-12">
    <div class="form-group input-group">
        <label for="cnae-code">Código</label>
        <input class="form-control cnae-mask" id="cnae-code" data-search-code-url="{{route('searchCnaeByCode')}}"/>
        <span class="input-group-btn">
          <button type="button" class="btn btn-success" id="cnae-add-code"><i class="fa fa-plus"></i> Adicionar CNAE
        </button>
      </span>
    </div>
</div>
<div class="col-lg-offset-5 visible-lg"></div>
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
        <tbody  id="list-cnaes">
        <tr class="none">
            <td colspan="3">Nenhum CNAE adicionado</td>
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