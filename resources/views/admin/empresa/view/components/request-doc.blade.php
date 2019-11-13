@if($empresa->hasDocumento($doc))
    <a class="btn btn-primary" href="{{asset(public_path().'storage/anexos/empresa/'.$empresa->getDocumento($doc)->id_referencia . '/' . $empresa->getDocumento($doc)->arquivo)}}" download target="_blank"><i class="fa fa-download"></i> Download</a>
@else
    @if($empresa->$doc)
        <button data-url="{{route('toggleRequestDocEmpresa', [$empresa->id, $doc])}}"
                class="btn btn-danger request-doc"><i class="fa fa-remove"></i> Cancelar solicitação
        </button>
    @else
        <button data-url="{{route('toggleRequestDocEmpresa', [$empresa->id, $doc])}}"
                class="btn btn-success request-doc"><i class="fa fa-check"></i> Solicitar
        </button>
    @endif
@endif