<?php

namespace App\Services;

use App\Repositories\BranchRepository;
use App\Repositories\DepositRepository;
use App\Repositories\ProductRepository;
use Exception;

class ValidateService
{


    /**
     * Validação da existencia de Produtos, Depositos e Filiais
     * @param array $params ex: $params['id_produto' => 1, 'id_deposito' => 1]
     * @return boolean 
     */
    public static function existenceProductDepositBranch(array $params){
        try {
            if(!count($params)){
                throw new Exception("Parâmetros inválidos para a função existenceProductDepositBranch");
            }
            
            if(!count(ProductRepository::getProductById($params['id_produto']))){
                throw new Exception("Produto não encontrado");
            }

            if(!count(DepositRepository::getDepositById($params['id_deposito']))){
                throw new Exception("Deposito não encontrado");
            }
            
            if(!count(BranchRepository::getBranchById($params['id_produto']))){
                throw new Exception("Filial não encontrado");
            }
            
            return ['error' => false, 'message' => 'ID existentes'];
        } catch (Exception $ex) {
            return ['error' => true, 'message' => $ex->getMessage()];
        }
    }
}