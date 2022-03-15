<?php

namespace App\Services;

use App\Models\Deposit;
use App\Repositories\DepositRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class DepositService
{
    public $statusCode;
    public $return;
    private $params;
    private $message;

    /**
     * Campos obrigatórios para validação
     */
    private function fields(){
        return [
            'nome' => 'required',
            'localizacao' => 'required',
            'id_filial' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratados
     */
    private function treatmentParamsLine(array $params)
    {
        $newParams = array_map('mb_strtoupper', $params);
        return [
            'nome' => $newParams['nome'],
            'localizacao' => $newParams['localizacao'],
            'id_filial' => $newParams['id_filial'],
            'id_usuario_cadastro' => 1,
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

            $returnDeposit = DepositRepository::getDepositByBranch($this->params);
            if(count($returnDeposit)){
                throw new Exception("Depósito já cadastrado para Filial");
            }

            Deposit::create($this->params);
            return response()->json(['error' => false, 'message' => 'Deposito cadastrado com sucesso'], 200);
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
            $this->params = $params;
            $ret = $this->init();
            if($ret === false){
                throw new Exception($this->message);
            }
            
            if(!count(DepositRepository::getDepositById($id))){
                throw new Exception("Depósito não encontrada por ID");
            }

            $returnDeposit = DepositRepository::getDepositByBranch($this->params);
            if(count($returnDeposit)){
                throw new Exception("Nome de Depósito já cadastrado");
            }

            DepositRepository::update($id, $this->params);

            return response()->json(['error' => false, 'message' => 'Depósito atualizado com sucesso'], 200);
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
            $deposit = Deposit::find($id);
            if (is_null($deposit)) {
                throw new Exception("Depósito não encontrado");
            }
    
            return response()->json($deposit, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}