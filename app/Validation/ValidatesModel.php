<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 16/03/2017
 * Time: 20:52
 */

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

trait ValidatesModel
{
    protected static $niceNames;
    protected static $rules;
    protected static $validationErrors;

    public static function validate($data)
    {
        $validator = Validator::make($data, self::$rules);
        $validator->setAttributeNames(self::$niceNames);
        if ($validator->fails()) {
            self::$validationErrors = $validator->errors()->all();
            return false;
        }
        return true;
    }

    public static function validationErrors()
    {
        return self::$validationErrors;
    }

}