@extends('dashboard.layouts.master')

@section('js')
    @parent

@stop

@section('content')
    <h1>Solicitação de Alteração</h1>
    <hr>
    <div class="panel">
        <div class="col-sm-12">
            <h3>Solicitar {{$tipoAlteracao->descricao}} ({{$tipoAlteracao->getValorFormatado()}})</h3>
            <br/>
        </div>
        <form class="form" method="POST" action="" id="form-principal"
              data-validation-url="{{route('validateChamado')}}">
            @include('dashboard.components.form-alert')
            @include('dashboard.components.disable-auto-complete')
            {{csrf_field()}}
            <div class="col-sm-12">
                <div class="form-group">
                <label>Empresa para alteração</label>
                <select class="form-control">
                    <option value="">Selecione uma empresa</option>
                    @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}">{{$empresa->nome_fantasia}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            @foreach($tipoAlteracao->campos as $campo)
                @if($campo->tipo == 'string')
                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label>{{$campo->nome}}</label>
                            <input type='text' class='form-control' name='{{$campo->id}}'
                                   placeholder="{{$campo->descricao}}"/>
                        </div>
                    </div>
                @elseif($tipoAlteracao->tipo == 'textarea')
                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label>{{$campo->nome}}</label>
                            <textarea name='{{$campo->id}}' class='form-control'
                                      placeholder="{{$campo->descricao}}"></textarea>
                        </div>
                    </div>
                @elseif($tipoAlteracao->tipo == 'file')
                    <div class="col-sm-12">
                        <div class='form-group'>
                            <label>{{$campo->nome}}</label>
                            <input type='file' class='form-control' value="" name='anexo[{{$campo->id}}]'/>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="col-sm-12">
                <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-envelope"></i> Abrir chamado</button>
            </div>
        </form>
        <div class="clearfix"></div>
        <br/>
    </div>
@stop