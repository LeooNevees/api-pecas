<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'nome',
        'id_grupo_itens',
        'id_unidade_medida',
        'id_grupo_unidade_medida',
        'id_filial',
        'item_compra',
        'item_venda',
        'id_usuario_cadastro',
        'status',
        'data_cadastro',
    ];
}
