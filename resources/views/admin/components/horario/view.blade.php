@section('js')
    @parent
    <script type="text/javascript" src="{{url(public_path().'js/admin/modules/horarios.js')}}"></script>
@stop
<div class="col-xs-12">
    <table class='table table-hover table-bordered table-striped'>
        <thead>
        <tr>
            <th></th>
            <th colspan="2" class="bg-primary">1° TURNO</th>
            <th colspan="2" class="bg-primary">2° TURNO</th>
            <th></th>
        </tr>
        <tr>
            <th style=" min-width: 78px;">Dia</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Total de horas</th>
        </tr>
        </thead>
        <tbody>

        @foreach($dow as $n => $dia)
            @if($contrato->dsr == $n)
                <tr id="{{$n}}">
                    <td style="vertical-align: middle; min-width: 78px;"><b>{{$dia}}</b></td>
                    <td class="text-center horario">
                        <div class="form-group">
                            <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora1]" value="">
                        </div>
                    </td>
                    <td class="text-center horario">
                        <div class="form-group">

                            <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora2]" value="">
                        </div>

                    </td>
                    <td class="text-center horario">
                        <div class="form-group">

                            <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora3]" value="">
                        </div>

                    </td>
                    <td class="text-center horario">
                        <div class="form-group">

                            <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora4]" value="">
                        </div>

                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <b>00:00</b>
                    </td>
                </tr>
            @else
                @foreach($horarios as $horario)
                    @if($horario->dia == $n)
                        <tr id="{{$n}}">
                            <td style="vertical-align: middle; min-width: 78px;"><b>{{$dia}}</b></td>
                            <td class="text-center horario">
                                <div class="form-group">
                                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora1]"
                                           value="{{$horario->hora1}}">
                                </div>
                            </td>
                            <td class="text-center horario">
                                <div class="form-group">

                                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora2]"
                                           value="{{$horario->hora2}}">
                                </div>

                            </td>
                            <td class="text-center horario">
                                <div class="form-group">

                                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora3]"
                                           value="{{$horario->hora3}}">
                                </div>

                            </td>
                            <td class="text-center horario">
                                <div class="form-group">

                                    <input class="form-control time-mask" type="text" name="horario[{{$n}}][hora4]"
                                           value="{{$horario->hora4}}">
                                </div>

                            </td>
                            <td class="text-center" style="vertical-align: middle;">
                                <b>00:00</b>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach

        <tr>
            <td colspan="5" class="text-right"><strong>Total de horas semanais</strong></td>
            <td id="total-horas" class="text-center"><strong>0</strong></td>
        </tr>
        </tbody>
    </table>
</div>
