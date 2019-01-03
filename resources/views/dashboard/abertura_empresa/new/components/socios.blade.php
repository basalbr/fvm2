<!-- Manipulação de Sócios -->
@include('dashboard.components.socios.add', ['validationUrl'=>route('validateAberturaEmpresaSocio')])
<div class="col-xs-12">
    <h3>Sócios</h3>
    <hr>
    <div class="alert alert-info" style="display:block">
        <p>Informe todos os sócios que farão parte da empresa, o sócio principal será o responsável perante a Receita Federal.</p>
    </div>
</div>
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Sócio principal?</th>
            <th>Opções</th>
        </tr>

        </thead>
        <tbody id="list-socios">
        <tr>
            <td colspan="3" class="none">Nenhum sócio cadastrado</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="col-xs-12">
    <button type="button" class="btn btn-primary open-modal" data-modal="#modal-socio"><i class="fa fa-plus"></i>
        Cadastrar sócio
    </button>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - Endereço</button>
    <button class="btn btn-primary next">Avançar - CNAEs <i class="fa fa-angle-right"></i>
    </button>
</div>