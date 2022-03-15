<?php

namespace App\Services;

use App\Models\Branch;
use App\Repositories\BranchRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BranchService
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
            'razao_social' => 'required',
            'descricao' => 'required',
            'cnpj' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratados
     */
    private function treatmentParamsLine(array $params)
    {
        $newParams = array_map('mb_strtoupper', $params);
        return [
            'razao_social' => $newParams['razao_social'],
            'descricao' => $newParams['descricao'],
            'cnpj' => str_replace(array(".", "/", "-"), '', $newParams['cnpj']),
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
            
            if(count(BranchRepository::getBranchByCnpj($this->params))){
                throw new Exception("Filial já cadastrado com documento similar");
            }
            Branch::create($this->params);
            return response()->json(['error' => false, 'message' => 'Filial cadastrado com sucesso'], 200);
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
            
            $returnBranch = BranchRepository::getBranchById($id); 
            if(!count($returnBranch)){
                throw new Exception("Filial não encontrada por ID");
            }

            if($returnBranch[0]->cnpj != $this->params['cnpj']){
                throw new Exception("CNPJ fornecido diferente do cadastrado atualmente");
            }

            unset($this->params['cnpj']);
            Branch::where('id', $id)->update($this->params);

            return response()->json(['error' => false, 'message' => 'Filial atualizada com sucesso'], 200);
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
            $branch = Branch::find($id);
            if (is_null($branch)) {
                throw new Exception("Filial não encontrada");
            }
    
            return response()->json($branch, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}