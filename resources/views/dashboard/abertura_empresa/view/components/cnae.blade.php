<div class="col-xs-12">
    <h3>CNAEs</h3>
    <hr>
</div>
<div class="col-xs-12">
    <p>Digite o código do CNAE que deseja adicionar no campo abaixo e clique em <strong>Adicionar CNAE</strong>.<br/>É
        possível procurar por um CNAE utilizando o botão <strong>Pesquisar CNAE</strong>.</p>
</div>
<div class="clearfix"></div>
<br/>
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Descrição</th>
            <th class="cnae-code">Código</th>
        </tr>

        </thead>
        <tbody id="list-cnaes">
        @if(count($aberturaEmpresa->cnaes))
            @foreach($aberturaEmpresa->cnaes as $cnae)
                <tr>
                    <td>{{$cnae->cnae->descricao}}</td>
                    <td>{{$cnae->cnae->codigo}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2">Nenhum CNAE adicionado</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
