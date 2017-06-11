<!-- Manipulação de Sócios -->
@include('dashboard.components.dependentes.add', ['validationUrl'=>route('validateDependente')])
<div class="col-xs-12">
    <h3>Dependentes</h3>
    <hr>
</div>
<div class="col-xs-12">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Opções</th>
        </tr>

        </thead>
        <tbody id="list-dependentes">
        <tr>
            <td colspan="2" class="none">Nenhum dependente cadastrado</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="col-xs-12">
    <button type="button" class="btn btn-primary open-modal" data-modal="#modal-dependente"><i class="fa fa-plus"></i>
        Adicionar dependente
    </button>
</div>
<div class="col-xs-12 text-right">
    <hr>
    <button class="btn btn-default back"><i class="fa fa-angle-left"></i> Voltar - Endereço</button>
    <button class="btn btn-primary next">Avançar - CNAEs <i class="fa fa-angle-right"></i>
    </button>
</div>