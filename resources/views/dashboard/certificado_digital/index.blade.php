@extends('dashboard.layouts.master')
@section('top-title')
    Certificados Digitais
@stop
@section('video-ajuda')
    <li><a id="btn-ajuda" data-placement="bottom" title="Precisa de ajuda? Veja nosso vídeo explicativo sobre essa página!" href="" data-toggle="modal" data-target="#modal-video-ajuda"><span class="fa fa-youtube-play"></span>
            Ajuda</a></li>
@stop
@section('modal-video-ajuda-titulo', 'Como enviar seu certificado digital')
@section('modal-video-ajuda-embed')
    <iframe width="560" height="315" src="https://www.youtube.com/embed/5e6gTaWB71E" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@stop
@section('js')
    @parent
    <script type="text/javascript">
        $(function(){
           $('form a.btn-primary').on('click', function(e){
               e.preventDefault();
               $(this).parent().find('[type="file"]').click();
           });
           $('form [type="file"]').on('change', function(){
              if(validatePassword() && validateMessengerFile($(this))){
                  $(this).parent().find('a').addClass('disabled').html('<span class="fa fa-hourglass-1"></span> Enviando certificado, aguarde...').prop('disabled');
                  $(this).parent().submit();
              }
           });
        });

        function validatePassword(){
            if ($('[name="senha"]').val() !== null && $('[name="senha"]').val() !== ''){
                return true;
            }
            showModalAlert('É necessário informar a senha do certificado para que possamos importar em nosso sistema.');
            return false;
        }

        function validateMessengerFile(file) {
            if (file.val() !== '' &&
                file.val() &&
                file.val() !== undefined) {
                if ((file[0].files[0].size / 1024) > 1024) {
                    showModalAlert('O arquivo não pode ser maior que 1MB.');
                    return false;
                }
                return true;
            } else {
                showModalAlert('É necessário escolher um arquivo para envio.')
                return false;
            }
        }
    </script>
    @stop
@section('content')
    @if(count($empresas))
        @foreach($empresas as $empresa)
            @if(!$empresa->certificado_digital)
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>{{$empresa->nome_fantasia}} ({{$empresa->razao_social}}
                                    )</strong></h3>
                        </div>
                        <div class="panel-body">
                            <p>Você ainda não nos enviou o certificado digital dessa empresa, para enviar basta clicar
                                no botão abaixo (Não esqueça de informar a senha).</p>
                            <form data-id-empresa="{{$empresa->id}}" method="POST" class="certificado-form" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="senha">Senha do certificado *</label>
                                    <input type="text" class="form-control" name="senha" value=""/>
                                </div>
                                <a href="" class="btn-primary btn"><span class="fa fa-upload"></span> Enviar Certificado
                                    Digital A1</a>
                                <input type="file" class="hidden" name="certificado"/>
                                <input type="hidden" value="{{$empresa->id}}" name="id_empresa">
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>{{$empresa->nome_fantasia}} ({{$empresa->razao_social}}
                                    )</strong></h3>
                        </div>
                        <div class="panel-body">
                            <p>Clique no botão abaixo para remover o certificado digital A1 dessa empresa.</p>
                            <a download href="{{asset(public_path().'/storage/certificados/'.$empresa->id.'/'.$empresa->certificado_digital)}}" class="btn-primary btn"><span class="fa fa-download"></span> Download</a>
                            <a href="{{route('userDeleteCertificado', $empresa->id)}}" class="btn-danger btn"><span class="fa fa-remove"></span> Remover certificado
                                digital A1</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <strong>Você não possui nenhuma empresa cadastrada</strong>, <a href="{{route('newEmpresa')}}">clique
                        aqui</a>
                    para solicitar a migração de sua empresa para a WEBContabilidade ou <a
                            href="{{route('newAberturaEmpresa')}}">clique
                        aqui</a> para solicitar a abertura de uma empresa.
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
    <div class="navigation-space"></div>
    <div class="navigation-options">
        <a href="{{route('newEmpresa')}}" class="btn btn-primary"><span class="fa fa-exchange"></span> Solicitar
            migração de empresa</a>
        <a href="{{route('newAberturaEmpresa')}}" class="btn btn-success"><span class="fa fa-child"></span> Solicitar
            abertura de empresa</a>
    </div>
@stop
@section('modals')
    @parent
    @include('dashboard.modals.video-ajuda')
@stop
