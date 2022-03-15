<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUnitOfMeasure extends Model
{
    use HasFactory;

    protected $table = 'grupo_unidade_medida';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'nome',
        'descricao',
        'id_unidade_medida',
        'id_filial',
        'unidade_base',
        'valor_convertido',
        'id_usuario_cadastro',
        'status',
        'data_cadastro',
    ];
}
