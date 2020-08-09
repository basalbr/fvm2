@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#tributacao [type="checkbox"]').on('change', function (e) {
                var imposto = $('#tributacao thead th:eq(' + $(this).val() + ')').text();
                if ($(this).prop('checked')) {
                    updateIsencaoTributacao($(this), imposto, 'adicionar');
                } else {
                    updateIsencaoTributacao($(this), imposto, 'remover');
                }
            })
        });

        function updateIsencaoTributacao(elem, imposto, action) {
            $.post(elem.data('url'), {'imposto': imposto, 'action': action}
            ).done(function (jqXHR) {
                console.log(jqXHR);
            }).fail(function (jqXHR) {
                console.log(jqXHR);
            });
        }
    </script>
@stop
<div class="col-xs-12">
    <p class="alert alert-info" style="display: block"><strong>Digite o nome do CFOP ou Anexo</strong> que será
        utilizado na apuração para conferência de notas.</p>
</div>
<div class="clearfix"></div>
<form method="post" action="{{route('addTributacaoToEmpresa', $empresa->id)}}">
    <input type="hidden" name="tab" value="tributacao"/>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Descrição</label>
            <input name="descricao" type="text" class="form-control"/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Mercado</label>
            <select class="form-control" name="mercado">
                <option value="interno" selected="selected">Interno/Vendas no Brasil</option>
                <option value="externo">Externo/Vendas no exterior</option>
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Tabela do Simples Nacional</label>
            <select class="form-control" name="id_tabela_simples_nacional">
                @foreach($tabelasSN as $tabela)
                    <option value="{{$tabela->id}}">{{$tabela->descricao}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary">Adicionar</button>
    </div>
</form>
<div class="clearfix"></div>
<hr>
<div class="col-xs-12">
    <form method="post" action="">
        <input type="hidden" name="tab" value="tributacao"/>
        <p class="alert alert-info" style="display: block"><strong>Selecione os impostos a deduzir</strong>, se tiver
            algum que precise</p>
        <table class="table table-hover table-striped table-condensed table-bordered">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>IRPJ</th>
                <th>CSLL</th>
                <th>Cofins</th>
                <th>PIS/Pasep</th>
                <th>CPP</th>
                <th>ICMS</th>
                <th>IPI</th>
                <th>ISS</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="list-cnaes">
            @foreach($tributacoes as $tributacao)
                <tr>
                    <th class="row">{{$tributacao->descricao}}<br/>{!! $tributacao->getMercadoLabel() !!}</th>
                    @for($i=1; $i!=9; $i++)
                        <td>
                            @include('admin.empresa.view.components.cfop-checkbox', ['tributacao'=>$tributacao, 'index'=>$i])
                        </td>
                    @endfor
                    <td><a href="{{route('removeTributacaoFromEmpresa',[$empresa->id, $tributacao->id])}}"
                           class="btn btn-danger"><i class="fa fa-remove"></i> Remover</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</div>
