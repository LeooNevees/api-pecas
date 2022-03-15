<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'estoques';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'id_produto',
        'id_deposito',
        'id_filial',
        'quantidade',
        'status',
    ];
}
