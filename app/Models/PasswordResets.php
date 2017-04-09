<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class PasswordResets extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

}
