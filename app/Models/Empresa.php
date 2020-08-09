<?php

namespace App\Models;

use App\Notifications\NewApuracao;
use App\Notifications\NewProcessoDocumentosContabeis;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/* @property Usuario usuario */
class Empresa extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'ativacao_programada', 'data_abertura'];

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
        'certificado_digital',
        'senha_certificado_digital',
        'data_abertura'
    ];

    protected static $documentos_migracao = [
        'need_ato_constitutivo' => 'Contrato Social/Requerimento de Empresário',
        'need_alteracao' => 'Alterações Contratuais',
        'need_gfip' => 'Última SEFIP/GFIP transmitida',
        'need_ficha_funcionario' => 'Ficha de registro de contribuintes e funcionários',
        'need_balancete' => 'Balancete'
    ];

    protected static $status = ['em_analise' => 'Em Análise', 'aprovado' => 'Aprovado', 'cancelado' => 'Cancelado'];

    public function hasDocumento($doc){
        return self::$documentos_migracao[$doc] && $this->anexos()->where('descricao', self::$documentos_migracao[$doc])->count() > 0 ? true : false;

    }

    public function getDocumento($doc){
        return $this->anexos()->where('descricao', self::$documentos_migracao[$doc])->first();
    }

    public function hasPendencias()
    {
        foreach (self::$documentos_migracao as $documento => $anexo) {
            if ($this->$documento && $this->anexos()->where('descricao', $anexo)->count() == 0) {
                return true;
            }
        }
        return false;
    }

    public function getPendencias(){
        $pendencias = [];
        foreach (self::$documentos_migracao as $documento => $anexo) {
            if ($this->$documento && $this->anexos()->where('descricao', $anexo)->count() == 0) {
                $pendencias[] = $anexo;
            }
        }
        return $pendencias;
    }

    public function isPendente($doc){
        return in_array($doc, $this->getPendencias());
    }

    public function abrirApuracoes()
    {
        if ($this->status !== 'Aprovado') {
            return false;
        }
            if (strtolower($this->tipoTributacao->descricao) == 'mei') {
                $impostosMes = ImpostoMes::where('mes', '=', (date('n') - 1))->where('id_imposto', 4)->get();
            } else if(strtolower($this->tipoTributacao->descricao) == 'lucro_presumido') {
                $impostosMes = ImpostoMes::where('mes', '=', (date('n') - 1))->whereIn('id_imposto',[2,3,5,6])->get();
            } else{
                $impostosMes = ImpostoMes::where('mes', '=', (date('n') - 1))->whereIn('id_imposto',[1,2,3])->get();
            }
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
    }

    public function setAtivacaoProgramadaAttribute($value)
    {
        if ($value) {
            $this->attributes['ativacao_programada'] = Carbon::createFromFormat('d/m/Y', $value);
        } else {
            $this->attributes['ativacao_programada'] = null;
        }
    }

    public function setDataAberturaAttribute($value)
    {
        if ($value) {
            $this->attributes['data_abertura'] = Carbon::createFromFormat('d/m/Y', $value);
        } else {
            $this->attributes['data_abertura'] = null;
        }
    }

    public function getUltimosDozeMeses(){

        return CarbonPeriod::create(Carbon::now()->subMonths($this->data_abertura->diffInMonths(Carbon::now()) > 12 ? 13 : $this->data_abertura->diffInMonths(Carbon::now())), '1 month', Carbon::now()->subMonths(2));
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

    public function faturamentos()
    {
        return $this->hasMany(HistoricoFaturamento::class, 'id_empresa');
    }

    public function tributacoes()
    {
        return $this->hasMany(Tributacao::class, 'id_empresa');
    }

    public function alteracoes()
    {
        return $this->hasMany(Alteracao::class, 'id_empresa');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensalidades(): HasMany
    {
        return $this->hasMany(Mensalidade::class, 'id_empresa');
    }

    public function balancetes(): HasMany
    {
        return $this->hasMany(Balancete::class, 'id_empresa');
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
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function getRazaoSocialAttribute($attr)
    {
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
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

    public function decimosTerceiro()
    {
        return $this->hasMany(DecimoTerceiro::class, 'id_empresa');
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

    public function mensalidadesPendentes()
    {
        return $this->hasManyThrough(
            OrdemPagamento::class,
            Mensalidade::class,
            'id_empresa',
            'id_referencia',
            'id'
        )->where('referencia', 'mensalidade')->whereNotIn('ordem_pagamento.status', ['Paga', 'Cancelada']);
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
        if ($this->processosFolha->count()) {
            foreach ($this->processosFolha as $folha) {
                $folha->delete();
            }
        }
        if ($this->decimosTerceiro()->count()) {
            foreach ($this->processosFolha as $folha) {
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
        $periodo = date('Y-m-01', strtotime(date('Y-m') . " -1 month"));
        if ($this->processosDocumentosContabeis()->where('periodo', '=', $periodo)->count()) {
            return false;
        }
        $processo = new ProcessoDocumentoContabil(['id_empresa' => $this->id, 'periodo' => $periodo, 'status' => 'pendente']);
        $processo->save();
        /** @var ProcessoDocumentoContabil $processo */
//            $processo = $this->processosDocumentosContabeis()->create([
//                'periodo' => $periodo, 'status' => 'pendente'
//            ]);
        DB::commit();
        $this->usuario->notify(new NewProcessoDocumentosContabeis($processo));
        return true;
    }

    public function getQtdMensagensNaoLidas($isAdmin = false)
    {
        if ($isAdmin) {
            return $this->mensagens()->where('from_admin', 1)->where('lida', 0)->count();
        }
        return $this->mensagens()->where('from_admin', 0)->where('lida', 0)->count();
    }

    public function hasFolha($competencia)
    {
        return $this->processosFolha()->where('competencia', $competencia)->count() > 0 ? true : false;
    }

    public function hasSimplesNacional($competencia)
    {
        return $this->apuracoes()->where('competencia', $competencia)->where('id_imposto', 1)->count() > 0 ? true : false;
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getEnderecoCompleto()
    {
        return $this->endereco . ($this->numero ? ', ' . $this->numero : '') . ($this->complemento ? ', ' . $this->complemento : '') . ', ' . $this->bairro . ', ' . $this->cidade . '/' . $this->uf->sigla . ', ' . $this->cep;
    }

    public function getLabelStatus()
    {
        if (strpos($this->getOriginal('status'), 'em_analise') === 0) {
            return '<span class="label label-warning fadeIn infinite animated">Em análise</span>';
        } elseif (strpos($this->getOriginal('status'), 'aprovado') === 0) {
            return '<span class="label label-success flash animated">Aprovada</span>';
        } elseif (strpos($this->getOriginal('status'), 'cancelado') === 0) {
            return '<span class="label label-danger fadeIn infinite animated">Cancelada</span>';
        }
        return '<span class="label label-info">Novo</span>';
    }

    public function getReceitaBrutaUltimosDozeMesesSN($competencia, $mercado){
        if(Carbon::now()->diffInMonths($this->data_abertura)>=12){
            return $this->faturamentos()->where('mercado', $mercado)->where('competencia', '<', $competencia)->orderBy('competencia', 'desc')->limit(12)->sum('valor');
        }else{
            $faturamentos = $this->faturamentos()->where('mercado', $mercado)->where('competencia', '<', $competencia)->orderBy('competencia', 'desc')->limit(12)->get();
            return number_format(($faturamentos->sum('valor') / $faturamentos->count()) * 12, 2);
        }
        return $this->faturamentos()->where('mercado', $mercado)->where('competencia', '<', $competencia)->orderBy('competencia', 'desc')->limit(12)->sum('valor');
    }

}
