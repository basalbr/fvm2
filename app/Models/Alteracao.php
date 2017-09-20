<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

/**
 * @property integer id
 * @property integer id_abertura_empresa
 * @property string nome
 * @property string nome_mae
 * @property string nome_pai
 * @property boolean principal
 * @property \DateTime data_nascimento
 * @property string estado_civil
 * @property string email
 * @property string telefone
 * @property string cpf
 * @property string rg
 * @property string orgao_expedidor
 * @property string nacionalidade
 * @property string cep
 * @property integer id_uf
 * @property string endereco
 * @property integer numero
 * @property string complemento
 * @property string bairro
 * @property string cidade
 * @property double pro_labore
 * @property integer id_regime_casamento
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 * @property AberturaEmpresa empresa
 * @property Uf uf
 * @property RegimeCasamento regimeCasamento
 * @property Cnae cnae
 */
class Alteracao extends Model
{

    use SoftDeletes;

    protected $rules = ['id_pessoa' => 'required', 'id_tipo_alteracao' => 'required'];
    protected $errors;
    protected $niceNames = ['id_pessoa' => 'Empresa', 'id_tipo_alteracao' => 'Tipo de Alteração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'id_usuario', 'status', 'id_tipo_alteracao'];

    public function validateMeiMe($data)
    {
        $rules = ['id_pessoa' => 'required', 'titulo_eleitor' => 'required', 'recibo_ir' => 'sometimes'];
        $niceNames = ['id_pessoa' => 'Empresa', 'titulo_eleitor' => 'Título de Eleitor', 'recibo_ir' => 'Número do Recibo do Último Imposto de Renda'];
        return $this->validate($data, $rules, $niceNames);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }


    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAlteracao::class, 'id_tipo_alteracao');
    }

    public function informacoes()
    {
        return $this->hasMany(AlteracaoInformacao::class, 'id_alteracao');
    }

    public function getUltimaMensagem(){
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function pagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->usuario->id)->count();
    }

}
