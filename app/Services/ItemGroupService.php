<?php

namespace App\Services;

use App\Models\ItemGroup;
use App\Repositories\ItemGroupRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class ItemGroupService
{
    private $params;
    private $message;

    /**
     * Campos obrigatórios para validação
     */
    private function fields(){
        return [
            'nome' => 'required',
            'sequencial' => 'required',
            'id_filial' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratatdos
     */
    private function treatmentParamsLine(array $params)
    {
        $newParams = array_map('mb_strtoupper', $params);
        return [
            'nome' => mb_strtoupper($params['nome']),
            'sequencial' => $params['sequencial'],
            'id_filial' => $newParams['id_filial'],
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

            $returnGroup = ItemGroupRepository::getGroupItem($this->params);
            if(count($returnGroup)){
                throw new Exception("Grupo de itens já cadastrado");
            }

            ItemGroup::create($this->params);
            return response()->json(['error' => false, 'message' => 'Grupo Itens cadastrado com sucesso'], 200);
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
                throw new Exception("Parâmetros inválidos para a atualização do Grupo de Itens");
            }
            
            $returnGroup = ItemGroupRepository::getGroupById($id);
            if(!count($returnGroup)){
                throw new Exception("Grupo de Itens não encontrado");
            }
            
            ItemGroupRepository::update($id, [$this->params['status']]);

            return response()->json(['error' => false, 'message' => 'Grupo de Itens atualizado com sucesso'], 200);
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
            $user = ItemGroup::find($id);
            if (is_null($user)) {
                throw new Exception("Grupo de Itens não encontrado");
            }
    
            return response()->json($user, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}