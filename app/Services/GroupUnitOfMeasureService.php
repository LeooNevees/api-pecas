<?php

namespace App\Services;

use App\Models\GroupUnitOfMeasure;
use App\Repositories\GroupUnitOfMeasureRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class GroupUnitOfMeasureService
{
    private $params;
    private $message;

    /**
     * Campos obrigatórios para validação
     */
    private function fields(){
        return [
            'nome' => 'required',
            'descricao' => 'required',
            'id_unidade_medida' => 'required',
            'id_filial' => 'required',
            'unidade_base' => 'required',
            'valor_convertido' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratatdos
     */
    private function treatmentParamsLine(array $params)
    {
        $newParams = array_map('mb_strtoupper', $params);
        return [
            'nome' => $newParams['nome'],
            'descricao' => $newParams['descricao'],
            'id_unidade_medida' => $newParams['id_unidade_medida'],
            'id_filial' => $newParams['id_filial'],
            'unidade_base' => $newParams['unidade_base'],
            'valor_convertido' => $newParams['valor_convertido'],
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

            $returnGroup = GroupUnitOfMeasureRepository::getGroupUnit($this->params);
            if(count($returnGroup)){
                throw new Exception("Grupo Unidade de Medida já cadastrada");
            }

            GroupUnitOfMeasure::create($this->params);
            return response()->json(['error' => false, 'message' => 'Grupo Unidade de Medida cadastrada com sucesso'], 200);
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
                throw new Exception("Parâmetros inválidos para a atualização do Grupo Unidade de Medida");
            }
            
            $returnGroup = GroupUnitOfMeasureRepository::getGroupById($id);
            if(!count($returnGroup)){
                throw new Exception("Grupo Unidade de Medida não encontrada");
            }
            
            GroupUnitOfMeasureRepository::update($id, [$this->params['status']]);

            return response()->json(['error' => false, 'message' => 'Grupo Unidade de Medida atualizada com sucesso'], 200);
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
            $user = GroupUnitOfMeasure::find($id);
            if (is_null($user)) {
                throw new Exception("Grupo Unidade de Medidas não encontrado");
            }
    
            return response()->json($user, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}