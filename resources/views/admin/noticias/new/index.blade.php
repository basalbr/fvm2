@extends('dashboard.layouts.master')

@section('top-title')
    <a href="{{route('listNoticiasToAdmin')}}">Notícias</a> <i class="fa fa-angle-right"></i> Nova notícia
@stop
@section('js')
    @parent
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xs6j8xeombkhwcowbftixwvy24erlvylumyoad8shqc46c98"></script>
    <script type="text/javascript">
        var links = '';
        $(function () {
            links = [];
            $('head link[type="text/css"]').each(function () {
                links.push($(this).attr('href'));
            });
            var url = $('form').data('upload-image-url');
            tinymce.init({
                selector: 'textarea',
                theme: 'modern',
                plugins: 'image fullscreen',
                images_upload_url: url,
                content_css: links
            });
            $('#form-principal').find('.btn-success[type="submit"]').on('click', function (e) {
                e.preventDefault();
                validateFormPrincipal();
            });
        });

        function validateFormPrincipal() {
            $('#conteudo').val(tinymce.activeEditor.getContent())
            var formData = new FormData();
            if ($('[name="capa"]').val() !== '' && $('[name="capa"]').val() !== null && $('[name="capa"]').val() !== undefined) {
                formData.append('capa', $('[name="capa"]')[0].files[0])
            }
            var params = $('#form-principal').serializeArray();
            $(params).each(function (index, element) {
                formData.append(element.name, element.value);
            });
            $.post({
                url: $('#form-principal').data('validation-url'),
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data, textStatus, jqXHR) {
                $('#form-principal').submit();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    //noinspection JSUnresolvedVariable
                    showFormValidationError($('#form-principal'), jqXHR.responseJSON);
                } else {
                    showFormValidationError($('#form-principal'));
                }
            });
        }
    </script>
@stop
@section('content')
    <div class="tab-content">
        <form class="form" method="POST" action="" id="form-principal"
              data-upload-image-url="{{route('uploadImage')}}"
              data-validation-url="{{route('validateNoticia')}}" enctype="multipart/form-data">
            <div role="tabpanel" class="active tab-pane animated fadeIn" id="todo">


                @include('dashboard.components.form-alert')
                @include('dashboard.components.disable-auto-complete')
                {{csrf_field()}}
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Título de destaque *</label>
                        <input class="form-control" name="titulo_destaque"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Título *</label>
                        <input class="form-control" name="titulo"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Subtítulo *</label>
                        <input class="form-control" name="subtitulo"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Data de publicação *</label>
                        <input class="form-control date-mask" name="data_publicacao"
                               value="{{Carbon\Carbon::today()->format('d/m/Y')}}"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Capa *</label>
                        <input class="form-control" type="file" name="capa"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Conteúdo *</label>
                        <textarea class="form-control" name="conteudo"></textarea>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="navigation-space"></div>
            <div class="navigation-options">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-angle-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Cadastrar</button>
            </div>
        </form>
    </div>
@stop