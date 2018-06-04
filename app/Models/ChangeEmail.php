<?php

namespace App\Account\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeEmail extends Model
{
    protected $table = 'change_email';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'email',
        'created_at',
        'is_expired'
    ];
    protected $primaryKey = 'token';

    public $incrementing = false;

}