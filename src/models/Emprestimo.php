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
        
    private $solicitante;
    private $user_abertura;
    private $user_devolucao;
    
    private $chaves = [];
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    private function bundle ($row){

        #Usuários
        $solicitante = (new Usuario())->getByMatricula($row['mat_solic']);
        $user_abertura = (new Usuario())->getByMatricula($row['mat_user_abertura']);
        $user_devolucao = (new Usuario())->getByMatricula($row['mat_user_devolucao']);
        
        #Emprestimo     
        $emprestimo = new Emprestimo($row['id']);               
                 
        $emprestimo->setMatSolic($row['mat_solic']);
        $emprestimo->setMatUserAbertura($row['mat_user_abertura']);
        $emprestimo->setDataAbertura($row['data_abertura']);
        $emprestimo->setDataDevolucao($row['data_devolucao']);
        $emprestimo->setObservacao($row['observacao']);
        $emprestimo->setSituacao($row['situacao']); 
        $emprestimo->setChaves($row['chaves']); 
        
        $emprestimo->setSolicitante($solicitante);
        $emprestimo->setUser_abertura($user_abertura);
        $emprestimo->setUser_devolucao($user_devolucao);
         
        return $emprestimo;
    }
    
    public function getAll() {
        $sql = "select * from emprestimo order by data_abertura DESC ";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result;
    }
    
    public function getMyEmprestimos($mat_solic) {
        $sql = "select * from emprestimo WHERE mat_solic = ? order by data_abertura DESC";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($mat_solic));
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result; 
    }
    
    public function getAtivos() {
        $sql = "select * from emprestimo WHERE situacao = 'Aberto' order by data_abertura DESC ";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, self::bundle($row));
        }
        return $result;
    }
    
    public function getEncerrados() {
        $sql = "select * from emprestimo WHERE situacao = 'Devolvido' order by data_abertura DESC ";
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
        $sql = "INSERT INTO emprestimo (mat_solic, mat_user_abertura) VALUES (?, ?)";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array(
            $params['mat_solic'],  
            $params['mat_user_abertura']
        ));        
        return $stmt->errorInfo(); 
    }
      
    static function delete($id) {
        $sql = 'DELETE FROM emprestimo WHERE id = ?';
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->errorInfo();
    }
    
    static function encerrar($id_emprestimo, $mat_user) {      
        
        $sql = "UPDATE emprestimo "
                . "SET data_devolucao = CURRENT_TIME(), mat_user_devolucao = ?, situacao = 'Devolvido' "
                . "WHERE id = ?";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($mat_user, $id_emprestimo));        
        return $stmt->errorInfo();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUserName() {
        $sql = "select nome "
                . "from usuario u"
                . "INNER JOIN emprestimo e on e.id = u.id";
        $stmt = DBSigec::getKeys()->prepare($sql);
        $stmt->execute(array($this->id));
        $row = $stmt->fetch();
        if ($row == null) {
            return null;
        }
        return self::bundle($row);
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
    
    public function getSolicitante() {
        return $this->solicitante;
    }

    public function getUser_abertura() {
        return $this->user_abertura;
    }

    public function getUser_devolucao() {
        return $this->user_devolucao;
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
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    public function setSolicitante($solicitante): void {
        $this->solicitante = $solicitante;
    }

    public function setUser_abertura($user_abertura): void {
        $this->user_abertura = $user_abertura;
    }

    public function setUser_devolucao($user_devolucao): void {
        $this->user_devolucao = $user_devolucao;
    }

    public function setChaves($chaves) {
        $this->chaves = $chaves;
    }
    
}