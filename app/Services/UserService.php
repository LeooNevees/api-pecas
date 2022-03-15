<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class UserService
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
            'nome_completo' => 'required',
            'documento' => 'required',
            'password' => 'required',
            'tipo' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'id_filial' => 'required',
            'acesso_modulos' => 'required',
        ];
    }

    /**
     * Retornar parâmetros tratatdos
     */
    private function treatmentParamsLine(array $params)
    {
        $newParams = array_map('mb_strtoupper', $params);
        return [
            'nome_completo' => $newParams['nome_completo'],
            'documento' => str_replace(array("-", "."), '', $params['documento']),
            'login' => $newParams['email'],
            'password' => Hash::make($params['password']),
            'tipo' => $newParams['tipo'],
            'email' => $newParams['email'],
            'telefone' => $newParams['telefone'],
            'id_filial' => (int) $params['id_filial'],
            'acesso_modulos' => (int) $params['acesso_modulos'],
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

            if(count(User::where('documento', $this->params['documento'])->get())){
                throw new Exception("Usuário já cadastrado com documento similar");
            }
            User::create($this->params);
            return response()->json(['error' => false, 'message' => 'Usuário cadastrado com sucesso'], 200);
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

            if(!count(User::where("id", $id)->get())){
                throw new Exception("Usuário não encontrado");
            }

            User::where('id', $id)->update($this->params);

            return response()->json(['error' => false, 'message' => 'Usuário atualizado com sucesso'], 200);
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
            $user = User::find($id);
            if (is_null($user)) {
                throw new Exception("Usuário não encontrado");
            }
    
            return response()->json($user, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}