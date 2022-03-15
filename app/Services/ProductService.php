<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Stock;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    private $params;
    private $message;

    /**
     * Campos obrigatórios para validação
     */
    private function fields(){
        return [
            'nome' => 'required',
            'id_grupo_itens' => 'required',
            'id_unidade_medida' => 'required',
            'id_grupo_unidade_medida' => 'required',
            'id_filial' => 'required',
            'id_deposito' => 'required',
            'item_compra' => 'required',
            'item_venda' => 'required',
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
            'id_grupo_itens' => $params['id_grupo_itens'],
            'id_unidade_medida' => $params['id_unidade_medida'],
            'id_grupo_unidade_medida' => $params['id_grupo_unidade_medida'],
            'id_filial' => $params['id_filial'],
            'item_compra' => $params['item_compra'],
            'item_venda' => $params['item_venda'],
            'id_usuario_cadastro' => 3,
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

            $returnProduct = ProductRepository::getPoductByBranch($this->params);
            if(count($returnProduct)){
                throw new Exception("Produto já cadastrado para Filial");
            }

            $returnInsert = Product::create($this->params);
            if($returnInsert === false){
                throw new Exception("Erro ao cadastrar produto: $returnInsert");
            }
            $this->params['id_produto'] = $returnInsert->id;

            $returnStock = (new StockService)->store($this->params);
            if($returnStock === false){
                throw new Exception("Erro ao cadastrar estoque: $returnStock");
            }

            return response()->json(['error' => false, 'message' => 'Produto cadastrado com sucesso'], 200);
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
            
            if(!count(ProductRepository::getProductById($id)->get())){
                throw new Exception("Produto não encontrada por ID");
            }

            $returnProduct = ProductRepository::getPoductByBranch($this->params);
            if(count($returnProduct)){
                throw new Exception("Nome de Produto já cadastrado");
            }

            //COLOCAR TRATATIVA DE ESTOQUE AQUI PARA CASOS QUE ESTEJAM COM ESTOQUE POSITIVO SERÁ NECESSÁRIO DAR BAIXA

            ProductRepository::update($id, $this->params);

            return response()->json(['error' => false, 'message' => 'Produto atualizado com sucesso'], 200);
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
            $deposit = Product::find($id);
            if (is_null($deposit)) {
                throw new Exception("Produto não encontrado");
            }
    
            return response()->json($deposit, 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}