<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use sigec\models\Emprestimo;
use sigec\models\ItemEmprestimo;
use sigec\models\RestricaoChave;
use sigec\models\Usuario;
use sigec\models\Bloco;
use sigec\models\Chave;
use sigec\database\DBSigec;
use sigec\models\Autenticador;


class EmprestimoController extends Controller{
    
    public function create(Request $request, Response $response, $args) {      

        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);          

        
        if(isset($postParam)){
            
            // Dividir a string em um array usando a vírgula como delimitador
            $itensEmprestimoString = $postParam['itensEmprestimo'];
            
            $postParam['itensEmprestimo'] = explode(',', $itensEmprestimoString);
                        
            // Localiza o usuário operador do sistema
            $postParam['mat_user_abertura'] = Autenticador::instanciar()->getMatricula();            
            
        }           
        
        $senhaInformada = md5($postParam['senha']);
        $usuario = (new Usuario())->getByMatricula($postParam['mat_solic']);
        $senhaCorreta = $usuario->getSenha();
            
        try {
            
            // Verifique a senha do usuário
            if ($senhaInformada != $senhaCorreta) {                
                $this->container['flash']->addMessage('error', 'Senha incorreta! Empréstimo não realizado.');
                return $response->withStatus(301)->withHeader('Location', '../emprestimo/novo'); 
            }
            
            // Inicia a transação
            $db = DBSigec::getKeys();        
            $db->beginTransaction();

            // Etapa 1: Cria um novo empréstimo                

            Emprestimo::create($postParam);

            // Etapa 2: Obtem o ID do empréstimo recém-criado
            $idEmprestimo = $db->lastInsertId();                

            $postParam['id_emprestimo'] = $idEmprestimo;
                        

            // Etapa 3: Obtem as chaves selecionada
            $chavesSelecionadas = $postParam['itensEmprestimo'];

            foreach ($chavesSelecionadas as $idChave) {
                // Etapa 3.1: Crie um novo objeto ItemEmprestimo para cada chave selecionada

                $postParam['id_chave'] = $idChave;                    

                ItemEmprestimo::create($postParam);

                // Etapa 3.2: Alterar o estado da chave para emprestada

                Chave::emprestar($idChave);
            }
            
//            var_dump($postParam);
//            die();

            // Commit da transação
            $db->commit();
            
            $this->container['flash']->addMessage('success', 'Empréstimo realizado!');            
            return $response->withStatus(301)->withHeader('Location', '../emprestimos/ativos'); 
            
            
        } catch (PDOException $e) {
            // Em caso de erro, desfaz a transação
            $db->rollBack();

            // Manipule o erro, registre ou exiba uma mensagem de erro adequada
            echo "Erro: " . $e->getMessage();
        }
    }   
    
    public function novo(Request $request, Response $response, $args){   
         
        $blocos = (new Bloco)->getAll();  
        $chaves = (new Chave)->getAll();
        $itens_emprestimos = (new ItemEmprestimo)->getAll();
        $emprestimos = (new Emprestimo)->getAll(); 
        $restricoes = (new RestricaoChave)->getAll();
                        
        return $this->container['renderizar']->render($response, 'exibir_chaves.html', [
            'blocos' => $blocos,
            'chaves' => $chaves,
            'emprestimos' => $emprestimos,
            'itens_emprestimos' => $itens_emprestimos,
            'restricoes' => $restricoes
        ]);
    }
    
    public function show(Request $request, Response $response, $args){        
        $emprestimos = (new Emprestimo)->getAll();  
        $itens_emprestimos = (new ItemEmprestimo)->getAll();  
                        
        return $this->container['renderizar']->render($response, 'listar_emprestimos.html', [
            'emprestimos' => $emprestimos,
            'itens_emprestimos' => $itens_emprestimos
        ]);
    }
    
    public function meusEmprestimos(Request $request, Response $response, $args){ 
        
        // Localiza o usuário operador do sistema
        $mat_solic = Autenticador::instanciar()->getMatricula();
        
        $emprestimos = (new Emprestimo())->getMyEmprestimos($mat_solic);  
        
        $itens_emprestimos = (new ItemEmprestimo)->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_meus_emprestimos.html', [
            'emprestimos' => $emprestimos,
            'itens_emprestimos' => $itens_emprestimos
        ]);
    }
    
    public function ativos(Request $request, Response $response, $args){        
        $emprestimos = (new Emprestimo)->getAtivos();  
        $itens_emprestimos = (new ItemEmprestimo)->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_emprestimos_ativos.html', [
            'emprestimos' => $emprestimos,
            'itens_emprestimos' => $itens_emprestimos
        ]);
    }
    
    public function encerrados(Request $request, Response $response, $args){        
        $emprestimos = (new Emprestimo)->getEncerrados();  
        $itens_emprestimos = (new ItemEmprestimo)->getAll();  
                        
        return $this->container['renderizar']->render($response, 'listar_emprestimos_encerrados.html', [
            'emprestimos' => $emprestimos,
            'itens_emprestimos' => $itens_emprestimos
        ]);
    }
    
    public function detalhes(Request $request, Response $response, $args){        
        $emprestimo = (new Emprestimo($args['id']))->getById();
        $chaves = (new Emprestimo($args['id']))->getChaves();
                        
        return $this->container['renderizar']->render($response, 'detalhar_emprestimo.html', [
            'emprestimo' => $emprestimo,
            'itens_emprestimo' => $chaves
        ]);
    }     

    public function relatorio(Request $request, Response $response, $args){
        $objeto = new Emprestimo();
        $emprestimo = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'relatorio.html', [
            'emprestimos' => $emprestimo
        ]);
    }
    
    public function concluir(Request $request, Response $response, $args){

        $db = DBSigec::getKeys();        
        $db->beginTransaction();
        
        try {
            
            // Localiza o usuário operador do sistema
            $mat_user = Autenticador::instanciar()->getMatricula();
                        
            // Verificar se todas as chaves do empréstimo foram devolvidas
            $chavesEmprestimo = ItemEmprestimo::getByEmprestimo($args['id']);//            

            foreach ($chavesEmprestimo as $itemEmprestimo) {
                
                ItemEmprestimo::devolver($args['id'], $itemEmprestimo->getIdChave(), $mat_user);
                    
            }
            //Devolver todas as chaves do empréstimo 
            Chave::devolverChaves($args['id']);
            //atualizar situacao do emprestimo
            Emprestimo::encerrar($args['id'], $mat_user);
            $db->commit();            
                        
            $this->container['flash']->addMessage('success', 'Empréstimo concluído!');
            return $response->withStatus(301)->withHeader('Location', '../../emprestimos/ativos');
        
            
        } catch (Exception $e) {
            $db->rollback();
            // Lidar com o erro de alguma maneira apropriada. Mensagem Flash
        }
    }
         
    public function buscar(Request $request, Response $response, $args)
    {
        
        $matricula = $args['matricula'];

        $usuario = (new Usuario())->buscar($matricula);
                        
        if (count($usuario) > 0) {
            $dadosUsuario = array(
                'id' => $usuario[0]->getId(),
                'mat_solic' => $usuario[0]->getMatricula(),
                'nome' => $usuario[0]->getNome(),
                'email' => $usuario[0]->getEmail(),
                'cargo' => $usuario[0]->getCargo(),
                'habilitado' => $usuario[0]->getHabilitado(),
                'url_foto' => $usuario[0]->getUrl_foto()
                
            );
            
            // Chaves restritas do usuário            
            $chavesRestritas = (new RestricaoChave())->buscarChavesRestritas($matricula);
                        
            $dadosUsuario['chavesRestritas'] = $chavesRestritas;  
                        
            header('Content-Type: application/json');
            echo json_encode($dadosUsuario);
        }        
    } 
}

