<div class="col-xs-12">
    <h1 class="hidden-xs">Está com dúvidas?</h1>
    <h3 class="hidden-xs">Logo abaixo você encontra as respostas para as dúvidas mais comuns</h3>
    <h1 class="visible-xs">Dúvidas?</h1>
</div>
<div class="clearfix"></div>
<div class="row row-eq-height hidden-xs">
    <div class="col-sm-6 img">
        <div class="img-holder">
            <img src="{{asset(public_path('images/duvidas2.jpg'))}}"/>
        </div>
    </div>

    <div class="col-sm-6 faq">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach(\App\Models\Faq::all() as $faq)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{$faq->id}}" data-toggle="collapse"
                         data-parent="#accordion"
                         href="#{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            {!! $faq->pergunta !!}
                        </h4>
                    </div>
                    <div id="{{$faq->id}}" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            {!! $faq->resposta !!}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
<div class="col-xs-12 img visible-xs">
    <div class="img-holder">
        <img src="{{asset(public_path('images/duvidas2.jpg'))}}"/>
    </div>
</div>

<div class="col-xs-12 faq visible-xs">
    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
        @foreach(\App\Models\Faq::all() as $faq)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading{{$faq->id}}" data-toggle="collapse"
                     data-parent="#accordion2"
                     href="#{{$faq->id}}2" aria-expanded="true" aria-controls="collapseOne">
                    <h4 class="panel-title">
                        {!! $faq->pergunta !!}
                    </h4>
                </div>
                <div id="{{$faq->id}}2" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne">
                    <div class="panel-body">
                        {!! $faq->resposta !!}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>