<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $table = 'depositos';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'nome',
        'localizacao',
        'id_filial',
        'id_usuario_cadastro',
        'status',
        'data_cadastro',
    ];
}
