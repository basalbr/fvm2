@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/dashboard/modules/simulate.js')}}"></script>

@stop
<input type="hidden" value="{{route('getMonthlyPaymentParams')}}" id="payment-parameters">
