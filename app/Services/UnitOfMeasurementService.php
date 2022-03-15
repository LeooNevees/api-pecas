<?php

namespace App\Services;

use App\Models\UnitOfMeasurement;
use App\Repositories\UnitOfMeasurementRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class UnitOfMeasurementService
{
    private $params;
    private $message;

    /**
     * Campos obrigatórios para validação
     */
    private function fields(){
        return [
            'codigo' => 'required',
            'descricao' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratatdos
     */
    private function treatmentParamsLine(array $params)
    {
        $newParams = array_map('mb_strtoupper', $params);
        return [
            'codigo' => $newParams['codigo'],
            'descricao' => $newParams['descricao'],
            'status' => 'A',
            'data_cadastro' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Validação dos dados vindos para utilizacao no Store e Update
     */
    private function init()
    {
        try {
            $validator = Validator::make($this->params, $this->fields());
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $this->params = $this->treatmentParamsLine($this->params);
            return true;
        } catch (\Throwable $ex) {
            $this->message = $ex->getMessage();
            return false;
        }
    }

    /**
     * Validação dos dados vindos da Request
     */
    public function store(array $params){
        try {
            $this->params = $params;
            $ret = $this->init();
            if($ret === false){
                throw new Exception($this->message);
            }

            $returnUnit = UnitOfMeasurementRepository::getUnit($this->params);
            if(count($returnUnit)){
                throw new Exception("Unidade de Medida já cadastrada");
            }

            UnitOfMeasurement::create($this->params);
            return response()->json(['error' => false, 'message' => 'Unidade de Medida cadastrada com sucesso'], 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }

    /**
     * Atualização de dados
     */
    public function update(array $params, int $id)
    {
        try {
            if(!isset($params['status'])){
                throw new Exception("Parâmetros inválidos para a atualização da Unidade de Medida");
            }
            
            $returnUnit = UnitOfMeasurementRepository::getUnitById($id);
            if(!count($returnUnit)){
                throw new Exception("Unidade de Medida não encontrada");
            }
            
            UnitOfMeasurementRepository::update($id, [$this->params['status']]);

            return response()->json(['error' => false, 'message' => 'Unidade de Medida atualizada com sucesso'], 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }

    /**
     * Mostragem de dados
     */
    public function show(int $id)
    {
        try {
            $user = UnitOfMeasurement::find($id);
            if (is_null($user)) {
                throw new Exception("Unidade de Medida não encontrado");
            }
    
            return response()->json($user, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}