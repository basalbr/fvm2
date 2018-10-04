<?php

namespace App\Models;

use App\Notifications\NewApuracao;
use App\Notifications\NewProcessoDocumentosContabeis;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/* @property Usuario usuario */
class Empresa extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'ativacao_programada'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'ativacao_programada',
        'id_natureza_juridica',
        'id_tipo_tributacao',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'iptu',
        'nome_fantasia',
        'razao_social',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'cep',
        'cidade',
        'id_uf',
        'codigo_acesso_simples_nacional',
        'crc',
        'status',
        'id_enquadramento_empresa',
        'certificado_digital'
    ];

    protected static $status = ['em_analise' => 'Em Análise', 'aprovado' => 'Aprovado', 'cancelado' => 'Cancelado'];

    public function abrirApuracoes()
    {
        if ($this->status !== 'Aprovado') {
            return false;
        }
        try {
            DB::beginTransaction();
            $impostosMes = ImpostoMes::where('mes', '=', (date('n') - 1))->get();
            $competencia = date('Y-m-d', strtotime(date('Y-m') . " -1 month"));
            $apuracoes = $this->apuracoes()->where('competencia', '=', $competencia)->count();
            if ($apuracoes) {
                return false;
            }
            if (count($impostosMes)) {

                foreach ($impostosMes as $impostoMes) {

                    /* @var Imposto $imposto */
                    $imposto = $impostoMes->imposto;

                    /* @var Apuracao $apuracao */
                    $apuracao = $this->apuracoes()->create([
                        'competencia' => $competencia,
                        'id_imposto' => $imposto->id,
                        'vencimento' => $imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento, 'Y-m-d'),
                        'status' => 'novo'
                    ]);
                    $this->usuario->notify(new NewApuracao($apuracao));
                    DB::commit();
                }
            }
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }

    public function setAtivacaoProgramadaAttribute($value)
    {
        if ($value) {
            $this->attributes['ativacao_programada'] = Carbon::createFromFormat('d/m/Y', $value);
        } else {
            $this->attributes['ativacao_programada'] = null;
        }
    }

    public function getMensalidadeAtual(): Mensalidade
    {
        return $this->mensalidades()->orderBy('created_at', 'desc')->first();
    }

    public function apuracoes()
    {
        return $this->hasMany(Apuracao::class, 'id_empresa');
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensalidades(): HasMany
    {
        return $this->hasMany(Mensalidade::class, 'id_empresa');
    }

    public function getUltimaMensagem()
    {
        return $this->mensagens->count() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem encontrada';
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->usuario->id)->count();
    }

    public function getQtdeProLabores()
    {
        return $this->socios()->where('pro_labore', '>', 0)->count();
    }

    public function getNomeFantasiaAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getRazaoSocialAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getStatusAttribute($status)
    {
        return self::$status[$status];
    }

    public function isSimplesNacional()
    {
        if ($this->cnaes->count() > 0) {
            foreach ($this->cnaes as $cnae) {
                if ($cnae->cnae->id_tabela_simples_nacional == null) {
                    return false;
                }
            }
            return true;
        }
    }

    public function tipoTributacao()
    {
        return $this->belongsTo(TipoTributacao::class, 'id_tipo_tributacao');
    }

    public function naturezaJuridica()
    {
        return $this->belongsTo(NaturezaJuridica::class, 'id_natureza_juridica');
    }

    public function enquadramentoEmpresa()
    {
        return $this->belongsTo(EnquadramentoEmpresa::class, 'id_enquadramento_empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uf()
    {
        return $this->belongsTo(Uf::class, 'id_uf');
    }

    public function cnaes()
    {
        return $this->hasMany(EmpresaCnae::class, 'id_empresa');
    }

    public function socios()
    {
        return $this->hasMany(Socio::class, 'id_empresa');
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'id_empresa');
    }

    public function pontos()
    {
        return $this->hasMany(Ponto::class, 'id_empresa');
    }

    public function processosFolha()
    {
        return $this->hasMany(ProcessoFolha::class, 'id_empresa');
    }

    public function processosDocumentosContabeis()
    {
        return $this->hasMany(ProcessoDocumentoContabil::class, 'id_empresa');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }


    public function delete()
    {

        if ($this->apuracoes->count()) {
            foreach ($this->apuracoes as $processo) {
                $processo->delete();
            }
        }
        if ($this->processosDocumentosContabeis->count()) {
            foreach ($this->processosDocumentosContabeis as $processo) {
                $processo->delete();
            }
        }

        if ($this->funcionarios->count()) {
            foreach ($this->funcionarios as $funcionario) {
                $funcionario->delete();
            }
        }

        if ($this->socios->count()) {
            foreach ($this->socios as $socio) {
                $socio->delete();
            }
        }

        if ($this->cnaes->count()) {
            foreach ($this->cnaes as $cnae) {
                $cnae->delete();
            }
        }
        if ($this->mensalidades->count()) {
            foreach ($this->mensalidades as $mensalidade) {
                $mensalidade->delete();
            }
        }
        if($this->processosFolha->count()){
            foreach($this->processosFolha as $folha){
                $folha->delete();
            }
        }

        parent::delete();
    }

    public function getSocioPrincipal()
    {
        return $this->socios()->where('principal', '=', 1)->first();
    }

    public function abrirProcessosDocumentosContabeis()
    {
        try {
            DB::beginTransaction();
            $periodo = date('Y-m-01', strtotime(date('Y-m') . " -1 month"));
            if ($this->status !== 'Aprovado' || $this->processosDocumentosContabeis()->where('periodo', '=', $periodo)->count()) {
                return false;
            }
            /** @var ProcessoDocumentoContabil $processo */
            $processo = $this->processosDocumentosContabeis()->create([
                'periodo' => $periodo, 'status' => 'pendente'
            ]);
            $this->usuario->notify(new NewProcessoDocumentosContabeis($processo));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }

    }

    public function getQtdMensagensNaoLidas($isAdmin = false)
    {
        if ($isAdmin) {
            return $this->mensagens()->where('from_admin', 1)->where('lida', 0)->count();
        }
        return $this->mensagens()->where('from_admin', 0)->where('lida', 0)->count();
    }

}
