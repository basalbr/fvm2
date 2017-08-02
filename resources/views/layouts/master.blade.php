<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <link rel="shortcut icon" href="{{url(public_path().'favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{url(public_path().'favicon.ico')}}" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEBContabilidade</title>
    <meta name="description" content="Serviços contábeis com mensalidades a partir de R$39,90">
    @section('css')
        @include('index.components.css')
    @show
    @section('js')
        @include('index.components.js')
        @if(\Illuminate\Support\Facades\App::environment('production'))
            <!-- Google Code for Realizar cadastro Conversion Page
In your html page, add the snippet and call
goog_report_conversion when someone clicks on the
chosen link or button. -->
                <script type="text/javascript">
                    /* <![CDATA[ */
                    goog_snippet_vars = function() {
                        var w = window;
                        w.google_conversion_id = 879839356;
                        w.google_conversion_label = "PDCjCKSFznMQ_JDFowM";
                        w.google_remarketing_only = false;
                    }
                    // DO NOT CHANGE THE CODE BELOW.
                    goog_report_conversion = function(url) {
                        goog_snippet_vars();
                        window.google_conversion_format = "3";
                        var opt = new Object();
                        opt.onload_callback = function() {
                            if (typeof(url) != 'undefined') {
                                window.location = url;
                            }
                        }
                        var conv_handler = window['google_trackConversion'];
                        if (typeof(conv_handler) == 'function') {
                            conv_handler(opt);
                        }
                    }
                    /* ]]> */
                </script>
                <script type="text/javascript"
                        src="//www.googleadservices.com/pagead/conversion_async.js">
                </script>

                <script type="text/javascript" src="{{url(public_path().'js/ga.js')}}"></script>
        @endif
    @show

</head>
<body data-spy="scroll" data-target="#nav-menu-items" data-offset="200" >
<header id="nav-menu" class="transparent">
    @include('index.components.menu')
</header>
@yield('content')
<section id="contato" class="section">
    @include('index.components.contato')
</section>

<div id="modal-content">
    @include('index.modals.acessar')
    @include('index.modals.esqueci')
    @include('index.modals.registrar')
    @include('index.modals.sucesso')
    @include('index.modals.simular')
</div>
</body>
</html>
