<?php

namespace App\Repositories;

use App\Models\Stock;

class StockRepository
{
    /**
     * @param array $params ex: $params['id_produto, 'id_deposito, 'id_filial].
     * @return array || boolean
     */
    public static function getStockByPoduct(array $params)
    {
        return Stock::where('id_produto', $params['id_produto'])
        ->where('id_deposito', $params['id_deposito'])
        ->where('id_filial', $params['id_filial'])
        ->get();
    }

    /**
     * @param int $id
     * @return array || boolean
     */
    public static function getStockId(int $id)
    {
        return Stock::where("id", $id)->get();
    }

    /**
     * @param int $id
     * @param array $params
     * @return array || boolean
     */
    public static function update(int $id, array $params)
    {
        return Stock::where('id', $id)->update($params);
    }
}