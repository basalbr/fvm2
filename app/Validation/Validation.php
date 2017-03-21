<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 12:43
 */

namespace App\Validation;


abstract class Validation
{
    protected static $rules;
    protected static $niceNames;

    public static function getRules()
    {
        return static::$rules;
    }

    public static function getNiceNames()
    {
        return static::$niceNames;
    }
}