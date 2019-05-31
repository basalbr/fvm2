@include('admin.empresa.components.ativas-filter')
<table class="table table-hovered table-striped">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Empresa</th>
        <th>CNPJ</th>
        @if(Auth::user()->id == 1)
        <th>Senha Certificado</th>
        @endif
        <th></th>
    </tr>
    </thead>
    <tbody>

    <div class="clearfix"></div>
    @if($empresasAtivas->count())
        @foreach($empresasAtivas as $empresa)
            <tr>
                <td><a href="{{route('showUsuarioToAdmin', $empresa->usuario->id)}}">{{$empresa->usuario->nome}}</a></td>
                <td><a href="{{route('showEmpresaToAdmin', $empresa->id)}}">{{$empresa->nome_fantasia}} ({{$empresa->razao_social}})</a></td>
                <td>{{$empresa->cnpj}}</td>
                
                <td>{{$empresa->senha_certificado_digital}}</td>
                
                <td>
                
                    <a download class="btn btn-success"
                       href="{{asset(public_path().'storage/certificados/'. $empresa->id . '/'.$empresa->certificado_digital)}}"
                       title="Clique para fazer download do arquivo"><i class="fa fa-download"></i></a>
                
                    <a href="{{route('showEmpresaToAdmin', $empresa->id)}}" class="btn btn-primary"><i
                                class="fa fa-search"></i></a>
                </td>
            </tr>

        @endforeach
    @else
        <tr>
            <td colspan="7">Nenhuma empresa encontrada</td>
        </tr>
    @endif
    </tbody>
</table>
{{ $empresasAtivas->appends(request()->query())->appends(['tab'=>'pendentes'])->links() }}
<div class="clearfix"></div>