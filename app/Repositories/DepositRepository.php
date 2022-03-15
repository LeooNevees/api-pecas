<?php

namespace App\Repositories;

use App\Models\Deposit;

class DepositRepository
{
    /**
     * @param array $params ex: $params['id_produto, 'id_deposito, 'id_filial].
     * @return array || boolean
     */
    public static function getDepositByBranch(array $params)
    {
        return Deposit::where('nome', $params['nome'])
        ->where('id_filial', $params['id_filial'])
        ->where('status', 'A')->get();
    }

    /**
     * @param int $id
     * @return array || boolean
     */
    public static function getDepositById(int $id)
    {
        return Deposit::where("id", $id)->get();
    }

    /**
     * @param int $id
     * @param array $params
     * @return array || boolean
     */
    public static function update(int $id, array $params)
    {
        return Deposit::where('id', $id)->update($params);
    }
}