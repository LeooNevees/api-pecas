<?php

namespace App\Repositories;

use App\Models\GroupUnitOfMeasure;

class GroupUnitOfMeasureRepository
{
    /**
     * @param array $params ex: $params['id_produto, 'id_deposito, 'id_filial].
     * @return array || boolean
     */
    public static function getGroupUnit(array $params)
    {
        return GroupUnitOfMeasure::where('nome', $params['nome'])
            ->where('id_filial', $params['id_filial'])
            ->where('status', 'A')
            ->get();
    }

    /**
     * @param int $id
     * @return array || boolean
     */
    public static function getGroupById(int $id)
    {
        return GroupUnitOfMeasure::where("id", $id)->get();
    }

    /**
     * @param int $id
     * @param array $params
     * @return array || boolean
     */
    public static function update(int $id, array $params)
    {
        return GroupUnitOfMeasure::where('id', $id)->update($params);
    }
}