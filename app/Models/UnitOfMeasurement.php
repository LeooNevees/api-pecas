<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasurement extends Model
{
    use HasFactory;

    protected $table = 'unidade_medida';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'codigo',
        'descricao',
        'status',
        'data_cadastro',
    ];
}
