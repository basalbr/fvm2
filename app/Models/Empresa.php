<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Empresa extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
        'cep',
        'cidade',
        'id_uf',
        'codigo_acesso_simples_nacional',
        'crc',
        'status',
        'id_enquadramento_empresa',
    ];

    protected static $status = ['em_analise' => 'Em Análise'];


    public function getMensalidadeAtual(): Mensalidade
    {
        return $this->mensalidades()->orderBy('created_at', 'desc')->first();
    }

    public function mensalidades(): HasMany
    {
        return $this->hasMany(Mensalidade::class, 'id_empresa');
    }

    public function getQtdeProLabores()
    {
        return $this->socios()->where('pro_labore', '>', 0)->count();
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

    public function errors()
    {
        return $this->errors;
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

    public function processos()
    {
        return $this->hasMany(Processo::class, 'id_empresa');
    }

    public function processos_documentos_contabeis()
    {
        return $this->hasMany(ProcessoDocumentoContabil::class, 'id_empresa');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function delete()
    {

        if ($this->processos->count()) {
            foreach ($this->processos as $processo) {
                $processo->delete();
            }
        }
        if ($this->processos_documentos_contabeis->count()) {
            foreach ($this->processos_documentos_contabeis as $processo) {
                $processo->delete();
            }
        }

        if ($this->funcionarios->count()) {
            foreach ($this->funcionarios as $funcionarios) {
                $funcionarios->delete();
            }
        }

        if ($this->socios->count()) {
            foreach ($this->socios as $socios) {
                $socios->delete();
            }
        }

        parent::delete();
    }

    public function getSocioPrincipal()
    {
        return $this->socios()->where('principal', '=', 1)->first();
    }

}
