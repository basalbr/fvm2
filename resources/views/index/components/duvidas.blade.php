<div class="col-xs-12">
    <h1 class="hidden-xs">Está com dúvidas?</h1>
    <h3 class="hidden-xs">Logo abaixo você encontra as respostas para as dúvidas mais comuns</h3>
    <h1 class="visible-xs">Dúvidas?</h1>
</div>
<div class="clearfix"></div>
    <div class="container">
        <div class="faq">
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
