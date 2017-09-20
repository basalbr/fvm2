<?php

namespace App\Models;

use App\Notificacao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Funcionario
 * @package App\Models
 * @property Empresa empresa
 */
class Funcionario extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_empresa',
        'id_uf_ctps',
        'id_uf',
        'nome_completo',
        'nome_mae',
        'nome_pai',
        'nacionalidade',
        'naturalidade',
        'data_nascimento',
        'cpf',
        'rg',
        'titulo_eleitoral',
        'zona_secao_eleitoral',
        'carteira_reservista',
        'categoria_carteira_reservista',
        'cnh',
        'categoria_cnh',
        'vencimento_cnh',
        'email',
        'telefone',
        'data_chegada_estrangeiro',
        'numero_processo_mte',
        'validade_carteira_trabalho',
        'casado_estrangeiro',
        'filho_estrangeiro',
        'numero_rne',
        'orgao_emissor_rne',
        'data_validade_rne',
        'cep',
        'bairro',
        'endereco',
        'numero',
        'cidade',
        'complemento',
        'residente_exterior',
        'residencia_propria',
        'imovel_fgts',
        'pis',
        'data_cadastro_pis',
        'ctps',
        'id_grau_instrucao',
        'id_grupo_sanguineo',
        'id_raca',
        'id_sexo',
        'id_condicao_estrangeiro',
        'novo_funcionario',
        'estrangeiro',
        'data_expedicao_rne',
        'data_emissao_ctps',
        'status',
        'id_estado_civil',
        'serie_ctps'
    ];


    protected $dates = ['data_nascimento', 'data_emissao_ctps', 'vencimento_cnh', 'data_chegada_estrangeiro', 'data_expedicao_rne', 'data_validade_rne', 'validade_carteira_trabalho', 'data_emissao_rg', 'data_cadastro_pis', 'created_at', 'updated_at', 'deleted_at'];
    protected $statusNiceNames = [
        'pendente' => '<span class="text-danger">Pendente</span>',
        'demitido' => '<span class="text-disabled">Demitido</span>',
        'ativo' => '<span class="text-success">Ativo</span>'
    ];

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    public function getStatus()
    {
        return $this->statusNiceNames[$this->status];
    }

    public function getNomeCompletoAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getNomePaiAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getNomeMaeAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getNacionalidadeAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function setDataNascimentoAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function setVencimentoCnhAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['vencimento_cnh'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function setDataChegadaEstrangeiroAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['data_chegada_estrangeiro'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function setValidadeCarteiraTrabalhoAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['validade_carteira_trabalho'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function setDataValidadeRneAttribute($value)
    {
        if (!empty($value)) {
            if (!empty($value)) {
                $this->attributes['data_validade_rne'] = Carbon::createFromFormat('d/m/Y', $value);
            }
        }
    }

    public function setDataCadastroPisAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['data_cadastro_pis'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function setDataExpedicaoRneAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['data_expedicao_rne'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function setDataEmissaoCtpsAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['data_emissao_ctps'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deficiencias()
    {
        return $this->belongsToMany(TipoDeficiencia::class, (new FuncionarioDeficiencia())->getTable(), 'id_funcionario', 'id_tipo_deficiencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependentes()
    {
        return $this->hasMany(FuncionarioDependente::class, 'id_funcionario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contratos()
    {
        return $this->hasMany(FuncionarioContrato::class, 'id_funcionario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alteracoes()
    {
        return $this->hasMany(AlteracaoContratual::class, 'id_funcionario');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentos()
    {
        return $this->hasMany(FuncionarioDocumento::class, 'id_funcionario');
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


}
