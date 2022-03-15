<?php

namespace App\Repositories;

use App\Models\UnitOfMeasurement;

class UnitOfMeasurementRepository
{
    /**
     * @param array $params ex: $params['id_produto, 'id_deposito, 'id_filial].
     * @return array || boolean
     */
    public static function getUnit(array $params){
        return UnitOfMeasurement::where('codigo', $params['codigo'])
            ->where('id_filial', $params['id_filial'])
            ->where('status', 'A')
            ->get();
    }

    /**
     * @param int $id
     * @return array || boolean
     */
    public static function getUnitById(int $id){
        return UnitOfMeasurement::where("id", $id)->get();
    }

    /**
     * @param int $id
     * @param array $params
     * @return array || boolean
     */
    public static function update(int $id, array $params){
        return UnitOfMeasurement::where('id', $id)->update($params);
    }
}