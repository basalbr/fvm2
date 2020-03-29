<table class="table table-striped table-hover">
    <tbody>
    <tr>
        <th scope="row">Empresa</th>
        <td>
            <a href="{{route('showEmpresaToAdmin', $processo->empresa->id)}}">{{$processo->empresa->razao_social}}
                ({{$processo->empresa->nome_fantasia}})</a></td>
    </tr>
    <tr>
        <th scope="row">Competência</th>
        <td>{{$processo->periodo->format('m/Y')}}</td>
    </tr>
    <tr>
        <th scope="row">Status</th>
        <td>{!! $processo->getLabelStatus() !!}</td>
    </tr>
    </tbody>
</table>
<div class="clearfix"></div>