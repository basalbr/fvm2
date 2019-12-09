<div class="col-xs-12">
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Descrição</th>
        <th>Enviado em</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($decimosTerceiro->count())
        @foreach($decimosTerceiro as $decimoTerceiro)
            <tr>
                <td><a href="{{route('showEmpresaToUser', $decimoTerceiro->id_empresa)}}">{{$decimoTerceiro->empresa->nome_fantasia}}({{$decimoTerceiro->empresa->razao_social}})</a></td>
                <td>{{$decimoTerceiro->descricao}}</td>
                <td>{{$decimoTerceiro->created_at->format('d/m/Y')}}</td>
                <td><a class="btn btn-primary" href="{{route('showDecimoTerceiroToUser', $decimoTerceiro->id)}}"><i class="fa fa-search"></i></a></td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="4">Nenhum décimo terceiro enviado</td>
        </tr>
    @endif
    </tbody>
</table>
</div>
<div class="clearfix"></div>