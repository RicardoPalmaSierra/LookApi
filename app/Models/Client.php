<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    static public $allRelations = [
        "user"
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'usuarios_id');
    }
}
