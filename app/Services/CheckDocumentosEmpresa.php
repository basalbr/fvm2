<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\Apuracao;
use App\Models\ApuracaoInformacaoExtra;
use App\Models\Chamado;
use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\ImpostoInformacaoExtra;
use App\Models\Mensagem;
use App\Models\Usuario;
use App\Notifications\GuiaAvailableInApuracao;
use App\Notifications\LimiteDocumentosUltrapassado;
use App\Notifications\NewChamado;
use App\Notifications\NewInfoInApuracao;
use App\Notifications\NewStatusApuracao;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CheckDocumentosEmpresa
{

    public static function handle(Empresa $empresa, $competencia)
    {
        try {
            $mensalidadeAtual = $empresa->getMensalidadeAtual();
            $apuracoes = $empresa->apuracoes()->where('competencia', $competencia)->get();
            $qtdNotas = 0;
            foreach($apuracoes as $apuracao){
                $qtdNotas+=$apuracao->qtde_notas_servico + $apuracao->qtde_notas_entrada + $apuracao->qtde_notas_saida;
            }
            if($mensalidadeAtual->qtde_documento_fiscal < $qtdNotas){
                Usuario::findOrFail(1)->notify(new LimiteDocumentosUltrapassado($empresa, $mensalidadeAtual->qtde_documento_fiscal, $qtdNotas, $competencia->format('m/Y')));
            }

        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
        return true;
    }
}