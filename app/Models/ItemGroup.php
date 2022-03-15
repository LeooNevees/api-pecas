<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model
{
    use HasFactory;

    protected $table = 'grupo_itens';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'nome',
        'sequencial',
        'id_filial',
        'status',
        'data_cadastro',
    ];
}
