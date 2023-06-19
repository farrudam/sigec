<?php

namespace sigec\models;
use sigec\database\DBSigec;
use sigec\models\Usuario;
use sigec\models\ItemEmprestimo;

class Emprestimo{

    private $id;
    private $mat_solic;
    private $mat_user_abertura;
    private $mat_user_devolucao;
    private $data_abertura;
    private $data_devolucao;
    private $observacao;
    private $situacao;    
    
    private $id_usuario;
    private $usuario;
    
    private $chaves = [];
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    private function bundle ($row){        
             
        $emprestimo = new Emprestimo($row['id']);        

        $emprestimo->setMatSolic($row['mat_solic']);
        $emprestimo->setMatUserAbertura($row['mat_user_abertura']);
        $emprestimo->setDataAbertura($row['data_abertura']);
        $emprestimo->setObservacao($row['observacao']);
        $emprestimo->setSituacao($row['situacao']);       
        $emprestimo->setIdUsuario($row['id_usuario']);  
        
        #Usuário
        $usuario = new Usuario($row['id_usuario']);
        $emprestimo->setUsuario($usuario->getById());
    
        return $emprestimo;
    }
    
    public function getAll() {
        $sql = "select * from emprestimo order by id ";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result;
    }

    public function getById() {
        $sql = "select * from emprestimo where id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
    }

    static function create($params) {
        $sql = "INSERT INTO emprestimo (id_usuario, nome) VALUES (?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['id_usuario'],  
            $params['nome']
        ));        
        return $stmt->errorInfo(); 
        
    }

    static function delete($id) {
        $sql = 'DELETE FROM emprestimo WHERE id = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }

    public function update($params) {
        $sql = "UPDATE emprestimo set nome = ? WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($params['nome'], $this->id));
        return $stmt->errorInfo();
    }

    public function adicionarItemEmprestimo(ItemEmprestimo $item) {
        $this->itensEmprestimo[] = $item;
    }

    public function removerItemEmprestimo(ItemEmprestimo $item) {
        $index = array_search($item, $this->itensEmprestimo);
        if ($index !== false) {
            unset($this->itensEmprestimo[$index]);
        }
    }
    
    public function limparItensEmprestimo() {
        $this->itensEmprestimo = array();
    }
    
    public function detalhar() {
        
    }
    
    public function getId() {
        return $this->id;
    }
    
    
    public function getMatSolic() {
        return $this->mat_solic;
    }

    public function getMatUserAbertura() {
        return $this->mat_user_abertura;
    }

    public function getMatUserDevolucao() {
        return $this->mat_user_devolucao;
    }

    public function getDataAbertura() {
        return $this->data_abertura;
    }

    public function getDataDevolucao() {
        return $this->data_devolucao;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }  
    
    public function getChaves() {
        if (empty($this->chaves)){
            $this->chaves = ItemEmprestimo::getByEmprestimo($this->id);
        }
        return $this->chaves;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setMatSolic($mat_solic) {
        $this->mat_solic = $mat_solic;
    }
    
    
    public function setMatUserAbertura($mat_user_abertura) {
        $this->mat_user_abertura = $mat_user_abertura;
    }

    public function setMatUserDevolucao($mat_user_devolucao) {
        $this->mat_user_devolucao = $mat_user_devolucao;
    }

    public function setDataAbertura($data_abertura) {
        $this->data_abertura = $data_abertura;
    }

    public function setDataDevolucao($data_devolucao) {
        $this->data_devolucao = $data_devolucao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    } 

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    
    
    
}