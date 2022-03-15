<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * @param array $params ex: $params['id_produto, 'id_deposito, 'id_filial].
     * @return array || boolean
     */
    public static function getPoductByBranch(array $params)
    {
        return Product::where('nome', $params['nome'])
        ->where('id_filial', $params['id_filial'])
        ->where('status', 'A')->get();
    }

    /**
     * @param int $id
     * @return array || boolean
     */
    public static function getProductById(int $id)
    {
        return Product::where("id", $id)->get();
    }

    /**
     * @param int $id
     * @param array $params
     * @return array || boolean
     */
    public static function update(int $id, array $params)
    {
        return Product::where('id', $id)->update($params);
    }
}