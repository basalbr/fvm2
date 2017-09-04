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
@section('top-title')
    Funcionários
@stop
@section('content')

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
                <div class="col-lg-4 col-sm-6">
                    <div class="panel">
                        <div class="col-xs-12">
                            <h3 class="title">{{$funcionario->nome_completo}}</h3>
                            <hr>
                        </div>
                        <div class="items">
                            <div class="col-xs-12">
                                <i class="fa fa-user item-icon"></i>
                                <div class="item-value">{{$funcionario->nome_completo}}</div>
                                <div class="item-description">Nome do funcionário</div>
                            </div>
                            <div class="col-xs-12">
                                <i class="fa fa-building item-icon"></i>
                                <div class="item-value">
                                    <a href="{{route('showEmpresaToUser', $funcionario->empresa->id)}}">{{$funcionario->empresa->nome_fantasia}}</a>
                                </div>
                                <div class="item-description">Nome da empresa</div>
                            </div>
                            <div class="col-xs-12">
                                <i class="fa fa-cogs item-icon"></i>
                                <div class="item-value">{!! $funcionario->getStatus() !!}</div>
                                <div class="item-description">Status</div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-xs-12 options">
                            <a href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}"
                               class="btn btn-primary">
                                <i class="fa fa-search"></i> Visualizar</a>
                        </div>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
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
