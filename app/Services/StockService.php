<?php

namespace App\Services;

use App\Models\Stock;
use App\Repositories\StockRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class StockService
{
    private $params;
    private $message;

    /**
     * Campos obrigatórios para validação
     */
    private function fields(){
        return [
            'id_produto' => 'required',
            'id_deposito' => 'required',
            'id_filial' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratatdos
     */
    private function treatmentParamsLine(array $params)
    {
        return [
            'id_produto' => $params['id_produto'],
            'id_deposito' => $params['id_deposito'],
            'id_filial' => $params['id_filial'],
            'quantidade' => 0,
            'status' => 'A',
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

            $returnStock = StockRepository::getStockByPoduct($this->params);
            if(count($returnStock)){
                throw new Exception("Estoque já cadastrado para esse Produto");
            }

            $returnExists = ValidateService::existenceProductDepositBranch($this->params);
            if($returnExists === false || $returnExists['error']){
                throw new Exception($returnExists['message']);
            }

            Stock::create($this->params);
            return response()->json(['error' => false, 'message' => 'Estoque cadastrado com sucesso'], 200);
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
            if(!isset($params['status']) && !isset($params['quantidade'])){
                throw new Exception("Parâmetros inválidos para a atualização do Estoque");
            }
            
            $returnStock = StockRepository::getStockId($id);
            if(!count($returnStock)){
                throw new Exception("Estoque não encontrado");
            }

            $this->params['quantidade'] = $returnStock[0]->quantidade + $this->params['quantidade'];
            
            StockRepository::update($id, $this->params);

            return response()->json(['error' => false, 'message' => 'Estoque atualizado com sucesso'], 200);
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
            $user = Stock::find($id);
            if (is_null($user)) {
                throw new Exception("Estoque não encontrado");
            }
    
            return response()->json($user, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}