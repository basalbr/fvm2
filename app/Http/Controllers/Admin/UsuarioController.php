<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AberturaEmpresa;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Models\Usuario;
use App\Services\ActivateEmpresa;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\KillByInadimplency;
use App\Services\SendMessageToAdmin;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use App\Validation\SocioValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UsuarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index(Request $request)
    {
        $usuarios = Usuario::query();
        if (!$request->has('tab') || $request->get('tab') == 'usuarios') {
            $usuarios = $this->filterForm($usuarios, $request);
        }
        $usuarios = $usuarios->select('usuario.*')->get();

        return view('admin.usuarios.index', compact("usuarios"));
    }

    public function view($id)
    {
        /* @var Usuario $usuario */
        $usuario = Usuario::findOrFail($id);
        $alteracoes = $usuario->alteracoes()->orderBy('created_at', 'desc')->get();
        $aberturasEmpresa = $usuario->aberturasEmpresa()->orderBy('nome_empresarial1', 'desc')->get();
        $empresas = $usuario->empresas()->orderBy('nome_fantasia', 'desc')->get();
        $chamados = $usuario->chamados()->orderBy('updated_at', 'desc')->get();
        $ordensPagamento = $usuario->ordensPagamento()->orderBy('created_at', 'desc')->get();
        return view('admin.usuarios.view.index', compact("usuario", 'aberturasEmpresa', 'alteracoes', 'empresas', 'chamados', 'ordensPagamento'));
    }

    /* Banir usuário por inadimplência*/
    public function kill($id)
    {
        $usuario = Usuario::find($id);
        if (KillByInadimplency::handle($usuario)) {
            return redirect()->route('listUsuariosToAdmin')->with('successAlert', 'Usuário morto com sucesso :D');
        }
        return redirect()->back()->with('errorAlert', 'Ocorreu um erro ao tentar matar esse usuário');
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        if ($request->get('busca')) {
            $query->where('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                ->orWhere('usuario.telefone', 'LIKE', '%' . $request->get('busca') . '%')
                ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%');
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'email_asc':
                    $query->orderBy('usuario.email');
                    break;
                case 'email_desc':
                    $query->orderBy('usuario.email', 'desc');
                    break;
                case 'usuario_asc':
                    $query->orderBy('usuario.nome');
                    break;
                case 'usuario_desc':
                    $query->orderBy('usuario.nome', 'desc');
                    break;
                case 'criado_asc':
                    $query->orderBy('usuario.created_at');
                    break;
                case 'criado_desc':
                    $query->orderBy('usuario.created_at', 'desc');
                    break;
                default:
                    $query->orderBy('usuario.nome');
            }
        }else{
            $query->orderBy('usuario.nome');
        }
        return $query;
    }

}
