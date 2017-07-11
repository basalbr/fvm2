<div class="col-sm-4">
    <div class="form-group">
        <label>Empresa</label>
        <div class="form-control">{{$processo->empresa->nome_fantasia}}</div>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Status</label>
        <div class="form-control">{{$processo->getStatus()}}</div>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Competência</label>
        <div class="form-control">{{$processo->periodo->format('m/Y')}}</div>
    </div>
</div>
<div class="clearfix"></div>

