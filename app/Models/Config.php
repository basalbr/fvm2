<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:29
 */

namespace App\Models;

use App\Validation\ValidatesAberturaEmpresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * @property integer id
 * @property float valor_abertura_empresa
 * @property float valor_incremental_funcionario
 * @property string email_admin
 * @property string email_contato
 * @property string email_bugs
 * @property string whatsapp
 * @property string facebook
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 */
class Config extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'valor_abertura_empresa',
        'valor_incremental_funcionario',
        'email_admin',
        'email_contato',
        'email_bugs',
        'whatsapp',
        'facebook'
    ];

    protected static $daysOfWeek = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');

    protected $dates = ['created_at', 'updated_at'];

    public static function getAberturaEmpresaPrice()
    {
        return self::first()->valor_abertura_empresa;
    }

    public static function getWhatsapp()
    {
        return self::first()->whatsapp;
    }

    /**
     * @return array
     */
    public static function getDaysOfWeek()
    {
        return self::$daysOfWeek;
    }

    public static function getFuncionarioIncrementalPrice()
    {
        return self::first()->valor_incremental_funcionario;
    }

    public static function getPagseguroNotificationUrl()
    {
        return route('pagseguroNotification');
    }

    public static function getModelFromTable($table)
    {
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                $model = new $class;
                if ($model->getTable() === $table)
                    return $class;
            }
        }

        return false;
    }

}