<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'filiais';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'razao_social',
        'descricao',
        'cnpj',
        'id_usuario_cadastro',
        'status',
        'data_cadastro',
    ];
}
