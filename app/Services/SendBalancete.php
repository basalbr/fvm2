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
use App\Models\Balancete;
use App\Models\Chamado;
use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\ImpostoInformacaoExtra;
use App\Models\Mensagem;
use App\Models\Usuario;
use App\Notifications\BalanceteSent;
use App\Notifications\GuiaAvailableInApuracao;
use App\Notifications\NewChamado;
use App\Notifications\NewInfoInApuracao;
use App\Notifications\NewStatusApuracao;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendBalancete
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Mensagem $mensagem * */
            $filename = md5(random_bytes(5)) . '.' . $request->file('anexo')->getClientOriginalExtension();
            /** @var Anexo $anexo * */
            $balancete = Balancete::create([
                'id_empresa' => $request->get('id_empresa'),
                'exercicio' => $request->get('exercicio'),
                'receitas' => $request->get('receitas'),
                'despesas' => $request->get('despesas'),
                'anexo' => $filename
            ]);
            //Enviar e-mail avisando q tem uma nova mensagem

            $request->file('anexo')->storeAs('balancetes/' . $request->get('id_empresa') . '/', $filename, 'public');
            $empresa = Empresa::findOrFail($request->get('id_empresa'));
            $empresa->usuario->notify(new BalanceteSent($balancete->exercicio->format('m/Y')));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }
}