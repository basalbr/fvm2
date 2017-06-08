@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#cadastrar-funcionario').on('click', function (e) {
                e.preventDefault();
                $('#modal-escolha-empresa').modal('show');
            })
        })
    </script>
@stop
@section('content')
    <div class="col-xs-12">
        <h1>Funcionários</h1>
        <p>Selecione uma empresa na lista abaixo para visualizar os funcionários dela.</p>
        <hr>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="list-group">
            <button type="button" id="cadastrar-funcionario" class="btn btn-primary"><span
                        class="fa fa-user-plus"></span> Clique aqui para cadastrar um
                funcionário
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="panel">
        @if($funcionarios->count())
            @foreach($funcionarios as $funcionario)
                <div class="col-xs-12">
                    <p>{{$funcionario->nome_completo}}</p>
                </div>
            @endforeach
        @else
            <div class="col-xs-12">
                <h5>Não encontramos nenhum funcionário em nosso sistema</h5>
            </div>
            <div class="clearfix"></div>
        @endif
    </div>

@stop
@section('modals')
    @parent
    <div class="modal animated fadeInDown" id="modal-escolha-empresa" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Cadastrar funcionário</h3>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <p>Para cadastrar um funcionário é necessário selecionar uma empresa primeiro.<br/>
                            Escolha uma empresa na lista abaixo e clique em avançar.</p>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            @if($empresas->count())
                                @foreach($empresas as $empresa)
                                    <a href="{{route('newFuncionario',[$empresa->id])}}">{{$empresa->nome_fantasia}}</a>
                                @endforeach
                            @else
                                <p>Você não cadastrou nenhuma empresa ainda.<br/>Caso queira abrir uma empresa, <a
                                            href="{{route('newAberturaEmpresa')}}">clique aqui.</a><br/>Para migrar uma
                                        empresa, <a href="{{route('newEmpresa')}}">clique aqui</a></p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop
