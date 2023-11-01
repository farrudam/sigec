<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\ItemEmprestimo;
use sigec\models\Chave;
use sigec\models\Emprestimo;
use sigec\models\Autenticador;
use sigec\database\DBSigec;


class ItemEmprestimoController extends Controller{
    
    public function create(Request $request, Response $response, $args){
       $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);         
        
        if(isset($postParam)){
            ItemEmprestimo::create($postParam);
            $chave = new Chave($postParam['id_chave']);
            $chave->emprestar();
            return $response->withStatus(301)->withHeader('Location', '../emprestimos/ativos'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'emprestimo_itens.html', [ ]);                
    }
    
    public function devolver(Request $request, Response $response, $args){         
        
        $db = DBSigec::getKeys();
        
        $db->beginTransaction();
        
        try {
            // Localiza o usuário operador do sistema
            $mat_user = Autenticador::instanciar()->getMatricula();
            
            // Devolver o item do emprestimo (chave)            
            ItemEmprestimo::devolver($args['id'], $args['id_chave'], $mat_user);
            
            // Atualizar a situação da chave devolvida
            Chave::devolver($args['id_chave']);
            
            // Verificar se todas as chaves do empréstimo foram devolvidas
            $chavesEmprestimo = ItemEmprestimo::getByEmprestimo($args['id']);
            $todasChavesDevolvidas = true;
            foreach ($chavesEmprestimo as $itemEmprestimo) {
                if (!$itemEmprestimo->getDevolvidoEm()) {
                    $todasChavesDevolvidas = false;
                    break; 
                }
            }
           
            // Se todas as chaves foram devolvidas, atualizar a situação do empréstimo
            if ($todasChavesDevolvidas) {
                Emprestimo::encerrar($args['id'], $mat_user);                
            }
            
            $db->commit();            
            
            $this->container['flash']->addMessage('success', 'Chave devolvida com sucesso!');            
            return $response->withStatus(301)->withHeader('Location', '../../../../emprestimos/ativos');
            
            
        } catch (Exception $e) {
            $db->rollback();
            // Lidar com o erro de alguma maneira apropriada. Mensagem Flash
        }

    }
}

