<div class="{{$aberturaEmpresa->status == 'concluido' || $aberturaEmpresa->status == 'cancelado' ? 'col-xs-12' : 'col-md-6'}}">
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Razão Social</label>
            <div class="form-control">{{$aberturaEmpresa->nome_empresarial1}}</div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Nome Fantasia</label>
            <div class="form-control">{{$aberturaEmpresa->nome_empresarial2}}</div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Usuário</label>
            <div class="form-control"><a
                        href="{{route('showUsuarioToAdmin', $aberturaEmpresa->id_usuario)}}">{{$aberturaEmpresa->usuario->nome}}</a>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Sócio principal</label>
            <div class="form-control"><a class="show-socio"
                                         data-id="{{$aberturaEmpresa->getSocioPrincipal()->id}}">{{$aberturaEmpresa->getSocioPrincipal()->nome}}</a>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">E-mail</label>
            <div class="form-control">{{$aberturaEmpresa->getSocioPrincipal()->email ? $aberturaEmpresa->getSocioPrincipal()->email : $aberturaEmpresa->usuario->email}}</div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label for="">Última atualização em</label>
            <div class="form-control">{{$aberturaEmpresa->updated_at->format('d/m/Y H:i:s')}}</div>
        </div>
    </div>
</div>
<div class="{{$aberturaEmpresa->status == 'concluido' || $aberturaEmpresa->status == 'cancelado' ? 'hidden' : 'col-md-6'}}">
    @include('admin.abertura_empresa.view.components.etapas')
</div>