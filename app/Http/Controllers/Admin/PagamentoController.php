<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AberturaEmpresa;
use App\Models\Chamado;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\Mensagem;
use App\Models\NaturezaJuridica;
use App\Models\OrdemPagamento;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendMessageToAdmin;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use App\Validation\SocioValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagamentoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function updateMensalidades()
    {

    }

    public function index(Request $request)
    {
        $pagamentosPendentes = OrdemPagamento::query()->whereNotIn('ordem_pagamento.status', ['Paga', 'Disponível']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $pagamentosPendentes = $this->filterForm($pagamentosPendentes, $request);
        }
        $pagamentosPendentes = $pagamentosPendentes->select('ordem_pagamento.*')->get();


        $historicoPagamento = OrdemPagamento::query()->whereIn('ordem_pagamento.status', ['Paga', 'Disponível']);
        if (!$request->has('tab') || $request->get('tab') == 'historico') {
            $historicoPagamento = $this->filterForm($historicoPagamento, $request);
        }
        $historicoPagamento = $historicoPagamento->select('ordem_pagamento.*')->get();

        return view('admin.pagamentos.index', compact("pagamentosPendentes", 'historicoPagamento'));
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        $query->join('usuario', 'usuario.id', '=', 'ordem_pagamento.id_usuario');
        if ($request->get('tipo')) {
            $query->join($request->get('tipo'), $request->get('tipo').'.id', '=', 'ordem_pagamento.id_referencia');
        }
        if ($request->get('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.telefone', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%');
                if ($request->get('tipo')) {
                    switch ($request->get('tipo')) {
                        case 'abertura_empresa':
                            $q->orWhere('abertura_empresa.nome_empresarial1', 'LIKE', '%' . $request->get('busca') . '%');
                            $q->orWhere('abertura_empresa.nome_empresarial2', 'LIKE', '%' . $request->get('busca') . '%');
                            $q->orWhere('abertura_empresa.nome_empresarial3', 'LIKE', '%' . $request->get('busca') . '%');
                            break;
                        case 'empresa':
                            $q->orWhere('empresa.nome_fantasia', 'LIKE', '%' . $request->get('busca') . '%');
                            $q->orWhere('empresa.razao_social', 'LIKE', '%' . $request->get('busca') . '%');
                            $q->orWhere('empresa.cnpj', 'LIKE', '%' . $request->get('busca') . '%');
                            break;
                    }
                }
            });
        }
        if ($request->get('tipo')) {
            $query->where('ordem_pagamento.referencia', $request->get('tipo'));
        }
        if ($request->get('status')) {
            $query->where('ordem_pagamento.status', $request->get('status'));
        }
        if ($request->get('aberto_de')) {
            $data = explode('/', $request->get('aberto_de'));
            $query->where('ordem_pagamento.created_at', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('aberto_ate')) {
            $data = explode('/', $request->get('aberto_ate'));
            $query->where('ordem_pagamento.created_at', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('pago_de')) {
            $data = explode('/', $request->get('pago_de'));
            $query->where('ordem_pagamento.updated_at', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('pago_ate')) {
            $data = explode('/', $request->get('pago_ate'));
            $query->where('ordem_pagamento.updated_at', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('vencimento_de')) {
            $data = explode('/', $request->get('vencimento_de'));
            $query->where('ordem_pagamento.vencimento', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('vencimento_ate')) {
            $data = explode('/', $request->get('vencimento_ate'));
            $query->where('ordem_pagamento.vencimento', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'aberto_asc':
                    $query->orderBy('ordem_pagamento.created_at');
                    break;
                case 'aberto_desc':
                    $query->orderBy('ordem_pagamento.created_at', 'desc');
                    break;
                case 'vencimento_asc':
                    $query->orderBy('ordem_pagamento.vencimento');
                    break;
                case 'vencimento_desc':
                    $query->orderBy('ordem_pagamento.vencimento', 'desc');
                    break;
                case 'pago_asc':
                    $query->orderBy('ordem_pagamento.updated_at');
                    break;
                case 'pago_desc':
                    $query->orderBy('ordem_pagamento.updated_at', 'desc');
                    break;
                case 'usuario_asc':
                    $query->orderBy('usuario.nome');
                    break;
                case 'usuario_desc':
                    $query->orderBy('usuario.nome', 'desc');
                    break;
                default:
                    $query->orderBy('ordem_pagamento.created_at', 'desc');
            }
        } else {
            $query->orderBy('ordem_pagamento.created_at', 'desc');
        }
        return $query;
    }

}
