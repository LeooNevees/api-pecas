<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository
{
    /**
     * @param array $params ex: $params['id_produto, 'id_deposito, 'id_filial].
     * @return array || boolean
     */
    public static function getBranchByCnpj(array $params)
    {
        return Branch::where('cnpj', $params['cnpj'])
            ->where('status', 'A')
            ->get();
    }

    /**
     * @param int $id
     * @return array || boolean
     */
    public static function getBranchById(int $id)
    {
        return Branch::where("id", $id)->get();
    }

    /**
     * @param int $id
     * @param array $params
     * @return array || boolean
     */
    public static function update(int $id, array $params)
    {
        return Branch::where('id', $id)->update($params);
    }
}