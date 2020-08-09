<div class="form-group no-border">
    <label class="checkbox checkbox-styled radio-success">
        @if($tributacao->hasIsencao($impostosIndex[$index]))
            <input type="checkbox" class="imposto_tributacao" value="{{$index}}" name="{{$tributacao->id}}"
                   data-url="{{route('updateTributacaoFromEmpresa', [$empresa->id, $tributacao->id])}}"
                   checked="checked"/><span></span>
        @else
            <input type="checkbox" class="imposto_tributacao" value="{{$index}}" name="{{$tributacao->id}}"
                   data-url="{{route('updateTributacaoFromEmpresa', [$empresa->id, $tributacao->id])}}"/>
            <span></span>
        @endif
    </label>
</div>
