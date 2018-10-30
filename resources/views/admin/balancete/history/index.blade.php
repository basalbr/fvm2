@if(count($balancetes) > 0)
    @foreach($balancetes as $balancete)
        <tr>
            <td>{!! $balancete->exercicio->format('m/Y') !!}</td>
            <td>{!! number_format($balancete->receitas, 2, ',', '.') . 'C' !!}</td>
            <td>{!! number_format($balancete->despesas, 2, ',', '.') . 'D' !!}</td>
            <td><a class="btn btn-primary" download
                   href="{{ asset(public_path().'storage/balancetes/'. $balancete->id_empresa . '/'. $balancete->anexo)}}"><span
                            class="fa fa-download"></span></a></td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="4" class="text-center">Nenhuma informação disponível</td>
    </tr>
@endif