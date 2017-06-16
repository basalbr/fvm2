@extends('dashboard.layouts.master')
@section('js')
    @parent
    <script type="text/javascript">

        $(function () {
            $('#foto-perfil button').on('click', function (e) {
                e.preventDefault();
                $(this).parent().find('input').click();
            });

            $('#foto-perfil input').on('change', function(){
                var formData = new FormData();
                formData.append('arquivo', $(this)[0].files[0]);
                sendAnexo($('form'), formData);
                $(this).val(null);
            });
        });

        function sendAnexo(form, formData) {
            $.post({
                url: form.data('upload-foto-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data) {
                $('#foto-perfil img').attr('src',data.url)
                $('form').find('[name="foto"]').val(data.filename)
            }).fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError(form, jqXHR.responseJSON);
                } else {
                    showFormValidationError(form);
                }
            });
        }
    </script>
@stop
@section('content')
    <div class="col-xs-12">
        <h1>Editar perfil</h1>
        <hr>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="panel">
            <div class="col-sm-12">
                <h3>Informações pessoais</h3>
                <p>Campos com * são obrigatórios</p>
            </div>
            <form action="" method="POST" data-upload-foto-url="{{route('uploadUsuarioFoto')}}">
                <input type="hidden" name="foto" value="" />
                {!! csrf_field() !!}
                @include('dashboard.components.form-alert')
                <div class="col-sm-12">
                    <div class="form-group" id="foto-perfil">
                        <label>Foto do perfil (60px x 60px)</label>
                            <div class="clearfix"></div>
                        <div href="#" class="thumbnail">
                            <img src="{{$usuario->foto ? asset('public/storage/usuarios/'.$usuario->id.'/'.$usuario->foto) : asset(public_path().'images/thumb.jpg')}}"
                                 title="{{$usuario->nome}}"/>
                        </div>
                        <button type="button" class="btn btn-primary"><i class="fa fa-camera"></i> Trocar foto</button>
                        <div class="clearfix"></div>
                        <input type="file" class="hidden">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="nome">Nome completo *</label>
                        <input type="text" name="nome" class="form-control" value="{{$usuario->nome}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" disabled class="form-control" value="{{$usuario->email}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="telefone">Telefone *</label>
                        <input type="text" name="telefone" class="form-control phone-mask"
                               value="{{$usuario->telefone}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="senha">Nova senha</label>
                        <input type="password" name="senha" class="form-control" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="senha_confirmed">Confirmar senha</label>
                        <input type="password" name="senha_confirmation" class="form-control" value="">
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="col-sm-12">
                    <a href="{{URL::previous()}}" class="btn btn-default"><i class="fa fa-angle-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar informações
                    </button>

                </div>
            </form>
            <div class="clearfix"></div>
            <br/>
        </div>
    </div>
@stop
