<div class="col-xs-12">
    <h3>CNAEs</h3>
    <hr>
</div>
<div class="col-xs-12">
    <p>Abaixo está a lista dos CNAEs relacionados à sua empresa.</p>
</div>
<div class="clearfix"></div>
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Descrição</th>
            <th class="cnae-code">Código</th>
        </tr>

        </thead>
        <tbody id="list-cnaes">
        @if(count($empresa->cnaes))
            @foreach($empresa->cnaes as $cnae)
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
