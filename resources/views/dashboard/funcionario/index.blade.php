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
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como cadastrar seus funcionários')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/nx-3tn75fq8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('top-title')
    Funcionários
@stop
@section('content')
    @if($funcionarios->count())
        @foreach($funcionarios as $funcionario)
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$funcionario->nome_completo}}</h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            <strong>Empresa:</strong> <a href="{{route('showEmpresaToUser', $funcionario->id_empresa)}}">{{$funcionario->empresa->nome_fantasia}}
                            ({{$funcionario->empresa->razao_social}})</a>
                        </div>
                        <div><strong>Salário:</strong> R${{$funcionario->getSalario()}}</div>
                        <div><strong>Cadastrado em:</strong> {{$funcionario->created_at->format('d/m/Y')}}</div>
                        <div><strong>Status:</strong> {!!$funcionario->getStatus() !!}</div>
                    </div>

                    <div class="panel-footer">
                        <a href="{{route('showFuncionarioToUser', [$funcionario->empresa->id, $funcionario->id])}}"
                           class="btn btn-primary">
                            <i class="fa fa-search"></i> Visualizar</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center open-modal" data-modal="#modal-escolha-empresa">
                    <strong>Você não possui nenhum funcionário cadastrado em nosso sistema</strong>, <a
                            href="">clique aqui</a>
                    para cadastrar um funcionário.
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <button type="button" id="cadastrar-funcionario" class="btn btn-primary"><i
                    class="fa fa-user-plus"></i> Cadastrar funcionário
        </button>
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
                        <p>Para cadastrar um funcionário é necessário selecionar uma empresa
                            primeiro.<br/>
                            Escolha uma empresa na lista abaixo e clique em avançar.</p>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            @if($empresas->count())
                                @foreach($empresas as $empresa)
                                    <a href="{{route('newFuncionario',[$empresa->id])}}">{{$empresa->nome_fantasia}}</a>
                                @endforeach
                            @else
                                <p>Você não cadastrou nenhuma empresa ainda.<br/>Caso queira abrir uma
                                    empresa, <a
                                            href="{{route('newAberturaEmpresa')}}">clique aqui.</a><br/>Para
                                    migrar uma
                                    empresa, <a href="{{route('newEmpresa')}}">clique aqui</a></p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.modals.video-ajuda')
@stop
